<?php

use App\Models\AuditLog;
use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\DocumentRequestController;
use App\Http\Controllers\Admin\AuditLogController;
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
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
        Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware(['auth', 'role:1,2,3'])->prefix('admin')->group(function () {
        
        Route::get('/dashboard', function () {
            // One query for all resident counts
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

            // One query for document request counts
            $docStats = DocumentRequest::selectRaw("
                COUNT(*) as total,
                COUNT(*) FILTER (WHERE status = 'pending') as pending
            ")->first();

            $recentLogs = auth()->user()->role === 1
                ? AuditLog::with('user')->latest('created_at')->limit(10)->get()
                : collect();

            return view('admin.dashboard', [
                'requests'        => collect(), // kept for view compatibility
                'totalPopulation' => $residentStats->total,
                'maleCount'       => $residentStats->male,
                'femaleCount'     => $residentStats->female,
                'voterCount'      => $residentStats->voters,
                'pendingRequests' => $docStats->pending,
                'recentLogs'      => $recentLogs,
                'ageGroups'       => [
                    'Children (0–12)'  => $residentStats->children,
                    'Teens (13–17)'    => $residentStats->teens,
                    'Adults (18–59)'   => $residentStats->adults,
                    'Seniors (60+)'    => $residentStats->seniors,
                ],
            ]);
        })->name('dashboard');

        Route::prefix('residents')->name('admin.residents.')->group(function() {
            Route::get('/', [ResidentController::class, 'index'])->name('index');
            Route::get('/create', [ResidentController::class, 'create'])->name('create');
            Route::post('/', [ResidentController::class, 'store'])->name('store');
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
            Route::delete('/{id}', [DocumentRequestController::class, 'destroy'])->middleware('role:1')->name('destroy');
        });

        // Complaints: Visible to 1 and 2 (Role 3 Blocked)
        Route::get('/complaints', [ComplaintController::class, 'index'])
            ->middleware('role:1,2')
            ->name('admin.complaints.index');

        // Reports (Analytics): Visible to 1 and 2 (Role 3 Blocked)
        Route::get('/reports', [ReportController::class, 'index'])
            ->middleware('role:1,2')
            ->name('admin.reports.index');

        // Feedback: Visible to 1, 2, and 3
        Route::get('/feedback', [ReportController::class, 'feedback'])->name('admin.feedback.index');
        Route::post('/feedback/{id}/reply', [ReportController::class, 'replyFeedback'])->name('admin.feedback.reply');

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
            });

            Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs.index');
        });
    });
});