<?php

use App\Models\AuditLog;
use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\ComplaintMessage;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\DocumentRequestController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\AccountVerificationController;
use App\Http\Controllers\Admin\VerificationImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController; 
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\PreventBackHistory::class])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('client.index');
    Route::get('/services/{type}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/about', function () { return view('about'); })->name('about');

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
        Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Called by JS when sessionStorage is empty (tab was closed and reopened)
    Route::post('/admin/force-logout', [AuthController::class, 'forceLogout'])->name('admin.force-logout');

    Route::middleware(['auth', 'role:1,2,3', 'session.timeout'])->prefix('admin')->group(function () {
        
        Route::get('/dashboard', function () {
            $role = auth()->user()->role;

            if ($role === 1) {
                // ── IT Admin dashboard ──────────────────────────────
                $userStats = User::selectRaw("
                    COUNT(*) as total,
                    COUNT(*) FILTER (WHERE role = 0) as residents,
                    COUNT(*) FILTER (WHERE role = 1) as admins,
                    COUNT(*) FILTER (WHERE role = 2) as captains,
                    COUNT(*) FILTER (WHERE role = 3) as staff
                ")->first();

                $recentLogs = AuditLog::with('user')->latest('created_at')->limit(20)->get();

                $auditByAction = AuditLog::selectRaw("action, COUNT(*) as count")
                    ->groupBy('action')
                    ->pluck('count', 'action');

                $auditTrend = collect();
                for ($i = 6; $i >= 0; $i--) {
                    $day = \Carbon\Carbon::now()->subDays($i);
                    $auditTrend[$day->format('D M d')] = AuditLog::whereDate('created_at', $day->toDateString())->count();
                }

                $complaintStats = \App\Models\Complaint::selectRaw("
                    COUNT(*) as total,
                    COUNT(*) FILTER (WHERE status = 'open') as open,
                    COUNT(*) FILTER (WHERE status = 'closed') as closed,
                    COUNT(*) FILTER (WHERE severity = 'critical') as critical
                ")->first();

                $totalMessages  = ComplaintMessage::count();
                $totalArchived  = \App\Models\Resident::onlyTrashed()->count();

                return view('admin.dashboard', compact(
                    'userStats', 'recentLogs', 'auditByAction', 'auditTrend',
                    'complaintStats', 'totalMessages', 'totalArchived', 'role'
                ));
            }

            // ── Captain / Staff dashboard ───────────────────────────
            $residentStats = Resident::selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE gender = 'Male') as male,
                COUNT(*) FILTER (WHERE gender = 'Female') as female,
                COUNT(*) FILTER (WHERE is_voter = true) as voters,
                COUNT(*) FILTER (WHERE age BETWEEN 0 AND 12) as children,
                COUNT(*) FILTER (WHERE age BETWEEN 13 AND 17) as teens,
                COUNT(*) FILTER (WHERE age BETWEEN 18 AND 59) as adults,
                COUNT(*) FILTER (WHERE age >= 60) as seniors
            ")->first();

            $docStats = DocumentRequest::selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = 'pending') as pending
            ")->first();

            $civilStatusRaw = Resident::selectRaw("civil_status, COUNT(*) as count")
                ->whereNotNull('civil_status')
                ->groupBy('civil_status')
                ->pluck('count', 'civil_status');

            $registrationTrend = collect();
            for ($i = 5; $i >= 0; $i--) {
                $month = \Carbon\Carbon::now()->subMonths($i);
                $registrationTrend[$month->format('M Y')] = Resident::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->count();
            }

            $docByType   = DocumentRequest::selectRaw("document_type, COUNT(*) as count")->groupBy('document_type')->pluck('count', 'document_type');
            $docByStatus = DocumentRequest::selectRaw("status, COUNT(*) as count")->groupBy('status')->pluck('count', 'status');

            return view('admin.dashboard', [
                'role'              => $role,
                'requests'          => collect(),
                'totalPopulation'   => $residentStats->total,
                'maleCount'         => $residentStats->male,
                'femaleCount'       => $residentStats->female,
                'voterCount'        => $residentStats->voters,
                'pendingRequests'   => $docStats->pending,
                'recentLogs'        => collect(),
                'ageGroups'         => [
                    'Children (0–12)'  => $residentStats->children,
                    'Teens (13–17)'    => $residentStats->teens,
                    'Adults (18–59)'   => $residentStats->adults,
                    'Seniors (60+)'    => $residentStats->seniors,
                ],
                'civilStatusData'   => $civilStatusRaw,
                'registrationTrend' => $registrationTrend,
                'docByType'         => $docByType,
                'docByStatus'       => $docByStatus,
            ]);
        })->name('dashboard');

        Route::prefix('residents')->name('admin.residents.')->group(function() {
            Route::get('/', [ResidentController::class, 'index'])->name('index');
            Route::get('/print', [ResidentController::class, 'printList'])->middleware('role:1,2')->name('print');
            Route::get('/create', [ResidentController::class, 'create'])->middleware('role:1,2')->name('create');
            Route::post('/', [ResidentController::class, 'store'])->middleware('role:1,2')->name('store');
            Route::get('/{resident}/edit', [ResidentController::class, 'edit'])->name('edit');
            Route::put('/{resident}', [ResidentController::class, 'update'])->name('update');
            Route::delete('/{resident}', [ResidentController::class, 'destroy'])->middleware('role:1,2')->name('destroy');
        });

        Route::prefix('schedules')->name('admin.schedules.')->group(function () {
            Route::get('/', [ScheduleController::class, 'index'])->name('index');
            Route::get('/create', [ScheduleController::class, 'create'])->name('create');
            Route::post('/', [ScheduleController::class, 'store'])->name('store');
            Route::get('/{schedule}/edit', [ScheduleController::class, 'edit'])->name('edit');
            Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('update');
            Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
        });

        // Announcements: Visible to 1, 2, and 3
        Route::prefix('announcements')->name('admin.announcements.')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
            Route::post('/', [AnnouncementController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('destroy');
        });

        // Requests: Visible to 1, 2, and 3 
        Route::middleware(['role:1,2,3'])->prefix('documents')->name('admin.documents.')->group(function () {
            Route::get('/', [DocumentRequestController::class, 'index'])->name('index');
            Route::get('/issuance/{id}', [DocumentRequestController::class, 'issuance'])->name('issuance');
            Route::patch('/{id}/status', [DocumentRequestController::class, 'updateStatus'])->name('updateStatus');
            Route::patch('/{id}/verify', [DocumentRequestController::class, 'verify'])->name('verify');
            Route::post('/{id}/mark-processing', [DocumentRequestController::class, 'markProcessing'])->name('markProcessing');
            Route::delete('/{id}', [DocumentRequestController::class, 'destroy'])->middleware('role:1,2')->name('destroy');
        });

        // Complaints: Visible to 1 and 2 (Role 3 Blocked)
        Route::get('/complaints', [ComplaintController::class, 'index'])
            ->middleware('role:1,2')
            ->name('admin.complaints.index');
        Route::patch('/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])
            ->middleware('role:1,2')
            ->name('admin.complaints.updateStatus');
        Route::get('/complaints/{id}/messages', [ComplaintController::class, 'getMessages'])
            ->middleware('role:1,2')
            ->name('admin.complaints.getMessages');
        Route::post('/complaints/{id}/message', [ComplaintController::class, 'sendMessage'])
            ->middleware('role:1,2')
            ->name('admin.complaints.sendMessage');
        Route::post('/complaints/{id}/notify-respondent', [ComplaintController::class, 'notifyRespondent'])
            ->middleware('role:1,2')
            ->name('admin.complaints.notifyRespondent');
        Route::get('/complaints/{id}/print-blotter', [ComplaintController::class, 'printBlotter'])
            ->middleware('role:1,2')
            ->name('admin.complaints.printBlotter');

        // Real-time poll endpoint
        Route::get('/poll', function (\Illuminate\Http\Request $request) {
            $since = $request->get('since');
            $role  = auth()->user()->role;
            $data  = [];

            if ($since) {
                $ts = \Carbon\Carbon::createFromTimestamp($since);

                if (in_array($role, [1, 2])) {
                    $data['complaints']        = \App\Models\Complaint::where('created_at', '>', $ts)->count();
                }
                if ($role === 1) {
                    $data['archive']           = \App\Models\Resident::onlyTrashed()->where('deleted_at', '>', $ts)->count();
                }
                if (in_array($role, [1, 2, 3])) {
                    $data['document_requests'] = \App\Models\DocumentRequest::where('created_at', '>', $ts)->count();
                }
                if (in_array($role, [2, 3])) {
                    $data['feedback']          = \App\Models\Feedback::where('created_at', '>', $ts)->count();
                }
                if ($role === 3) {
                    $data['verification']      = \App\Models\User::where('role', 0)
                        ->where('verification_status', 'pending')
                        ->where('created_at', '>', $ts)->count();
                }
            }

            return response()->json($data);
        })->name('admin.poll');

        // AJAX: new complaints since timestamp
        Route::get('/complaints/new', function (\Illuminate\Http\Request $request) {
            $since = \Carbon\Carbon::createFromTimestamp($request->get('since', 0));
            $newComplaints = \App\Models\Complaint::with('residentUser')
                ->where('created_at', '>', $since)
                ->where('status', 'open')
                ->latest()
                ->get();
            $msgCounts = \App\Models\ComplaintMessage::whereIn('complaint_id', $newComplaints->pluck('id'))
                ->selectRaw('complaint_id, count(*) as cnt')
                ->groupBy('complaint_id')
                ->pluck('cnt', 'complaint_id')
                ->toArray();
            $html = '';
            foreach ($newComplaints as $complaint) {
                $messageCounts = $msgCounts;
                $html .= view('admin.complaints._row', compact('complaint', 'messageCounts'))->render();
            }
            return response()->json(['open_html' => $html, 'open_count' => $newComplaints->count()]);
        })->middleware('role:1,2')->name('admin.complaints.new');

        // AJAX: new feedback since timestamp
        Route::get('/feedback/new', function (\Illuminate\Http\Request $request) {
            $since = \Carbon\Carbon::createFromTimestamp($request->get('since', 0));
            $newFeedbacks = \App\Models\Feedback::where('created_at', '>', $since)->latest()->get();
            $html = '';
            foreach ($newFeedbacks as $item) {
                $html .= view('admin.feedback._item', compact('item'))->render();
            }
            return response()->json(['html' => $html ?: null, 'count' => $newFeedbacks->count()]);
        })->middleware('role:2,3')->name('admin.feedback.new');

        // AJAX: new document requests since timestamp
        Route::get('/documents/new', function (\Illuminate\Http\Request $request) {
            $since = \Carbon\Carbon::createFromTimestamp($request->get('since', 0));
            $newMobile = \App\Models\DocumentRequest::where('created_at', '>', $since)
                ->where(function ($q) { $q->where('source', '!=', 'kiosk')->orWhereNull('source'); })
                ->latest()->get();
            $newKiosk = \App\Models\DocumentRequest::where('created_at', '>', $since)
                ->where('source', 'kiosk')->latest()->get();
            $mobileHtml = '';
            foreach ($newMobile as $request2) {
                $mobileHtml .= view('admin.documents._row', ['request' => $request2, 'showVerify' => false])->render();
            }
            $kioskHtml = '';
            foreach ($newKiosk as $request2) {
                $kioskHtml .= view('admin.documents._row', ['request' => $request2, 'showVerify' => true])->render();
            }
            return response()->json([
                'mobile_html'  => $mobileHtml ?: null,
                'mobile_count' => $newMobile->count(),
                'kiosk_html'   => $kioskHtml ?: null,
                'kiosk_count'  => $newKiosk->count(),
            ]);
        })->middleware('role:1,2,3')->name('admin.documents.new');

        // AJAX: new verification requests since timestamp
        Route::get('/verification/new', function (\Illuminate\Http\Request $request) {
            $since = \Carbon\Carbon::createFromTimestamp($request->get('since', 0));
            $newUsers = \App\Models\User::where('role', 0)
                ->where('verification_status', 'pending')
                ->where('created_at', '>', $since)
                ->latest()->get();
            $html = '';
            foreach ($newUsers as $user) {
                $html .= view('admin.verification._card', compact('user'))->render();
            }
            return response()->json(['html' => $html ?: null, 'count' => $newUsers->count()]);
        })->middleware('role:3')->name('admin.verification.new');

        // Reports (Analytics): Visible to 1 and 2 (Role 3 Blocked)
        Route::get('/reports', [ReportController::class, 'index'])
            ->middleware('role:1,2')
            ->name('admin.reports.index');
        Route::get('/reports/print', [ReportController::class, 'printReport'])
            ->middleware('role:1,2')
            ->name('admin.reports.print');
        Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])
            ->middleware('role:1,2')
            ->name('admin.reports.export-csv');

        // Feedback: Visible to 2 and 3 only (Role 1 blocked)
        Route::get('/feedback', [ReportController::class, 'feedback'])->middleware('role:2,3')->name('admin.feedback.index');
        Route::post('/feedback/{id}/reply', [ReportController::class, 'replyFeedback'])->middleware('role:2,3')->name('admin.feedback.reply');
        // Delete: Role 2 only
        Route::delete('/feedback/{id}', [ReportController::class, 'destroyFeedback'])->middleware('role:2')->name('admin.feedback.destroy');

        // Verification image proxy (private Supabase bucket — streams via service key)
        Route::get('/verification/image/{userId}/{type}', [VerificationImageController::class, 'show'])
            ->name('admin.verification.image')
            ->where('type', 'selfie|valid_id');

        // Account Verification: Role 3 (Barangay Official) only
        Route::middleware('role:3')->group(function () {
            Route::get('/verification', [AccountVerificationController::class, 'index'])->name('admin.verification.index');
            Route::post('/verification/{id}/verify', [AccountVerificationController::class, 'verify'])->name('admin.verification.verify');
            Route::post('/verification/{id}/reject', [AccountVerificationController::class, 'reject'])->name('admin.verification.reject');
        });

        Route::middleware(['role:1'])->group(function () {
            Route::prefix('roles')->name('admin.roles.')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('index');
                Route::patch('/{user}/update', [RoleController::class, 'update'])->name('update');
                Route::patch('/{user}/reset-password', [RoleController::class, 'resetPassword'])->name('reset-password');
            });

            Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs.index');

            Route::get('/archive', [ArchiveController::class, 'index'])->name('admin.archive.index');
            Route::post('/archive/restore/{type}/{id}', [ArchiveController::class, 'restore'])->name('admin.archive.restore');
            Route::delete('/archive/force-delete/{type}/{id}', [ArchiveController::class, 'forceDelete'])->name('admin.archive.force-delete');

            Route::get('/document-activity', function (\Illuminate\Http\Request $request) {
                if (auth()->user()->role == 1) abort(403);
                $query = \App\Models\AuditLog::with('user')
                    ->where('subject_type', 'DocumentRequest')
                    ->latest('created_at');
                if ($request->filled('search')) {
                    $query->where('subject_label', 'ilike', '%' . $request->search . '%');
                }
                if ($request->filled('action')) {
                    $query->where('action', $request->action);
                }
                $logs = $query->paginate(25)->withQueryString();
                return view('admin.document-activity.index', compact('logs'));
            })->name('admin.document-activity.index');
        });
    });
});