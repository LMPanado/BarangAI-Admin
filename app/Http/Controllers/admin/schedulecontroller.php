<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
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

        $upcomingActivities = Schedule::where('schedule_date', '>=', Carbon::today())
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'schedule_time_to' => 'required',
            'location' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')->with('success', 'Event created successfully!');
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

        return redirect()->route('admin.schedules.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Schedule $schedule)
    {
        if ($schedule->image) {
            Storage::disk('public')->delete($schedule->image);
        }
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Event deleted!');
    }
}