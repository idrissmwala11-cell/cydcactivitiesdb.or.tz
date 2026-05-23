@extends('layouts.app')
@section('title', 'Add New Special Program')
@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Add New Special Program') }}
                    </h2>
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Please fix the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('special-programs.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Program Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Program Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="program_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Program Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="program_name" 
                                           name="program_name" 
                                           value="{{ old('program_name') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('program_name') border-red-500 @enderror">
                                    @error('program_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="program_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Program Type <span class="text-red-500">*</span>
                                    </label>
                                    <select id="program_type" 
                                            name="program_type" 
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('program_type') border-red-500 @enderror">
                                        <option value="">Select Program Type</option>
                                        <option value="health" {{ old('program_type') == 'health' ? 'selected' : '' }}>Health</option>
                                        <option value="education" {{ old('program_type') == 'education' ? 'selected' : '' }}>Education</option>
                                        <option value="community" {{ old('program_type') == 'community' ? 'selected' : '' }}>Community</option>
                                        <option value="youth" {{ old('program_type') == 'youth' ? 'selected' : '' }}>Youth</option>
                                        <option value="women" {{ old('program_type') == 'women' ? 'selected' : '' }}>Women</option>
                                        <option value="environment" {{ old('program_type') == 'environment' ? 'selected' : '' }}>Environment</option>
                                        <option value="other" {{ old('program_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('program_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Program Description
                                    </label>
                                    <textarea id="description" 
                                              name="description" 
                                              rows="4"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Schedule Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Start Date
                                    </label>
                                    <input type="date" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        End Date
                                    </label>
                                    <input type="date" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="{{ old('end_date') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror">
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-2">
                                        Duration (Weeks)
                                    </label>
                                    <input type="number" 
                                           id="duration_weeks" 
                                           name="duration_weeks" 
                                           value="{{ old('duration_weeks') }}"
                                           min="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duration_weeks') border-red-500 @enderror">
                                    @error('duration_weeks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="meeting_frequency" class="block text-sm font-medium text-gray-700 mb-2">
                                        Meeting Frequency
                                    </label>
                                    <select id="meeting_frequency" 
                                            name="meeting_frequency"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('meeting_frequency') border-red-500 @enderror">
                                        <option value="">Select Frequency</option>
                                        <option value="daily" {{ old('meeting_frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('meeting_frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                        <option value="bi-weekly" {{ old('meeting_frequency') == 'bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                                        <option value="monthly" {{ old('meeting_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="as-needed" {{ old('meeting_frequency') == 'as-needed' ? 'selected' : '' }}>As Needed</option>
                                    </select>
                                    @error('meeting_frequency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Participants Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Participants Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="target_participants" class="block text-sm font-medium text-gray-700 mb-2">
                                        Target Participants
                                    </label>
                                    <input type="number" 
                                           id="target_participants" 
                                           name="target_participants" 
                                           value="{{ old('target_participants') }}"
                                           min="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('target_participants') border-red-500 @enderror">
                                    @error('target_participants')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="current_participants" class="block text-sm font-medium text-gray-700 mb-2">
                                        Current Participants
                                    </label>
                                    <input type="number" 
                                           id="current_participants" 
                                           name="current_participants" 
                                           value="{{ old('current_participants', 0) }}"
                                           min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_participants') border-red-500 @enderror">
                                    @error('current_participants')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-2">
                                        Target Audience Description
                                    </label>
                                    <textarea id="target_audience" 
                                              name="target_audience" 
                                              rows="3"
                                              placeholder="e.g., Youth aged 18-25, Women entrepreneurs, Community leaders..."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('target_audience') border-red-500 @enderror">{{ old('target_audience') }}</textarea>
                                    @error('target_audience')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Location Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                        Location/Venue <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="location" 
                                           name="location" 
                                           value="{{ old('location') }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('location') border-red-500 @enderror">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ward" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ward
                                    </label>
                                    <input type="text" 
                                           id="ward" 
                                           name="ward" 
                                           value="{{ old('ward') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ward') border-red-500 @enderror">
                                    @error('ward')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                                        District
                                    </label>
                                    <input type="text" 
                                           id="district" 
                                           name="district" 
                                           value="{{ old('district') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('district') border-red-500 @enderror">
                                    @error('district')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="region" class="block text-sm font-medium text-gray-700 mb-2">
                                        Region
                                    </label>
                                    <input type="text" 
                                           id="region" 
                                           name="region" 
                                           value="{{ old('region') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('region') border-red-500 @enderror">
                                    @error('region')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Program Management -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Program Management</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="coordinator_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Program Coordinator
                                    </label>
                                    <input type="text" 
                                           id="coordinator_name" 
                                           name="coordinator_name" 
                                           value="{{ old('coordinator_name') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('coordinator_name') border-red-500 @enderror">
                                    @error('coordinator_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="coordinator_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Coordinator Phone
                                    </label>
                                    <input type="tel" 
                                           id="coordinator_phone" 
                                           name="coordinator_phone" 
                                           value="{{ old('coordinator_phone') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('coordinator_phone') border-red-500 @enderror">
                                    @error('coordinator_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-2">
                                        Budget (TSH)
                                    </label>
                                    <input type="number" 
                                           id="budget" 
                                           name="budget" 
                                           value="{{ old('budget') }}"
                                           min="0"
                                           step="0.01"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('budget') border-red-500 @enderror">
                                    @error('budget')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" 
                                            name="status" 
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="planning" {{ old('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes/Comments
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="4"
                                          placeholder="Any additional notes, requirements, or special considerations..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center pt-6 border-t">
                            <a href="{{ route('special-programs.index') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Create Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>