<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Models\Schedule;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // --- Resident Stats ---
        $totalResidents   = Resident::count();
        $maleCount        = Resident::where('gender', 'Male')->count();
        $femaleCount      = Resident::where('gender', 'Female')->count();
        $voterCount       = Resident::where('is_voter', true)->count();
        $nonVoterCount    = $totalResidents - $voterCount;

        // Civil status breakdown
        $civilStatus = Resident::selectRaw('civil_status, count(*) as total')
            ->whereNotNull('civil_status')
            ->groupBy('civil_status')
            ->pluck('total', 'civil_status');

        // Age group breakdown
        $ageGroups = [
            'Children (0–12)'   => Resident::whereBetween('age', [0, 12])->count(),
            'Teens (13–17)'     => Resident::whereBetween('age', [13, 17])->count(),
            'Adults (18–59)'    => Resident::whereBetween('age', [18, 59])->count(),
            'Seniors (60+)'     => Resident::where('age', '>=', 60)->count(),
        ];

        // New residents per month for current year
        $residentsByMonth = Resident::selectRaw("to_char(created_at, 'Mon') as month, EXTRACT(MONTH FROM created_at) as month_num, count(*) as total")
            ->whereYear('created_at', $now->year)
            ->groupByRaw("to_char(created_at, 'Mon'), EXTRACT(MONTH FROM created_at)")
            ->orderByRaw("EXTRACT(MONTH FROM created_at)")
            ->pluck('total', 'month');

        $monthLabels     = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $residentChartData = array_map(fn($m) => $residentsByMonth[$m] ?? 0, $monthLabels);

        // --- Document Request Stats ---
        $totalRequests   = DocumentRequest::count();
        $pendingRequests = DocumentRequest::where('status', 'pending')->count();
        $readyRequests   = DocumentRequest::where('status', 'ready')->count();
        $releasedRequests= DocumentRequest::where('status', 'released')->count();

        // Requests by document type
        $requestsByType = DocumentRequest::selectRaw('document_type, count(*) as total')
            ->groupBy('document_type')
            ->orderByDesc('total')
            ->pluck('total', 'document_type');

        // Requests per month for current year
        $requestsByMonth = DocumentRequest::selectRaw("to_char(created_at, 'Mon') as month, EXTRACT(MONTH FROM created_at) as month_num, count(*) as total")
            ->whereYear('created_at', $now->year)
            ->groupByRaw("to_char(created_at, 'Mon'), EXTRACT(MONTH FROM created_at)")
            ->orderByRaw("EXTRACT(MONTH FROM created_at)")
            ->pluck('total', 'month');

        $requestChartData = array_map(fn($m) => $requestsByMonth[$m] ?? 0, $monthLabels);

        // --- Schedule / Event Stats ---
        $totalEvents    = Schedule::count();
        $upcomingEvents = Schedule::where('schedule_date', '>=', $now->toDateString())->count();
        $pastEvents     = Schedule::where('schedule_date', '<', $now->toDateString())->count();
        $thisMonthEvents= Schedule::whereMonth('schedule_date', $now->month)
                            ->whereYear('schedule_date', $now->year)->count();

        // --- Announcement Stats ---
        $totalAnnouncements  = Announcement::count();
        $pinnedAnnouncements = Announcement::where('is_pinned', true)->count();
        $announcementsByCategory = Announcement::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->pluck('total', 'category');

        // --- Recent document requests (latest 10) ---
        $recentRequests = DocumentRequest::with('resident')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalResidents', 'maleCount', 'femaleCount', 'voterCount', 'nonVoterCount',
            'civilStatus', 'ageGroups',
            'monthLabels', 'residentChartData',
            'totalRequests', 'pendingRequests', 'readyRequests', 'releasedRequests',
            'requestsByType', 'requestChartData',
            'totalEvents', 'upcomingEvents', 'pastEvents', 'thisMonthEvents',
            'totalAnnouncements', 'pinnedAnnouncements', 'announcementsByCategory',
            'recentRequests'
        ));
    }

    public function feedback()
    {
        $sentimentCounts = ['positive' => 0, 'neutral' => 0, 'negative' => 0];
        $feedbacks = [];
        return view('admin.feedback.index', compact('sentimentCounts', 'feedbacks'));
    }
}
