<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    // Show the calendar with dynamic month navigation
    public function index(Request $request)
    {
        // 1. Get month/year from URL, default to current "now"
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // 2. Create a Carbon instance for the selected month
        $selectedDate = Carbon::createFromDate($year, $month, 1);

        // 3. Calculate Previous and Next month instances for the links
        $prevDate = $selectedDate->copy()->subMonth();
        $nextDate = $selectedDate->copy()->addMonth();

        // 4. Fetch schedules only for the selected month and year
        $schedules = Schedule::whereYear('schedule_date', $year)
            ->whereMonth('schedule_date', $month)
            ->orderBy('schedule_time', 'asc')
            ->get()
            ->groupBy('schedule_date');

        // 5. Fetch upcoming activities for the sidebar (Starts from today)
        // We use whereDate to ensure events earlier today are still shown
        $upcomingActivities = Schedule::whereDate('schedule_date', '>=', Carbon::today())
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

    // Save the event
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'schedule_date' => 'required|date',
            'schedule_time' => 'required',
            'schedule_time_to' => 'required',
        ]);

        Schedule::create($validated);

        return redirect()->back()->with('success', 'New Event Added Successfully!');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Event Deleted Successfully!');
    }
}