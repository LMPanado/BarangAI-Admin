<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('subject')) {
            $query->where('subject_type', $request->subject);
        }

        if ($request->filled('search')) {
            $query->where('subject_label', 'ilike', '%' . $request->search . '%');
        }

        $logs = $query->paginate(25)->withQueryString();

        $docAuditLogs = AuditLog::with('user')
            ->where('subject_type', 'DocumentRequest')
            ->latest('created_at')
            ->limit(50)
            ->get();

        return view('admin.audit-logs.index', compact('logs', 'docAuditLogs'));
    }
}
