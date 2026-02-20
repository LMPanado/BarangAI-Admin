<?php

use App\Models\Resident; 
use App\Models\DocumentRequest;
use App\Models\User;
use App\Models\Schedule;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\DocumentRequestController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\AuthController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Client Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('client.index');
Route::get('/services', [HomeController::class, 'services'])->name('services');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Protected Resident Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/request-document', [HomeController::class, 'requestDocument'])->name('client.request');
    Route::post('/request-document', [HomeController::class, 'storeDocumentRequest'])->name('client.request.store');

    // FIXED: Ensured these names match your navbar route() calls exactly
    Route::get('/profile', [HomeController::class, 'profile'])->name('client.profile');
    Route::get('/my-requests', [HomeController::class, 'requests'])->name('client.requests');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalPopulation' => Resident::count(),
            'maleCount'       => Resident::where('gender', 'Male')->count(),
            'femaleCount'     => Resident::where('gender', 'Female')->count(),
            'voterCount'      => Resident::where('is_voter', true)->count(),
            'pendingRequests' => DocumentRequest::where('status', 'pending')->count(), 
        ]);
    })->name('dashboard');

    Route::prefix('residents')->name('admin.residents.')->group(function() {
        Route::get('/', [ResidentController::class, 'index'])->name('index');
        Route::get('/create', [ResidentController::class, 'create'])->name('create');
        Route::post('/', [ResidentController::class, 'store'])->name('store');
        Route::get('/{resident}/edit', [ResidentController::class, 'edit'])->name('edit');
        Route::put('/{resident}', [ResidentController::class, 'update'])->name('update');
        Route::delete('/{resident}', [ResidentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('schedules')->name('admin.schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('documents')->name('admin.documents.')->group(function () {
        Route::get('/', [DocumentRequestController::class, 'index'])->name('index');
        Route::get('/issuance/{id}', [DocumentRequestController::class, 'issuance'])->name('issuance');
        Route::patch('/{id}/status', [DocumentRequestController::class, 'updateStatus'])->name('updateStatus');
    });
});