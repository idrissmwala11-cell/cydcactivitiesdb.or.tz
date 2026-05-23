<form method="POST" action="{{ route('profile.destroy') }}">
    @csrf
    @method('DELETE')

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">
            Confirm Password to Delete Account
        </label>
        <input type="password" name="password" id="password" required
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @error('password')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
        Delete Account
    </button>
</form>
