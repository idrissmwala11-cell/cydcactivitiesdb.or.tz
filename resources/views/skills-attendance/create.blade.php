@extends('layouts.app')

@section('title', 'Add New Skills Attendance')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('skills-attendance.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('date')" />
                        </div>

                        <div>
                            <x-input-label for="teacher_name" :value="__('Teacher Name')" />
                            <x-text-input id="teacher_name" name="teacher_name" type="text" class="mt-1 block w-full" :value="old('teacher_name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('teacher_name')" />
                        </div>

                        <div>
                            <x-input-label for="lesson_topic" :value="__('Lesson Topic')" />
                            <x-text-input id="lesson_topic" name="lesson_topic" type="text" class="mt-1 block w-full" :value="old('lesson_topic')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('lesson_topic')" />
                        </div>

                        <div>
                            <x-input-label for="present_count" :value="__('Present Count')" />
                            <x-text-input id="present_count" name="present_count" type="number" class="mt-1 block w-full" :value="old('present_count')" required min="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('present_count')" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-input-label for="lesson_topic_details" :value="__('Lesson Topic Details')" />
                        <textarea id="lesson_topic_details" name="lesson_topic_details" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('lesson_topic_details') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('lesson_topic_details')" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="teacher_comments" :value="__('Teacher Comments')" />
                        <textarea id="teacher_comments" name="teacher_comments" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('teacher_comments') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('teacher_comments')" />
                    </div>

                    <div class="mt-6">
                        <x-input-label for="supervisor_comments" :value="__('Supervisor Comments')" />
                        <textarea id="supervisor_comments" name="supervisor_comments" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('supervisor_comments') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('supervisor_comments')" />
                    </div>

                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-medium text-gray-900">Absent Participants</h4>
                            <button type="button" id="add-participant" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Add Participant
                            </button>
                        </div>
                        
                        <div id="participants-container">
                            @if(old('absent_participants'))
                                @foreach(old('absent_participants') as $index => $participant)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <label class="block font-medium text-sm text-gray-700">Participant Name</label>
                                        <input type="text" name="absent_participants[{{ $index }}][participant_name]" value="{{ $participant['participant_name'] ?? '' }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                    </div>
                                    <div class="flex items-end">
                                        <div class="flex-1">
                                            <label class="block font-medium text-sm text-gray-700">Participant Number</label>
                                            <input type="text" name="absent_participants[{{ $index }}][participant_number]" value="{{ $participant['participant_number'] ?? '' }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                                        </div>
                                        <button type="button" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-participant">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('skills-attendance.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">
                            Cancel
                        </a>
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let participantIndex = {{ old('absent_participants') ? count(old('absent_participants')) : 0 }};
    
    document.getElementById('add-participant').addEventListener('click', function() {
        const container = document.getElementById('participants-container');
        const participantDiv = document.createElement('div');
        participantDiv.className = 'grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 p-4 border border-gray-200 rounded-lg';
        participantDiv.innerHTML = `
            <div>
                <label class="block font-medium text-sm text-gray-700">Participant Name</label>
                <input type="text" name="absent_participants[${participantIndex}][participant_name]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
            </div>
            <div class="flex items-end">
                <div class="flex-1">
                    <label class="block font-medium text-sm text-gray-700">Participant Number</label>
                    <input type="text" name="absent_participants[${participantIndex}][participant_number]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                </div>
                <button type="button" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-participant">
                    Remove
                </button>
            </div>
        `;
        container.appendChild(participantDiv);
        participantIndex++;
        
        participantDiv.querySelector('.remove-participant').addEventListener('click', function() {
            participantDiv.remove();
        });
    });

    document.querySelectorAll('.remove-participant').forEach(function(button) {
        button.addEventListener('click', function() {
            button.closest('.grid').remove();
        });
    });
</script>
@endsection