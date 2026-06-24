<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
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

        $totalComplaints  = Complaint::count();
        $openComplaints   = Complaint::where('status', 'open')->count();
        $closedComplaints = Complaint::where('status', 'closed')->count();

        $bySeverity = [
            'critical' => Complaint::where('severity', 'critical')->count(),
            'medium'   => Complaint::where('severity', 'medium')->count(),
            'low'      => Complaint::where('severity', 'low')->count(),
        ];

        return view('admin.complaints.index', compact(
            'complaints', 'totalComplaints', 'openComplaints', 'closedComplaints', 'bySeverity', 'sort'
        ));
    }
}
