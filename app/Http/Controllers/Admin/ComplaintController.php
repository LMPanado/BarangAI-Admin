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

        $openList   = (clone $query)->where('status', 'open')->with('residentUser')->paginate(10, ['*'], 'open_page')->withQueryString();
        $closedList = (clone $query)->where('status', 'closed')->with('residentUser')->paginate(10, ['*'], 'closed_page')->withQueryString();

        $allIds = $openList->pluck('id')->merge($closedList->pluck('id'));
        $messageCounts = ComplaintMessage::whereIn('complaint_id', $allIds)
            ->selectRaw('complaint_id, COUNT(*) as cnt')
            ->groupBy('complaint_id')
            ->pluck('cnt', 'complaint_id');

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
            'openList', 'closedList', 'totalComplaints', 'openComplaints', 'closedComplaints', 'bySeverity', 'sort', 'messageCounts'
        ));
    }

    public function getMessages($id)
    {
        $complaint = Complaint::findOrFail($id);

        $messages = ComplaintMessage::where('complaint_id', $id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'          => $m->id,
                'message'     => $m->message,
                'sender_type' => $m->sender_type,
                'sender_name' => $m->sender_name,
                'is_read'     => $m->is_read,
                'created_at'  => $m->created_at->format('M d, Y h:i A'),
            ]);

        return response()->json([
            'complaint' => [
                'id'         => $complaint->id,
                'user_email' => $complaint->user_email,
                'message'    => $complaint->message,
                'severity'   => $complaint->severity,
                'status'     => $complaint->status,
            ],
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $admin = auth()->user();

        ComplaintMessage::create([
            'complaint_id'    => $complaint->id,
            'admin_id'        => $admin->id,
            'recipient_email' => $complaint->user_email,
            'message'         => $request->message,
            'sender_type'     => 'admin',
            'sender_name'     => $admin->first_name . ' ' . $admin->last_name,
        ]);

        try {
            $fcmToken = \Illuminate\Support\Facades\DB::selectOne(
                'SELECT fcm_token FROM users WHERE supabase_uid = (SELECT supabase_uid FROM complaints WHERE id = ?)',
                [$complaint->id]
            )?->fcm_token;

            \Illuminate\Support\Facades\Log::info('FCM debug complaint #' . $complaint->id, [
                'fcm_token'    => $fcmToken ?? 'NULL',
                'complaint_id' => $complaint->id,
                'supabase_uid' => $complaint->supabase_uid ?? 'not loaded',
            ]);

            if ($fcmToken) {
                $body = mb_strlen($request->message) > 100
                    ? mb_substr($request->message, 0, 97) . '...'
                    : $request->message;

                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_KEY'),
                    'Content-Type'  => 'application/json',
                ])->post('https://ypcumosboftjylrnmyih.supabase.co/functions/v1/send-notification', [
                    'token' => $fcmToken,
                    'title' => 'Barangay 419 replied to your complaint',
                    'body'  => $body,
                    'data'  => [
                        'type'         => 'complaint_reply',
                        'complaint_id' => (string) $complaint->id,
                    ],
                ]);

                \Illuminate\Support\Facades\Log::info('FCM response complaint #' . $complaint->id, [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('FCM notification failed for complaint #' . $complaint->id . ': ' . $e->getMessage());
        }

        AuditLogger::log('message_sent', 'Complaint',
            'Message sent to ' . $complaint->user_email . ' re: Complaint #' . $id,
            $id
        );

        return response()->json(['success' => true]);
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
