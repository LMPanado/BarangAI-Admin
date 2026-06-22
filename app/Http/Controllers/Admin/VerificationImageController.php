<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerificationImageController extends Controller
{
    public function show(Request $request, $userId, $type)
    {
        // Only authenticated admins/officials can access
        $user = User::findOrFail($userId);

        $column = match($type) {
            'selfie'   => 'selfie_image',
            'valid_id' => 'valid_id_image',
            default    => abort(404),
        };

        $path = $user->$column;

        if (!$path) {
            abort(404, 'Image not found.');
        }

        $supabaseUrl    = config('services.supabase.url');
        $serviceKey     = config('services.supabase.service_key');
        $bucket         = 'verification-docs';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $serviceKey,
            'apikey'        => $serviceKey,
        ])->get("{$supabaseUrl}/storage/v1/object/{$bucket}/{$path}");

        if ($response->failed()) {
            abort(404, 'Could not retrieve image from storage.');
        }

        $contentType = $response->header('Content-Type') ?? 'image/jpeg';

        return response($response->body(), 200)
            ->header('Content-Type', $contentType)
            ->header('Cache-Control', 'private, max-age=3600');
    }
}
