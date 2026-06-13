<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserAvatarController extends Controller
{
    public function __invoke(User $user): BinaryFileResponse
    {
        $path = $user->avatar_storage_path;

        abort_unless($path && Storage::disk('public')->exists($path), 404);

        $response = response()->file(Storage::disk('public')->path($path), [
            'Content-Type' => Storage::disk('public')->mimeType($path) ?: 'image/jpeg',
        ]);

        $response->setPrivate();
        $response->setMaxAge(86400);

        return $response;
    }
}
