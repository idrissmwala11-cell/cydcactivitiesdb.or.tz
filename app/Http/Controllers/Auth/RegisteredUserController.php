<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserRegisteredForApprovalMail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Throwable;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'center_id' => ['required', 'string', 'max:255'],
            'cluster_name' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'center_id' => $request->center_id,
            'cluster_name' => $request->cluster_name,
            'status' => 'pending', // Set new users as pending approval
        ]);

        event(new Registered($user));

        $this->notifyAdminsAboutRegistration($user);

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function notifyAdminsAboutRegistration(User $user): void
    {
        try {
            $adminEmails = User::query()
                ->where('role', 'admin')
                ->whereNotNull('email')
                ->pluck('email')
                ->filter()
                ->unique()
                ->values()
                ->all();

            if ($adminEmails === []) {
                Log::warning('New user registration email was not sent because no admin emails were found.', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);

                return;
            }

            Mail::to($adminEmails)->send(new UserRegisteredForApprovalMail($user));
        } catch (Throwable $exception) {
            Log::warning('Failed to send new user registration approval email.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
