<?php

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
// These do not require a token
Route::post('/login', [AuthController.class, 'login']);
Route::post('/register', [AuthController.class, 'register']); // New registration route


// --- Protected Routes ---
// These require a valid Bearer Token from the mobile app
Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/residents', function () {
        return Resident::all(); 
    });

});