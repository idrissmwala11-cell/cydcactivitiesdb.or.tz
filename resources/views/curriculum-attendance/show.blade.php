<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum Attendance Details') }}
        </h2>
    </x-slot>

    @php
        $presentParticipants = $curriculumAttendance->participants->where('status', 'present');
        $absentParticipants = $curriculumAttendance->participants->where('status', 'absent');
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Date:</label>
                                    <p class="text-gray-900">
                                        {{ $curriculumAttendance->tarehe ? $curriculumAttendance->tarehe->format('d-m-Y') : 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Teacher Name:</label>
                                    <p class="text-gray-900">{{ $curriculumAttendance->jina_la_mwalimu }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Lesson Topic:</label>
                                    <p class="text-gray-900">{{ $curriculumAttendance->somo }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Total Participants:</label>
                                    <p class="text-gray-900">{{ $curriculumAttendance->wahudhuria }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Submitted By:</label>
                                    <p class="text-gray-900">
                                        <x-user-identity :user="$curriculumAttendance->user" :show-email="true" />
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Summary</h3>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 text-center">
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <div class="text-2xl font-bold text-blue-600">{{ $curriculumAttendance->wahudhuria }}</div>
                                        <div class="text-sm text-gray-600">Total</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-green-600">{{ $curriculumAttendance->present_count }}</div>
                                        <div class="text-sm text-gray-600">Present</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-red-600">{{ $curriculumAttendance->absent_count }}</div>
                                        <div class="text-sm text-gray-600">Absent</div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <div class="font-semibold text-green-700">Present Count</div>
                                            <div class="mt-1 inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                                {{ $curriculumAttendance->present_count }} participants
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-red-700">Absent Count</div>
                                            <div class="mt-1 inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium">
                                                {{ $curriculumAttendance->absent_count }} participants
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($curriculumAttendance->mada)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Lesson Topic Details</h3>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $curriculumAttendance->mada }}</p>
                            </div>
                        </div>
                    @endif

                    @if($curriculumAttendance->maoni_ya_mwalimu || $curriculumAttendance->maoni_ya_msimamizi)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Comments</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Teacher Comments:</h4>
                                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 min-h-[90px] flex items-center justify-center">
                                        <p class="text-gray-900 whitespace-pre-wrap text-center">
                                            {{ $curriculumAttendance->maoni_ya_mwalimu ?: 'No comments' }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Supervisor Comments:</h4>
                                    <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 min-h-[90px] flex items-center justify-center">
                                        <p class="text-gray-900 whitespace-pre-wrap text-center">
                                            {{ $curriculumAttendance->maoni_ya_msimamizi ?: 'No comments' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($presentParticipants->count() > 0 || $absentParticipants->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Participants</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold text-green-700 mb-3">✔ Present Participants ({{ $presentParticipants->count() }})</h4>
                                    <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                                        @if($presentParticipants->count() > 0)
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden bg-white">
                                                    <thead class="bg-slate-900 text-white">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($presentParticipants as $participant)
                                                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                                    {{ $participant->participant_name }}
                                                                </td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                                    {{ $participant->participant_number ?: 'No number provided' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">No present participants recorded.</p>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-red-700 mb-3">✖ Absent Participants ({{ $absentParticipants->count() }})</h4>
                                    <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                                        @if($absentParticipants->count() > 0)
                                            <div class="overflow-x-auto">
                                                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden bg-white">
                                                    <thead class="bg-slate-900 text-white">
                                                        <tr>
                                                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                                                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($absentParticipants as $participant)
                                                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition-colors">
                                                                <td class="px-4 py-3 text-sm text-gray-900">
                                                                    {{ $participant->participant_name }}
                                                                </td>
                                                                <td class="px-4 py-3 text-sm text-gray-900 text-center">
                                                                    {{ $participant->participant_number ?: 'No number provided' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">No absent participants recorded.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('curriculum-attendance.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>

                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $curriculumAttendance->user_id)
                            <div class="space-x-2">
                                <a href="{{ route('curriculum-attendance.edit', $curriculumAttendance->id) }}"
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('curriculum-attendance.destroy', $curriculumAttendance->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this curriculum attendance record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
