<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resident;

class ResidentController extends Controller
{
    public function index() {
        $residents = Resident::select('id', 'first_name', 'last_name')->get();
        return response()->json([
            'status' => 'success',
            'data' => $residents
        ], 200);
    }
}