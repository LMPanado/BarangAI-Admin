<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintMessage;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'severity');

        $query = Complaint::query();

        if ($sort === 'latest') {
            $query->latest('created_at');
        } else {
            $query->orderByRaw("CASE severity WHEN 'critical' THEN 1 WHEN 'medium' THEN 2 WHEN 'low' THEN 3 ELSE 4 END")
                  ->latest('created_at');
        }

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
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $complaints = $query->paginate(10)->withQueryString();

        // Load message count per complaint for the current page
        $messageCounts = ComplaintMessage::whereIn('complaint_id', $complaints->pluck('id'))
            ->selectRaw('complaint_id, COUNT(*) as cnt')
            ->groupBy('complaint_id')
            ->pluck('cnt', 'complaint_id');

        // One query for all summary counts
        $stats = Complaint::selectRaw("
            COUNT(*) as total,
            COUNT(*) FILTER (WHERE status = 'open') as open,
            COUNT(*) FILTER (WHERE status = 'closed') as closed,
            COUNT(*) FILTER (WHERE severity = 'critical') as critical,
            COUNT(*) FILTER (WHERE severity = 'medium') as medium,
            COUNT(*) FILTER (WHERE severity = 'low') as low
        ")->first();

        $totalComplaints  = $stats->total;
        $openComplaints   = $stats->open;
        $closedComplaints = $stats->closed;
        $bySeverity = ['critical' => $stats->critical, 'medium' => $stats->medium, 'low' => $stats->low];

        return view('admin.complaints.index', compact(
            'complaints', 'totalComplaints', 'openComplaints', 'closedComplaints', 'bySeverity', 'sort', 'messageCounts'
        ));
    }

    public function sendMessage(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        ComplaintMessage::create([
            'complaint_id'    => $complaint->id,
            'admin_id'        => auth()->id(),
            'recipient_email' => $complaint->user_email,
            'message'         => $request->message,
        ]);

        AuditLogger::log('updated', 'Complaint',
            'Message sent to complainant ' . $complaint->user_email . ' for Complaint #' . $id,
            $id
        );

        return back()->with('success', 'Message sent to ' . $complaint->user_email . '.');
    }

    public function updateStatus(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $request->validate(['status' => 'required|in:open,closed']);
        $complaint->update(['status' => $request->status]);
        AuditLogger::log('updated', 'Complaint', 'Complaint #' . $id . ' status → ' . $request->status, $id);
        return redirect()->back()->with('success', 'Complaint status updated.');
    }
}
