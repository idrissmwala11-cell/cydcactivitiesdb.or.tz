<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Verify Login</h1>
        <p class="text-gray-600">
            Enter the 6-digit code sent to {{ $email }}.
        </p>
    </div>

    <form method="POST" action="{{ route('login.otp.verify') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <x-input-label for="code" :value="__('Verification Code')" />
            <x-text-input
                id="code"
                type="text"
                name="code"
                :value="old('code')"
                required
                autofocus
                inputmode="numeric"
                maxlength="6"
                autocomplete="one-time-code"
                placeholder="Enter 6-digit code"
            />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full">
                {{ __('Verify and Continue') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('login.otp.resend') }}" class="mt-4 text-center">
        @csrf

        <button type="submit" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition duration-200">
            Send a new code
        </button>
    </form>
</x-guest-layout>
