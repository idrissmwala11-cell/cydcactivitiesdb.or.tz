<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        \Log::info('PROFILE PAGE OPENED', [
            'auth_id' => Auth::id(),
            'auth_email' => Auth::user()?->email,
            'request_user_id' => $request->user()?->id,
            'request_user_email' => $request->user()?->email,
            'session_id' => $request->session()->getId(),
            'ip' => $request->ip(),
        ]);

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (full form submit).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            if ($request->hasFile('profile_photo')) {
                $profileFolder = 'profile_photos';

                Storage::disk('public')->makeDirectory($profileFolder);

                $oldPhoto = $user->profile_photo;

                $filename = time() . '_' . $request->file('profile_photo')->getClientOriginalName();

                $request->file('profile_photo')->storeAs($profileFolder, $filename, 'public');

                if ($oldPhoto && Storage::disk('public')->exists($profileFolder . '/' . $oldPhoto)) {
                    Storage::disk('public')->delete($profileFolder . '/' . $oldPhoto);
                }

                $user->profile_photo = $filename;
            }

            $user->save();

            \Log::info('PROFILE UPDATED', [
                'user_id' => $user->id,
                'email' => $user->email,
                'profile_photo' => $user->profile_photo,
                'session_id' => $request->session()->getId(),
                'ip' => $request->ip(),
            ]);

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'email' => $user->email ?? null,
                'session_id' => $request->session()->getId(),
                'ip' => $request->ip(),
            ]);

            return Redirect::route('profile.edit')->with('error', 'Profile update failed. Please try again.');
        }
    }

    /**
     * Automatically update profile photo via AJAX.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'max:2048'],
        ]);

        if (!Auth::check()) {
            \Log::warning('PROFILE PHOTO UPDATE FAILED - UNAUTHENTICATED', [
                'session_id' => $request->session()->getId(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }

        $user = Auth::user();

        Storage::disk('public')->makeDirectory('profile_photos');

        $oldPhoto = $user->profile_photo;

        $filename = time() . '_' . $request->file('profile_photo')->getClientOriginalName();

        $request->file('profile_photo')->storeAs('profile_photos', $filename, 'public');

        if ($oldPhoto && Storage::disk('public')->exists('profile_photos/' . $oldPhoto)) {
            Storage::disk('public')->delete('profile_photos/' . $oldPhoto);
        }

        $user->profile_photo = $filename;
        $saved = $user->save();

        \Log::info('PROFILE PHOTO UPDATED', [
            'auth_id' => Auth::id(),
            'auth_email' => Auth::user()?->email,
            'saved_user_id' => $user->id,
            'saved_user_email' => $user->email,
            'old_photo' => $oldPhoto,
            'new_photo' => $filename,
            'saved' => $saved,
            'session_id' => $request->session()->getId(),
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'filename' => $filename,
            'avatar_url' => $user->fresh()->avatar_url,
            'user_id' => $user->id,
            'email' => $user->email,
            'saved' => $saved,
        ]);
    }

    /**
     * Delete the user's account along with their latest profile photo.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->profile_photo && Storage::disk('public')->exists('profile_photos/' . $user->profile_photo)) {
            Storage::disk('public')->delete('profile_photos/' . $user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deleted');
    }
}
