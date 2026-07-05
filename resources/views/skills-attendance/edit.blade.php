<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Skills Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('skills-attendance.update', $skillsAttendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', $skillsAttendance->date ? $skillsAttendance->date->format('Y-m-d') : '')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>

                            <div>
                                <x-input-label for="teacher_name" :value="__('Teacher Name')" />
                                <x-text-input id="teacher_name" name="teacher_name" type="text" class="mt-1 block w-full" :value="old('teacher_name', $skillsAttendance->teacher_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('teacher_name')" />
                            </div>

                            <div>
                                <x-input-label for="lesson_topic" :value="__('Lesson Topic')" />
                                <x-text-input id="lesson_topic" name="lesson_topic" type="text" class="mt-1 block w-full" :value="old('lesson_topic', $skillsAttendance->lesson_topic)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lesson_topic')" />
                            </div>

                            <div>
                                <x-input-label for="present_count" :value="__('Present Count')" />
                                <x-text-input id="present_count" name="present_count" type="number" class="mt-1 block w-full bg-gray-100" :value="old('present_count', $skillsAttendance->present_count)" required min="0" readonly />
                                <x-input-error class="mt-2" :messages="$errors->get('present_count')" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="lesson_topic_details" :value="__('Lesson Topic Details')" />
                            <textarea id="lesson_topic_details" name="lesson_topic_details" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('lesson_topic_details', $skillsAttendance->lesson_topic_details) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('lesson_topic_details')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="teacher_comments" :value="__('Teacher Comments')" />
                            <textarea id="teacher_comments" name="teacher_comments" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('teacher_comments', $skillsAttendance->teacher_comments) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('teacher_comments')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="supervisor_comments" :value="__('Supervisor Comments')" />
                            <textarea id="supervisor_comments" name="supervisor_comments" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('supervisor_comments', $skillsAttendance->supervisor_comments) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('supervisor_comments')" />
                        </div>

                        <div class="mt-8">
                            @php
                                $participants = old('participants', $skillsAttendance->absentParticipants->map(function ($participant) {
                                    return [
                                        'participant_name' => $participant->participant_name,
                                        'participant_number' => $participant->participant_number,
                                        'status' => $participant->status ?? 'absent',
                                    ];
                                })->toArray());

                                if (empty($participants)) {
                                    $participants = [
                                        ['participant_name' => '', 'participant_number' => '', 'status' => 'present'],
                                    ];
                                }
                            @endphp

                            <x-attendance-checklist
                                field-name="participants"
                                :participants="$participants"
                                count-input-id="present_count"
                                count-input-mode="present"
                                title="Select Participants"
                                help-text="Tick waliopo na untick wasiokuwepo. Present na Absent zitahesabika zenyewe."
                                add-button-text="Add Participant"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('skills-attendance.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
