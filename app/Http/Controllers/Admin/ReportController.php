<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\DocumentRequest;
use App\Models\Feedback;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        // Residents
        $totalResidents  = Resident::count();
        $maleCount       = Resident::where('gender', 'Male')->count();
        $femaleCount     = Resident::where('gender', 'Female')->count();
        $voterCount      = Resident::where('is_voter', true)->count();
        $newResidents    = Resident::whereYear('created_at', $year)->whereMonth('created_at', $mon)->count();

        $ageGroups = [
            'Children (0–12)'  => Resident::whereBetween('age', [0, 12])->count(),
            'Teens (13–17)'    => Resident::whereBetween('age', [13, 17])->count(),
            'Adults (18–59)'   => Resident::whereBetween('age', [18, 59])->count(),
            'Seniors (60+)'    => Resident::where('age', '>=', 60)->count(),
        ];

        // Document Requests
        $totalDocs        = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)->count();
        $pendingDocs      = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('status', 'pending')->count();
        $approvedDocs     = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('status', 'approved')->count();
        $rejectedDocs     = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('status', 'rejected')->count();

        $docsByType = DocumentRequest::whereYear('created_at', $year)
            ->whereMonth('created_at', $mon)
            ->selectRaw('document_type, count(*) as total')
            ->groupBy('document_type')
            ->orderByDesc('total')
            ->get();

        // Complaints
        $totalComplaints    = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)->count();
        $openComplaints     = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('status', 'open')->count();
        $closedComplaints   = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('status', 'closed')->count();
        $criticalComplaints = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('severity', 'critical')->count();

        // Feedback
        $totalFeedback   = Feedback::whereYear('created_at', $year)->whereMonth('created_at', $mon)->count();
        $positiveFeedback = Feedback::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('sentiment', 'positive')->count();
        $negativeFeedback = Feedback::whereYear('created_at', $year)->whereMonth('created_at', $mon)->where('sentiment', 'negative')->count();

        return view('admin.reports.index', compact(
            'month', 'year', 'mon',
            'totalResidents', 'maleCount', 'femaleCount', 'voterCount', 'newResidents', 'ageGroups',
            'totalDocs', 'pendingDocs', 'approvedDocs', 'rejectedDocs', 'docsByType',
            'totalComplaints', 'openComplaints', 'closedComplaints', 'criticalComplaints',
            'totalFeedback', 'positiveFeedback', 'negativeFeedback'
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

    public function replyFeedback(Request $request, $id)
    {
        $request->validate(['reply' => 'required|string|max:1000']);

        $feedback = Feedback::findOrFail($id);
        $user     = Auth::user();

        $feedback->update([
            'admin_reply' => $request->reply,
            'replied_at'  => now(),
            'replied_by'  => $user->first_name . ' ' . $user->last_name,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'reply'      => $feedback->admin_reply,
                'replied_by' => $feedback->replied_by,
                'replied_at' => $feedback->replied_at->format('M d, Y · h:i A'),
            ]);
        }

        return back()->with('success', 'Reply sent successfully.');
    }
}
