<?php

use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Models\Resident; 
use App\Http\Controllers\Admin\DocumentRequestController;

Route::get('/admin/documents', [DocumentRequestController::class, 'index'])->name('admin.documents.index');
Route::get('/admin/documents/create/{id}', [DocumentRequestController::class, 'create'])->name('admin.documents.create');

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

// Protected Admin Routes
Route::middleware(['auth', 'App\Http\Middleware\AdminMiddleware'])->prefix('admin')->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalPopulation' => Resident::count(),
            'maleCount'       => Resident::where('gender', 'Male')->count(),
            'femaleCount'     => Resident::where('gender', 'Female')->count(),
            'voterCount'      => Resident::where('is_voter', true)->count(),
            'pendingRequests' => 0, 
        ]);
    })->name('dashboard');

    // 2. Resident Management
    // Removed the 'admin.' from inside the group name because the prefix 'admin' 
    // combined with 'residents' already creates the logical structure.
    Route::prefix('residents')->name('admin.residents.')->group(function() {
        Route::get('/', [ResidentController::class, 'index'])->name('index');
        Route::get('/create', [ResidentController::class, 'create'])->name('create');
        Route::post('/', [ResidentController::class, 'store'])->name('store');
        Route::get('/{resident}/edit', [ResidentController::class, 'edit'])->name('edit');
        Route::put('/{resident}', [ResidentController::class, 'update'])->name('update');
        Route::delete('/{resident}', [ResidentController::class, 'destroy'])->name('destroy');
    });

    // 3. Schedules
    // This will now result in URL: /admin/schedules and Name: admin.schedules.index
    Route::prefix('schedules')->name('admin.schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::post('/', [ScheduleController::class, 'store'])->name('store');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('destroy');
    });
});