<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <!-- Current Password -->
    <div class="mb-4">
        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
        <input type="password" name="current_password" id="current_password" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @error('current_password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- New Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @error('password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
        Update Password
    </button>
</form>
