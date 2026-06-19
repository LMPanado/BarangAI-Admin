<?php

use App\Models\Resident; 
use App\Models\DocumentRequest;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\DocumentRequestController;
use App\Http\Controllers\Admin\RoleController; 
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AnnouncementController; // Imported for the announcements module
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
            $requests = DocumentRequest::all();
            return view('admin.dashboard', [
                'requests'        => $requests, 
                'totalPopulation' => Resident::count(),
                'maleCount'       => Resident::where('gender', 'Male')->count(),
                'femaleCount'     => Resident::where('gender', 'Female')->count(),
                'voterCount'      => Resident::where('is_voter', true)->count(),
                'pendingRequests' => $requests->where('status', 'pending')->count(), 
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
        });

        // Requests: Visible to 1, 2, and 3 
        Route::middleware(['role:1,2,3'])->prefix('documents')->name('admin.documents.')->group(function () {
            Route::get('/', [DocumentRequestController::class, 'index'])->name('index');
            Route::get('/issuance/{id}', [DocumentRequestController::class, 'issuance'])->name('issuance');
            Route::patch('/{id}/status', [DocumentRequestController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [DocumentRequestController::class, 'destroy'])->middleware('role:1')->name('destroy');
        });

        // Reports: Visible to 1 and 2 (Role 3 Blocked)
        Route::get('/reports', [ReportController::class, 'index'])
            ->middleware('role:1,2')
            ->name('admin.reports.index');

        // Feedback: Visible to 1, 2, and 3
        Route::get('/feedback', [ReportController::class, 'feedback'])->name('admin.feedback.index');

        Route::middleware(['role:1'])->group(function () {
            Route::prefix('roles')->name('admin.roles.')->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('index');
                Route::patch('/{user}/update', [RoleController::class, 'update'])->name('update');
            });
        });
    });
});