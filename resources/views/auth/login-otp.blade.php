<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 text-blue-700">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-8.64 5.4a2.25 2.25 0 0 1-2.22 0l-8.64-5.4" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-2">Verify OTP</h1>
        <p class="text-gray-600 leading-relaxed">
            We have sent a 6-digit OTP to
            <span class="font-semibold text-gray-800">{{ $email }}</span>.
            Enter the code below to continue to your dashboard.
        </p>
    </div>

    <form method="POST" action="{{ route('login.otp.verify') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <x-input-label for="code" :value="__('OTP Code')" />
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
                pattern="[0-9]{6}"
                placeholder="123456"
                class="text-center text-2xl font-bold tracking-[0.45em]"
            />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
            <p class="text-sm text-gray-500">This code expires after 10 minutes.</p>
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full">
                {{ __('Verify and Continue') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-5 flex flex-col items-center justify-center gap-3 text-center sm:flex-row sm:gap-4">
        <form method="POST" action="{{ route('login.otp.resend') }}">
            @csrf

            <button type="submit" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition duration-200">
                Send a new OTP
            </button>
        </form>

        <span class="hidden text-gray-300 sm:inline">|</span>

        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 transition duration-200">
            Back to login
        </a>
    </div>
</x-guest-layout>
