@extends('layouts.app')
@section('title', 'Add New Vocational Training Program')
@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Add New Vocational Training Program') }}
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

                    <form action="{{ route('vocational-training.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Program Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Program Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="program_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Program Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="program_name" 
                                           id="program_name" 
                                           value="{{ old('program_name') }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., Computer Basics Training">
                                    @error('program_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="training_type" class="block text-sm font-medium text-gray-700 mb-1">
                                        Training Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="training_type" 
                                            id="training_type" 
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select Training Type</option>
                                        <option value="technical" {{ old('training_type') == 'technical' ? 'selected' : '' }}>Technical</option>
                                        <option value="business" {{ old('training_type') == 'business' ? 'selected' : '' }}>Business</option>
                                        <option value="agriculture" {{ old('training_type') == 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                                        <option value="handicraft" {{ old('training_type') == 'handicraft' ? 'selected' : '' }}>Handicraft</option>
                                        <option value="computer" {{ old('training_type') == 'computer' ? 'selected' : '' }}>Computer</option>
                                        <option value="other" {{ old('training_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('training_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                        Program Description
                                    </label>
                                    <textarea name="description" 
                                              id="description" 
                                              rows="4"
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Describe the training program objectives, content, and expected outcomes...">{{ old('description') }}</textarea>
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
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" 
                                           name="start_date" 
                                           id="start_date" 
                                           value="{{ old('start_date') }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        End Date
                                    </label>
                                    <input type="date" 
                                           name="end_date" 
                                           id="end_date" 
                                           value="{{ old('end_date') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="duration_weeks" class="block text-sm font-medium text-gray-700 mb-1">
                                        Duration (Weeks)
                                    </label>
                                    <input type="number" 
                                           name="duration_weeks" 
                                           id="duration_weeks" 
                                           value="{{ old('duration_weeks') }}"
                                           min="1"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 12">
                                    @error('duration_weeks')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="hours_per_week" class="block text-sm font-medium text-gray-700 mb-1">
                                        Hours per Week
                                    </label>
                                    <input type="number" 
                                           name="hours_per_week" 
                                           id="hours_per_week" 
                                           value="{{ old('hours_per_week') }}"
                                           min="1"
                                           step="0.5"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 20">
                                    @error('hours_per_week')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="schedule_days" class="block text-sm font-medium text-gray-700 mb-1">
                                        Training Days
                                    </label>
                                    <input type="text" 
                                           name="schedule_days" 
                                           id="schedule_days" 
                                           value="{{ old('schedule_days') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., Monday, Wednesday, Friday">
                                    @error('schedule_days')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="schedule_time" class="block text-sm font-medium text-gray-700 mb-1">
                                        Training Time
                                    </label>
                                    <input type="text" 
                                           name="schedule_time" 
                                           id="schedule_time" 
                                           value="{{ old('schedule_time') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 9:00 AM - 12:00 PM">
                                    @error('schedule_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Instructor Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Instructor Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="instructor_name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Instructor Name
                                    </label>
                                    <input type="text" 
                                           name="instructor_name" 
                                           id="instructor_name" 
                                           value="{{ old('instructor_name') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Full name of the instructor">
                                    @error('instructor_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="instructor_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Instructor Phone
                                    </label>
                                    <input type="tel" 
                                           name="instructor_phone" 
                                           id="instructor_phone" 
                                           value="{{ old('instructor_phone') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., +255 123 456 789">
                                    @error('instructor_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="instructor_email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Instructor Email
                                    </label>
                                    <input type="email" 
                                           name="instructor_email" 
                                           id="instructor_email" 
                                           value="{{ old('instructor_email') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="instructor@example.com">
                                    @error('instructor_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="instructor_qualification" class="block text-sm font-medium text-gray-700 mb-1">
                                        Instructor Qualification
                                    </label>
                                    <input type="text" 
                                           name="instructor_qualification" 
                                           id="instructor_qualification" 
                                           value="{{ old('instructor_qualification') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., Certified Computer Trainer">
                                    @error('instructor_qualification')
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
                                    <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">
                                        Maximum Participants
                                    </label>
                                    <input type="number" 
                                           name="max_participants" 
                                           id="max_participants" 
                                           value="{{ old('max_participants') }}"
                                           min="1"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 25">
                                    @error('max_participants')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="current_participants" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Participants
                                    </label>
                                    <input type="number" 
                                           name="current_participants" 
                                           id="current_participants" 
                                           value="{{ old('current_participants', 0) }}"
                                           min="0"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 15">
                                    @error('current_participants')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="target_audience" class="block text-sm font-medium text-gray-700 mb-1">
                                        Target Audience
                                    </label>
                                    <textarea name="target_audience" 
                                              id="target_audience" 
                                              rows="3"
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Describe the target audience for this training program...">{{ old('target_audience') }}</textarea>
                                    @error('target_audience')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="prerequisites" class="block text-sm font-medium text-gray-700 mb-1">
                                        Prerequisites
                                    </label>
                                    <textarea name="prerequisites" 
                                              id="prerequisites" 
                                              rows="3"
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="List any prerequisites or requirements for participants...">{{ old('prerequisites') }}</textarea>
                                    @error('prerequisites')
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
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                                        Training Venue <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="location" 
                                           id="location" 
                                           value="{{ old('location') }}"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., Community Center, School Hall">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ward" class="block text-sm font-medium text-gray-700 mb-1">
                                        Ward
                                    </label>
                                    <input type="text" 
                                           name="ward" 
                                           id="ward" 
                                           value="{{ old('ward') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Ward name">
                                    @error('ward')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="district" class="block text-sm font-medium text-gray-700 mb-1">
                                        District
                                    </label>
                                    <input type="text" 
                                           name="district" 
                                           id="district" 
                                           value="{{ old('district') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="District name">
                                    @error('district')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="region" class="block text-sm font-medium text-gray-700 mb-1">
                                        Region
                                    </label>
                                    <input type="text" 
                                           name="region" 
                                           id="region" 
                                           value="{{ old('region') }}"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="Region name">
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
                                    <label for="training_fee" class="block text-sm font-medium text-gray-700 mb-1">
                                        Training Fee (TSH)
                                    </label>
                                    <input type="number" 
                                           name="training_fee" 
                                           id="training_fee" 
                                           value="{{ old('training_fee') }}"
                                           min="0"
                                           step="0.01"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 50000">
                                    @error('training_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="materials_cost" class="block text-sm font-medium text-gray-700 mb-1">
                                        Materials Cost (TSH)
                                    </label>
                                    <input type="number" 
                                           name="materials_cost" 
                                           id="materials_cost" 
                                           value="{{ old('materials_cost') }}"
                                           min="0"
                                           step="0.01"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g., 15000">
                                    @error('materials_cost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status" 
                                            id="status" 
                                            required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="planning" {{ old('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           name="certification_provided" 
                                           id="certification_provided" 
                                           value="1"
                                           {{ old('certification_provided') ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <label for="certification_provided" class="ml-2 block text-sm text-gray-700">
                                        Certification Provided
                                    </label>
                                    @error('certification_provided')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <div class="space-y-6">
                                <div>
                                    <label for="learning_objectives" class="block text-sm font-medium text-gray-700 mb-1">
                                        Learning Objectives
                                    </label>
                                    <textarea name="learning_objectives" 
                                              id="learning_objectives" 
                                              rows="4"
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="List the key learning objectives and outcomes for this training program...">{{ old('learning_objectives') }}</textarea>
                                    @error('learning_objectives')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                        Notes & Comments
                                    </label>
                                    <textarea name="notes" 
                                              id="notes" 
                                              rows="4"
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                              placeholder="Any additional notes or comments about this training program...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-between items-center pt-6 border-t">
                            <a href="{{ route('vocational-training.index') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>

                            <div class="flex space-x-4">
                                <button type="submit" 
                                        name="action" 
                                        value="save_and_continue"
                                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Save & Add Another
                                </button>
                                <button type="submit" 
                                        name="action" 
                                        value="save"
                                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Save Training Program
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-calculate end date based on start date and duration
        document.getElementById('start_date').addEventListener('change', calculateEndDate);
        document.getElementById('duration_weeks').addEventListener('input', calculateEndDate);

        function calculateEndDate() {
            const startDate = document.getElementById('start_date').value;
            const durationWeeks = document.getElementById('duration_weeks').value;
            
            if (startDate && durationWeeks) {
                const start = new Date(startDate);
                const end = new Date(start.getTime() + (durationWeeks * 7 * 24 * 60 * 60 * 1000));
                document.getElementById('end_date').value = end.toISOString().split('T')[0];
            }
        }

        // Validate current participants doesn't exceed max participants
        document.getElementById('current_participants').addEventListener('input', function() {
            const current = parseInt(this.value) || 0;
            const max = parseInt(document.getElementById('max_participants').value) || 0;
            
            if (max > 0 && current > max) {
                this.setCustomValidity('Current participants cannot exceed maximum participants');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('max_participants').addEventListener('input', function() {
            const max = parseInt(this.value) || 0;
            const current = parseInt(document.getElementById('current_participants').value) || 0;
            
            if (max > 0 && current > max) {
                document.getElementById('current_participants').setCustomValidity('Current participants cannot exceed maximum participants');
            } else {
                document.getElementById('current_participants').setCustomValidity('');
            }
        });
    </script>
@endsection