<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\LoginOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = $request->authenticate();

        $request->session()->regenerate();

        try {
            $this->sendLoginOtp($request, $user, $request->boolean('remember'));
        } catch (Throwable $exception) {
            $request->session()->forget('login_otp');

            Log::error('Login OTP email failed.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Tumeshindwa kutuma OTP kwenye email. Tafadhali hakikisha mail settings za server ziko sawa kisha jaribu tena.',
                ]);
        }

        return redirect()
            ->route('login.otp')
            ->with('status', 'Tumekutumia verification code kwenye email yako. Weka code hiyo ili kuendelea.');
    }

    /**
     * Display the OTP verification view.
     */
    public function showOtpForm(Request $request): RedirectResponse|View
    {
        if (! $request->session()->has('login_otp')) {
            return redirect()->route('login');
        }

        return view('auth.login-otp', [
            'email' => $request->session()->get('login_otp.email'),
        ]);
    }

    /**
     * Verify the OTP and complete the login.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $otp = $request->session()->get('login_otp');

        if (! $otp) {
            return redirect()->route('login');
        }

        if (now()->timestamp > $otp['expires_at']) {
            $request->session()->forget('login_otp');

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Verification code ime-expire. Tafadhali login tena.']);
        }

        if (! Hash::check($validated['code'], $otp['code_hash'])) {
            $attempts = (int) ($otp['attempts'] ?? 0) + 1;
            $otp['attempts'] = $attempts;
            $request->session()->put('login_otp', $otp);

            if ($attempts >= 5) {
                $request->session()->forget('login_otp');

                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'Umejaribu OTP mara nyingi. Tafadhali login tena.']);
            }

            return back()
                ->withInput()
                ->withErrors(['code' => 'Verification code si sahihi. Jaribu tena.']);
        }

        $user = User::findOrFail($otp['user_id']);
        $remember = (bool) ($otp['remember'] ?? false);

        Auth::login($user, $remember);

        $request->session()->forget('login_otp');
        $request->session()->regenerate();

        return $this->redirectAfterLogin($user);
    }

    /**
     * Send a fresh OTP for the pending login.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $otp = $request->session()->get('login_otp');

        if (! $otp) {
            return redirect()->route('login');
        }

        $user = User::findOrFail($otp['user_id']);

        try {
            $this->sendLoginOtp($request, $user, (bool) ($otp['remember'] ?? false));
        } catch (Throwable $exception) {
            Log::error('Login OTP resend email failed.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $exception->getMessage(),
            ]);

            return back()->withErrors([
                'code' => 'Tumeshindwa kutuma OTP mpya. Tafadhali jaribu tena baada ya mail settings kurekebishwa.',
            ]);
        }

        return back()->with('status', 'Verification code mpya imetumwa kwenye email yako.');
    }

    private function redirectAfterLogin(User $user): RedirectResponse
    {
        // Check user status and redirect accordingly
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        
        switch ($user->status) {
            case 'pending':
                return redirect()->route('approval.pending');
            case 'rejected':
                return redirect()->route('approval.rejected');
            case 'approved':
                return redirect()->intended(route('dashboard', absolute: false));
            default:
                // Default to pending if status is not set
                return redirect()->route('approval.pending');
        }
    }

    private function sendLoginOtp(Request $request, User $user, bool $remember): void
    {
        $code = (string) random_int(100000, 999999);

        $request->session()->put('login_otp', [
            'user_id' => $user->id,
            'email' => $user->email,
            'remember' => $remember,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(10)->timestamp,
            'attempts' => 0,
        ]);

        Mail::to($user->email)->send(new LoginOtpMail($code, $user));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
