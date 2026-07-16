<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $selectedDate = Carbon::createFromDate($year, $month, 1);
        $prevDate = $selectedDate->copy()->subMonth();
        $nextDate = $selectedDate->copy()->addMonth();

        $schedules = Schedule::whereMonth('schedule_date', $month)
            ->whereYear('schedule_date', $year)
            ->get()
            ->groupBy('schedule_date');

        $upcomingActivities = Schedule::whereRaw("(schedule_date::date + schedule_time_to::time) > NOW() AT TIME ZONE 'Asia/Manila'")
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc')
            ->take(5)
            ->get();

        return view('admin.schedules.index', compact(
            'schedules', 
            'selectedDate', 
            'prevDate', 
            'nextDate', 
            'upcomingActivities'
        ));
    }

    public function create(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        return view('admin.schedules.create', compact('date'));
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'                 => 'required|string|max:255',
            'schedule_date'         => 'required|date',
            'schedule_time'         => 'required',
            'schedule_time_to'      => 'required',
            'location'              => 'nullable|string',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'age_groups'            => 'nullable|array',
            'age_groups.*'          => 'in:youth,adults,senior',
            'children_age_groups'   => 'nullable|array',
            'children_age_groups.*' => 'in:0-2,3-5,6-12',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $ageGroups         = $request->input('age_groups', ['youth', 'adults', 'senior']);
        $childrenAgeGroups = $request->input('children_age_groups', []);
        $validated['age_groups'] = $ageGroups;

        $schedule = Schedule::create($validated);

        \Illuminate\Support\Facades\DB::statement(
            'UPDATE schedules SET age_groups = ? WHERE id = ?',
            ['{' . implode(',', $ageGroups) . '}', $schedule->id]
        );

        $this->notifyByAgeGroups($schedule, $ageGroups, $childrenAgeGroups);

        AuditLogger::log('created', 'Schedule', $schedule->title . ' on ' . $schedule->schedule_date, $schedule->id);

        return redirect()->route('admin.schedules.index')->with('success', 'Event created successfully!');
    }

    private function notifyByAgeGroups(Schedule $schedule, array $ageGroups, array $childrenAgeGroups = []): void
    {
        $conditions = [];
        if (in_array('youth',  $ageGroups)) $conditions[] = "EXTRACT(YEAR FROM AGE(birth_date)) BETWEEN 13 AND 17";
        if (in_array('adults', $ageGroups)) $conditions[] = "EXTRACT(YEAR FROM AGE(birth_date)) BETWEEN 18 AND 59";
        if (in_array('senior', $ageGroups)) $conditions[] = "EXTRACT(YEAR FROM AGE(birth_date)) >= 60";

        $whereAge = empty($conditions) ? '1=1' : '(' . implode(' OR ', $conditions) . ')';

        $users = \Illuminate\Support\Facades\DB::select(
            "SELECT fcm_token FROM users WHERE fcm_token IS NOT NULL AND birth_date IS NOT NULL AND {$whereAge}"
        );

        // If all three groups selected, also include users with no birth_date
        if (count($ageGroups) === 3) {
            $extra = \Illuminate\Support\Facades\DB::select(
                "SELECT fcm_token FROM users WHERE fcm_token IS NOT NULL AND birth_date IS NULL"
            );
            $users = array_merge($users, $extra);
        }

        // Also notify parents whose children match the selected children age groups
        if (!empty($childrenAgeGroups)) {
            $childConditions = array_map(
                fn($g) => "children @> '[{\"age_group\": \"" . addslashes($g) . "\"}]'::jsonb",
                $childrenAgeGroups
            );
            $parentUsers = \Illuminate\Support\Facades\DB::select(
                "SELECT fcm_token FROM users WHERE fcm_token IS NOT NULL AND (" . implode(' OR ', $childConditions) . ")"
            );
            $users = array_merge($users, $parentUsers);
        }

        // Deduplicate by fcm_token
        $seen  = [];
        $users = array_filter($users, function ($u) use (&$seen) {
            if (!$u->fcm_token || isset($seen[$u->fcm_token])) return false;
            $seen[$u->fcm_token] = true;
            return true;
        });

        $supabaseUrl = 'https://ypcumosboftjylrnmyih.supabase.co/functions/v1/send-notification';
        $serviceKey  = env('SUPABASE_SERVICE_KEY');
        $date        = \Carbon\Carbon::parse($schedule->schedule_date)->format('M d, Y');

        foreach ($users as $user) {
            try {
                \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . $serviceKey,
                    'Content-Type'  => 'application/json',
                ])->post($supabaseUrl, [
                    'token' => $user->fcm_token,
                    'title' => 'New Event: ' . $schedule->title,
                    'body'  => $date . ($schedule->location ? ' at ' . $schedule->location : ''),
                    'data'  => ['type' => 'new_event', 'schedule_id' => (string) $schedule->id],
                ]);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Event notify failed: ' . $e->getMessage());
            }
        }
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'schedule_time_to' => 'required',
            'location' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle Image Deletion via "X" button
        if ($request->remove_image == '1' && !$request->hasFile('image')) {
            if ($schedule->image) {
                Storage::disk('public')->delete($schedule->image);
            }
            $validated['image'] = null;
        }

        // Handle New Image Upload
        if ($request->hasFile('image')) {
            if ($schedule->image) {
                Storage::disk('public')->delete($schedule->image);
            }
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $schedule->update($validated);

        AuditLogger::log('updated', 'Schedule', $schedule->title . ' on ' . $schedule->schedule_date, $schedule->id);

        return redirect()->route('admin.schedules.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Schedule $schedule)
    {
        AuditLogger::log('deleted', 'Schedule', $schedule->title . ' on ' . $schedule->schedule_date, $schedule->id);
        if ($schedule->image) {
            Storage::disk('public')->delete($schedule->image);
        }
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Event deleted!');
    }
}