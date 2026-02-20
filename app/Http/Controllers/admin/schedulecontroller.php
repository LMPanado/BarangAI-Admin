<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $selectedDate = Carbon::createFromDate($year, $month, 1);

        $prevDate = $selectedDate->copy()->subMonth();
        $nextDate = $selectedDate->copy()->addMonth();

        // Fetches schedules for the month
        $schedules = Schedule::whereYear('schedule_date', $year)
            ->whereMonth('schedule_date', $month)
            ->orderBy('schedule_date', 'asc')
            ->orderBy('schedule_time', 'asc') // Only works if Step 1 is done
            ->get()
            ->groupBy(function($data) {
                return Carbon::parse($data->schedule_date)->format('Y-m-d');
            });

        $upcomingActivities = Schedule::whereDate('schedule_date', '>=', Carbon::today())
            ->orderBy('schedule_date', 'asc')
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
        ]);

        // This will now work correctly after the migration refresh
        Schedule::create($validated);

        return redirect()->back()->with('success', 'New Event Added Successfully!');
    }
}