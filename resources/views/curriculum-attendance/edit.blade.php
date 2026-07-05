<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Curriculum Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <a href="{{ route('curriculum-attendance.index') }}"
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                       Back to List
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('curriculum-attendance.update', $curriculumAttendance->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="tarehe" value="{{ old('tarehe', optional($curriculumAttendance->tarehe)->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teacher Name</label>
                            <input type="text" name="jina_la_mwalimu" value="{{ old('jina_la_mwalimu', $curriculumAttendance->jina_la_mwalimu) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Lesson Topic</label>
                            <input type="text" name="somo" value="{{ old('somo', $curriculumAttendance->somo) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Lesson Topic Details</label>
                        <textarea name="mada" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('mada', $curriculumAttendance->mada) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teacher Comments</label>
                            <textarea name="maoni_ya_mwalimu" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('maoni_ya_mwalimu', $curriculumAttendance->maoni_ya_mwalimu) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Supervisor Comments</label>
                            <textarea name="maoni_ya_msimamizi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('maoni_ya_msimamizi', $curriculumAttendance->maoni_ya_msimamizi) }}</textarea>
                        </div>
                    </div>

                    <div class="mb-6">
                        @php
                            $participants = old('participants', $curriculumAttendance->participants->map(function ($participant) {
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
                            title="Select Participants"
                            help-text="Tick waliopo na untick wasiokuwepo. Present na Absent zitahesabika zenyewe."
                            add-button-text="Add Participant"
                        />
                    </div>

                    <div class="mt-6 flex space-x-2">
                        <a href="{{ route('curriculum-attendance.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                           Back to List
                        </a>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update Attendance
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-app-layout>
