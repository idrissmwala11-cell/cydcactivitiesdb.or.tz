<x-guest-layout>
    <!-- Form Header -->
    <div class="text-center mb-5">
        <h1 class="text-3xl font-bold text-gray-800 mb-1">Create Account</h1>
        <p class="text-gray-600">Join CYDC and start your journey with us</p>
    </div>
    
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Email Address -->
            <div class="space-y-1.5">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address" class="py-2.5" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div class="space-y-1.5">
                <x-input-label for="phone" :value="__('Phone Number')" />
                <x-text-input id="phone" type="tel" name="phone" :value="old('phone')" required placeholder="Enter your phone number" class="py-2.5" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Center ID -->
            <div class="space-y-1.5">
                <x-input-label for="center_id" :value="__('Center ID')" />
                <x-text-input id="center_id" type="text" name="center_id" :value="old('center_id')" required placeholder="Enter your Center ID" class="py-2.5" />
                <x-input-error :messages="$errors->get('center_id')" class="mt-2" />
            </div>

            <!-- Cluster Name -->
            <div class="space-y-1.5">
                <x-input-label for="cluster_name" :value="__('Cluster Name')" />
                <x-text-input id="cluster_name" type="text" name="cluster_name" :value="old('cluster_name')" required placeholder="Enter your Cluster name" class="py-2.5" />
                <x-input-error :messages="$errors->get('cluster_name')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" class="py-2.5" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" class="py-2.5" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-primary-button class="w-full py-3">
                {{ __('Create Account') }}
            </x-primary-button>
        </div>
        
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a class="font-semibold text-blue-600 hover:text-blue-800 transition duration-200" href="{{ route('login') }}">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
