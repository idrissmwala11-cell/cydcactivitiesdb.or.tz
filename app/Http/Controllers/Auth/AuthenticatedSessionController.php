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

        $otp = $this->removeExpiredOtpCodes($otp);
        $request->session()->put('login_otp', $otp);

        if (empty($otp['code_hashes'])) {
            $request->session()->forget('login_otp');

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Verification code ime-expire. Tafadhali login tena.']);
        }

        if (! $this->otpCodeMatches($validated['code'], $otp)) {
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
            $this->sendLoginOtp($request, $user, (bool) ($otp['remember'] ?? false), appendToExisting: true);
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

    private function sendLoginOtp(Request $request, User $user, bool $remember, bool $appendToExisting = false): void
    {
        $code = (string) random_int(100000, 999999);
        $expiresAt = now()->addMinutes(10)->timestamp;

        $existingOtp = $appendToExisting ? $request->session()->get('login_otp', []) : [];
        $codeHashes = $appendToExisting ? $this->removeExpiredOtpCodes($existingOtp)['code_hashes'] ?? [] : [];
        $codeHashes[] = [
            'hash' => Hash::make($code),
            'expires_at' => $expiresAt,
        ];
        $codeHashes = array_slice($codeHashes, -5);

        $request->session()->put('login_otp', [
            'user_id' => $user->id,
            'email' => $user->email,
            'remember' => $remember,
            'code_hash' => $codeHashes[array_key_last($codeHashes)]['hash'],
            'code_hashes' => $codeHashes,
            'expires_at' => max(array_column($codeHashes, 'expires_at')),
            'attempts' => $appendToExisting ? (int) ($existingOtp['attempts'] ?? 0) : 0,
        ]);

        Mail::to($user->email)->send(new LoginOtpMail($code, $user));
    }

    private function otpCodeMatches(string $code, array $otp): bool
    {
        foreach ($otp['code_hashes'] ?? [] as $codeHash) {
            if (Hash::check($code, $codeHash['hash'])) {
                return true;
            }
        }

        if (isset($otp['code_hash'])) {
            return Hash::check($code, $otp['code_hash']);
        }

        return false;
    }

    private function removeExpiredOtpCodes(array $otp): array
    {
        $now = now()->timestamp;
        $codeHashes = $otp['code_hashes'] ?? [];

        if (empty($codeHashes) && isset($otp['code_hash'], $otp['expires_at'])) {
            $codeHashes[] = [
                'hash' => $otp['code_hash'],
                'expires_at' => $otp['expires_at'],
            ];
        }

        $otp['code_hashes'] = array_values(array_filter(
            $codeHashes,
            fn (array $codeHash): bool => ($codeHash['expires_at'] ?? 0) >= $now
        ));

        $otp['expires_at'] = empty($otp['code_hashes'])
            ? 0
            : max(array_column($otp['code_hashes'], 'expires_at'));

        return $otp;
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
