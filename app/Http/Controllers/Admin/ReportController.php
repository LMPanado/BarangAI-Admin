<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [5, 12, 8, 15, 7, 20, 14, 10, 18, 25, 22, 30]
        ];

        return view('admin.reports.index', compact('chartData'));
    }

    // FIXED: Added feedback method with placeholders
    public function feedback()
    {
        // Placeholder Sentiment Counts for the Doughnut Chart
        $sentimentCounts = [
            'positive' => 55,
            'neutral'  => 30,
            'negative' => 15
        ];

        // Placeholder Resident Feedbacks for the list
        $feedbacks = [
            (object)[
                'resident' => 'Juan Dela Cruz',
                'comment' => 'The street lighting is much better now. I feel safer at night!',
                'sentiment' => 'positive',
                'date' => '2026-02-20'
            ],
            (object)[
                'resident' => 'Maria Santos',
                'comment' => 'The trash collection was a bit delayed today.',
                'sentiment' => 'negative',
                'date' => '2026-02-18'
            ],
            (object)[
                'resident' => 'Pedro Penduko',
                'comment' => 'Waiting for the update on my clearance request.',
                'sentiment' => 'neutral',
                'date' => '2026-02-15'
            ],
        ];

        return view('admin.feedback.index', compact('sentimentCounts', 'feedbacks'));
    }
}