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
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Participants Attendance</h3>

                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200" id="participants-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participant Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participant Number</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @php
    $participants = old('participants', $curriculumAttendance->participants->map(function ($participant) {
        return [
            'participant_name' => $participant->participant_name,
            'participant_number' => $participant->participant_number,
            'status' => $participant->status ?? 'absent',
        ];
    })->toArray());
@endphp

                                    @foreach($participants as $index => $participant)
                                        <tr>
                                            <td class="px-4 py-2">
                                                <input type="text" name="participants[{{ $index }}][participant_name]" value="{{ $participant['participant_name'] ?? '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            </td>
                                            <td class="px-4 py-2">
                                                <input type="text" name="participants[{{ $index }}][participant_number]" value="{{ $participant['participant_number'] ?? '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                            </td>
                                            <td class="px-4 py-2">
                                                <select name="participants[{{ $index }}][status]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                    <option value="present" {{ (($participant['status'] ?? '') === 'present') ? 'selected' : '' }}>Present</option>
                                                    <option value="absent" {{ (($participant['status'] ?? '') === 'absent') ? 'selected' : '' }}>Absent</option>
                                                </select>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded remove-participant">
                                                    Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="button" id="add-participant" class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Participant
                        </button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tbody = document.querySelector('#participants-table tbody');
            const addButton = document.getElementById('add-participant');

            let rowIndex = tbody.querySelectorAll('tr').length;

            function bindRemoveButtons() {
                document.querySelectorAll('.remove-participant').forEach(button => {
                    button.onclick = function () {
                        this.closest('tr').remove();
                    };
                });
            }

            addButton.addEventListener('click', function () {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-4 py-2">
                        <input type="text" name="participants[${rowIndex}][participant_name]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <input type="text" name="participants[${rowIndex}][participant_number]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </td>
                    <td class="px-4 py-2">
                        <select name="participants[${rowIndex}][status]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                        </select>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded remove-participant">
                            Remove
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
                rowIndex++;
                bindRemoveButtons();
            });

            bindRemoveButtons();
        });
    </script>
</x-app-layout>