<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Make sure user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Update user settings (existing)
    public function updateSettings(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'theme_mode' => 'required|in:light,dark',
            'future_feature' => 'required|boolean',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user->theme_mode = $request->theme_mode;
        $user->future_feature = $request->future_feature;

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    // New: Update theme via AJAX toggle
    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
        ]);

        $user = auth()->user();
        $user->theme_mode = $request->theme;
        $user->save();

        return response()->json(['status' => 'success']);
    }
}
