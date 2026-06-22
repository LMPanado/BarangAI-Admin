<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::latest('created_at');

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_email', 'ilike', '%' . $request->search . '%')
                  ->orWhere('message', 'ilike', '%' . $request->search . '%');
            });
        }

        $complaints = $query->paginate(10)->withQueryString();

        // Summary counts
        $totalComplaints  = Complaint::count();
        $openComplaints   = Complaint::where('status', 'open')->count();
        $closedComplaints = Complaint::where('status', 'closed')->count();

        $bySeverity = [
            'critical' => Complaint::where('severity', 'critical')->count(),
            'medium'   => Complaint::where('severity', 'medium')->count(),
            'low'      => Complaint::where('severity', 'low')->count(),
        ];

        return view('admin.reports.index', compact(
            'complaints', 'totalComplaints', 'openComplaints', 'closedComplaints', 'bySeverity'
        ));
    }

    public function feedback(Request $request)
    {
        $query = Feedback::latest('created_at');

        if ($request->filled('sentiment')) {
            $query->where('sentiment', $request->sentiment);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_email', 'ilike', '%' . $request->search . '%')
                  ->orWhere('message', 'ilike', '%' . $request->search . '%');
            });
        }

        $feedbacks = $query->paginate(10)->withQueryString();

        $total    = Feedback::count();
        $positive = Feedback::where('sentiment', 'positive')->count();
        $neutral  = Feedback::where('sentiment', 'neutral')->count();
        $negative = Feedback::where('sentiment', 'negative')->count();
        $unrated  = Feedback::whereNull('sentiment')->count();

        $sentimentCounts = [
            'positive' => $positive,
            'neutral'  => $neutral,
            'negative' => $negative,
            'unrated'  => $unrated,
        ];

        return view('admin.feedback.index', compact(
            'feedbacks', 'sentimentCounts', 'total'
        ));
    }
}
