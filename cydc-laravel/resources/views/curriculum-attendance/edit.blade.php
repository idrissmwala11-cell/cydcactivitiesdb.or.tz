<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Curriculum Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('curriculum-attendance.update', $curriculumAttendance) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="date" name="date" value="{{ old('date', $curriculumAttendance->date) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Teacher Name -->
                        <div class="mb-4">
                            <label for="teacher_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Teacher Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="teacher_name" name="teacher_name" value="{{ old('teacher_name', $curriculumAttendance->teacher_name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Lesson Topic -->
                        <div class="mb-4">
                            <label for="lesson_topic" class="block text-sm font-medium text-gray-700 mb-2">
                                Lesson Topic <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lesson_topic" name="lesson_topic" value="{{ old('lesson_topic', $curriculumAttendance->lesson_topic) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Present Count -->
                        <div class="mb-4">
                            <label for="present_count" class="block text-sm font-medium text-gray-700 mb-2">
                                Number of Present Participants <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="present_count" name="present_count" value="{{ old('present_count', $curriculumAttendance->present_count) }}" min="0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>

                        <!-- Lesson Topic Details -->
                        <div class="mb-4">
                            <label for="lesson_topic_details" class="block text-sm font-medium text-gray-700 mb-2">
                                Lesson Topic Details
                            </label>
                            <textarea id="lesson_topic_details" name="lesson_topic_details" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('lesson_topic_details', $curriculumAttendance->lesson_topic_details) }}</textarea>
                        </div>

                        <!-- Teacher Comments -->
                        <div class="mb-4">
                            <label for="teacher_comments" class="block text-sm font-medium text-gray-700 mb-2">
                                Teacher Comments
                            </label>
                            <textarea id="teacher_comments" name="teacher_comments" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('teacher_comments', $curriculumAttendance->teacher_comments) }}</textarea>
                        </div>

                        <!-- Supervisor Comments -->
                        <div class="mb-6">
                            <label for="supervisor_comments" class="block text-sm font-medium text-gray-700 mb-2">
                                Supervisor Comments
                            </label>
                            <textarea id="supervisor_comments" name="supervisor_comments" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('supervisor_comments', $curriculumAttendance->supervisor_comments) }}</textarea>
                        </div>

                        <!-- Absent Participants Section -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Absent Participants
                            </label>
                            <div id="absent-participants">
                                @foreach($curriculumAttendance->absentParticipants as $index => $participant)
                                <div class="flex items-center space-x-2 mb-2">
                                    <input type="hidden" name="absent_participants[{{ $index }}][id]" value="{{ $participant->id }}">
                                    <input type="text" name="absent_participants[{{ $index }}][name]" 
                                           value="{{ old('absent_participants.'.$index.'.name', $participant->name) }}"
                                           placeholder="Participant Name" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <input type="text" name="absent_participants[{{ $index }}][reason]" 
                                           value="{{ old('absent_participants.'.$index.'.reason', $participant->reason) }}"
                                           placeholder="Reason for Absence" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button type="button" onclick="this.parentElement.remove()" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm">
                                        Remove
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-absent-participant" 
                                    class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Add Absent Participant
                            </button>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('curriculum-attendance.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let absentParticipantIndex = {{ $curriculumAttendance->absentParticipants->count() }};

        document.getElementById('add-absent-participant').addEventListener('click', function() {
            const container = document.getElementById('absent-participants');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2 mb-2';
            div.innerHTML = `
                <input type="text" name="absent_participants[${absentParticipantIndex}][name]" 
                       placeholder="Participant Name" 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="absent_participants[${absentParticipantIndex}][reason]" 
                       placeholder="Reason for Absence" 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm">
                    Remove
                </button>
            `;
            container.appendChild(div);
            absentParticipantIndex++;
        });
    </script>
</x-app-layout>
