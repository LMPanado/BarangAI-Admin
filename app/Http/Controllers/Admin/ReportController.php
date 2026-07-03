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

        // All-time resident stats
        $residentStats = Resident::selectRaw("
            COUNT(*) as total,
            COUNT(*) FILTER (WHERE gender = 'Male') as male,
            COUNT(*) FILTER (WHERE gender = 'Female') as female,
            COUNT(*) FILTER (WHERE is_voter = true) as voters,
            COUNT(*) FILTER (WHERE EXTRACT(YEAR FROM created_at) = ? AND EXTRACT(MONTH FROM created_at) = ?) as new_this_month,
            COUNT(*) FILTER (WHERE age BETWEEN 0 AND 12) as children,
            COUNT(*) FILTER (WHERE age BETWEEN 13 AND 17) as teens,
            COUNT(*) FILTER (WHERE age BETWEEN 18 AND 59) as adults,
            COUNT(*) FILTER (WHERE age >= 60) as seniors
        ", [$year, $mon])->first();

        $totalResidents = $residentStats->total;
        $maleCount      = $residentStats->male;
        $femaleCount    = $residentStats->female;
        $voterCount     = $residentStats->voters;
        $newResidents   = $residentStats->new_this_month;
        $ageGroups      = [
            'Children (0–12)'  => $residentStats->children,
            'Teens (13–17)'    => $residentStats->teens,
            'Adults (18–59)'   => $residentStats->adults,
            'Seniors (60+)'    => $residentStats->seniors,
        ];

        // All-time glance totals
        $allTimeDocs      = DocumentRequest::count();
        $allTimeComplaints = Complaint::count();
        $allTimeFeedback  = Feedback::count();

        // Monthly document request stats
        $docStats = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = 'pending') as pending,
                COUNT(*) FILTER (WHERE status = 'approved') as approved,
                COUNT(*) FILTER (WHERE status = 'rejected') as rejected
            ")->first();

        $totalDocs    = $docStats->total;
        $pendingDocs  = $docStats->pending;
        $approvedDocs = $docStats->approved;
        $rejectedDocs = $docStats->rejected;

        $docsByType = DocumentRequest::whereYear('created_at', $year)
            ->whereMonth('created_at', $mon)
            ->selectRaw('document_type, count(*) as total')
            ->groupBy('document_type')
            ->orderByDesc('total')
            ->get();

        // Monthly complaint stats
        $complaintStats = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = 'open') as open,
                COUNT(*) FILTER (WHERE status = 'closed') as closed,
                COUNT(*) FILTER (WHERE severity = 'critical') as critical
            ")->first();

        $totalComplaints    = $complaintStats->total;
        $openComplaints     = $complaintStats->open;
        $closedComplaints   = $complaintStats->closed;
        $criticalComplaints = $complaintStats->critical;

        // Monthly feedback stats
        $feedbackStats = Feedback::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE sentiment = 'positive') as positive,
                COUNT(*) FILTER (WHERE sentiment = 'negative') as negative
            ")->first();

        $totalFeedback    = $feedbackStats->total;
        $positiveFeedback = $feedbackStats->positive;
        $negativeFeedback = $feedbackStats->negative;

        return view('admin.reports.index', compact(
            'month', 'year', 'mon',
            'totalResidents', 'maleCount', 'femaleCount', 'voterCount', 'newResidents', 'ageGroups',
            'allTimeDocs', 'allTimeComplaints', 'allTimeFeedback',
            'totalDocs', 'pendingDocs', 'approvedDocs', 'rejectedDocs', 'docsByType',
            'totalComplaints', 'openComplaints', 'closedComplaints', 'criticalComplaints',
            'totalFeedback', 'positiveFeedback', 'negativeFeedback'
        ));
    }

    public function printReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        $residentStats = Resident::selectRaw("
            COUNT(*) as total,
            COUNT(*) FILTER (WHERE gender = 'Male') as male,
            COUNT(*) FILTER (WHERE gender = 'Female') as female,
            COUNT(*) FILTER (WHERE is_voter = true) as voters,
            COUNT(*) FILTER (WHERE EXTRACT(YEAR FROM created_at) = ? AND EXTRACT(MONTH FROM created_at) = ?) as new_this_month,
            COUNT(*) FILTER (WHERE age BETWEEN 0 AND 12) as children,
            COUNT(*) FILTER (WHERE age BETWEEN 13 AND 17) as teens,
            COUNT(*) FILTER (WHERE age BETWEEN 18 AND 59) as adults,
            COUNT(*) FILTER (WHERE age >= 60) as seniors
        ", [$year, $mon])->first();

        $totalResidents = $residentStats->total;
        $maleCount      = $residentStats->male;
        $femaleCount    = $residentStats->female;
        $newResidents   = $residentStats->new_this_month;
        $ageGroups      = [
            'Children (0–12)'  => $residentStats->children,
            'Teens (13–17)'    => $residentStats->teens,
            'Adults (18–59)'   => $residentStats->adults,
            'Seniors (60+)'    => $residentStats->seniors,
        ];

        $allTimeDocs       = DocumentRequest::count();
        $allTimeComplaints = Complaint::count();
        $allTimeFeedback   = Feedback::count();

        $docStats = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = 'pending') as pending,
                COUNT(*) FILTER (WHERE status = 'approved') as approved,
                COUNT(*) FILTER (WHERE status = 'rejected') as rejected
            ")->first();

        $totalDocs    = $docStats->total;
        $pendingDocs  = $docStats->pending;
        $approvedDocs = $docStats->approved;
        $rejectedDocs = $docStats->rejected;

        $docsByType = DocumentRequest::whereYear('created_at', $year)
            ->whereMonth('created_at', $mon)
            ->selectRaw('document_type, count(*) as total')
            ->groupBy('document_type')
            ->orderByDesc('total')
            ->get();

        $complaintStats = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = 'open') as open,
                COUNT(*) FILTER (WHERE status = 'closed') as closed,
                COUNT(*) FILTER (WHERE severity = 'critical') as critical
            ")->first();

        $totalComplaints    = $complaintStats->total;
        $openComplaints     = $complaintStats->open;
        $closedComplaints   = $complaintStats->closed;
        $criticalComplaints = $complaintStats->critical;

        $feedbackStats = Feedback::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE sentiment = 'positive') as positive,
                COUNT(*) FILTER (WHERE sentiment = 'negative') as negative
            ")->first();

        $totalFeedback    = $feedbackStats->total;
        $positiveFeedback = $feedbackStats->positive;
        $negativeFeedback = $feedbackStats->negative;

        return view('Admin.reports.print', compact(
            'month', 'year', 'mon',
            'totalResidents', 'maleCount', 'femaleCount', 'newResidents', 'ageGroups',
            'allTimeDocs', 'allTimeComplaints', 'allTimeFeedback',
            'totalDocs', 'pendingDocs', 'approvedDocs', 'rejectedDocs', 'docsByType',
            'totalComplaints', 'openComplaints', 'closedComplaints', 'criticalComplaints',
            'totalFeedback', 'positiveFeedback', 'negativeFeedback'
        ));
    }

    public function exportCsv(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        [$year, $mon] = explode('-', $month);

        $filename = 'barangay419-report-' . $month . '.csv';

        $out = fopen('php://temp', 'r+');

        // Document Requests
        fputcsv($out, ['=== DOCUMENT REQUESTS ===']);
        fputcsv($out, ['ID', 'Full Name', 'Document Type', 'Status', 'Purpose', 'Pickup Date', 'Reference No', 'Submitted At']);
        $docs = DocumentRequest::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->orderBy('created_at')->get();
        foreach ($docs as $d) {
            fputcsv($out, [
                $d->id,
                $d->full_name ?? '',
                $d->document_type ?? '',
                $d->status ?? '',
                $d->purpose ?? '',
                $d->pickup_date ?? '',
                $d->reference_no ?? '',
                $d->created_at?->format('Y-m-d H:i:s') ?? '',
            ]);
        }

        fputcsv($out, []);

        // Complaints
        fputcsv($out, ['=== COMPLAINTS ===']);
        fputcsv($out, ['ID', 'Resident Email', 'Message', 'Status', 'Severity', 'Severity Score', 'AI Summary', 'Submitted At']);
        $complaints = Complaint::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->orderBy('created_at')->get();
        foreach ($complaints as $c) {
            fputcsv($out, [
                $c->id,
                $c->user_email ?? '',
                $c->message ?? '',
                $c->status ?? '',
                $c->severity ?? '',
                $c->severity_score ?? '',
                $c->ai_summary ?? '',
                $c->created_at?->format('Y-m-d H:i:s') ?? '',
            ]);
        }

        fputcsv($out, []);

        // Feedback
        fputcsv($out, ['=== FEEDBACK ===']);
        fputcsv($out, ['ID', 'Resident Email', 'Message', 'Category', 'Sentiment', 'Sentiment Score', 'AI Summary', 'Submitted At']);
        $feedbacks = Feedback::whereYear('created_at', $year)->whereMonth('created_at', $mon)
            ->orderBy('created_at')->get();
        foreach ($feedbacks as $f) {
            fputcsv($out, [
                $f->id,
                $f->user_email ?? '',
                $f->message ?? '',
                $f->category ?? '',
                $f->sentiment ?? '',
                $f->sentiment_score ?? '',
                $f->ai_summary ?? '',
                $f->created_at?->format('Y-m-d H:i:s') ?? '',
            ]);
        }

        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
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

        $fs = Feedback::selectRaw("
            COUNT(*) as total,
            COUNT(*) FILTER (WHERE sentiment = 'positive') as positive,
            COUNT(*) FILTER (WHERE sentiment = 'neutral') as neutral,
            COUNT(*) FILTER (WHERE sentiment = 'negative') as negative,
            COUNT(*) FILTER (WHERE sentiment IS NULL) as unrated
        ")->first();

        $total = $fs->total;
        $sentimentCounts = [
            'positive' => $fs->positive,
            'neutral'  => $fs->neutral,
            'negative' => $fs->negative,
            'unrated'  => $fs->unrated,
        ];

        return view('admin.feedback.index', compact(
            'feedbacks', 'sentimentCounts', 'total'
        ));
    }

    public function destroyFeedback($id)
    {
        Feedback::findOrFail($id)->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Feedback deleted.');
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
