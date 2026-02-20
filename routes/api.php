<?php

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// This will be accessible at yourdomain.com/api/residents
Route::get('/residents', function () {
    return Resident::all(); // Laravel automatically converts this to JSON
});