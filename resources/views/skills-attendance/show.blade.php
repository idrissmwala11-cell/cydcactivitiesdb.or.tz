<x-app-layout>
    @php
        $presentParticipants = $skillsAttendance->absentParticipants->where('status', 'present');
        $absentParticipants = $skillsAttendance->absentParticipants->where('status', 'absent');
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Skills Attendance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $skillsAttendance->date ? $skillsAttendance->date->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teacher Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $skillsAttendance->teacher_name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lesson Topic</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $skillsAttendance->lesson_topic ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Present Count</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $skillsAttendance->present_count ?? 0 }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Absent Count</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $absentParticipants->count() }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Submitted By</label>
                                <p class="mt-1 text-sm text-gray-900"><x-user-identity :user="$skillsAttendance->user" :show-email="true" /></p>
                            </div>
                        </div>
                    </div>

                    @if($skillsAttendance->lesson_topic_details)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lesson Details</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-900">{{ $skillsAttendance->lesson_topic_details }}</p>
                            </div>
                        </div>
                    @endif

                    @if($skillsAttendance->teacher_comments || $skillsAttendance->supervisor_comments)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Comments</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($skillsAttendance->teacher_comments)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Teacher Comments</label>
                                        <div class="bg-blue-50 p-4 rounded-lg">
                                            <p class="text-sm text-gray-900">{{ $skillsAttendance->teacher_comments }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($skillsAttendance->supervisor_comments)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Supervisor Comments</label>
                                        <div class="bg-green-50 p-4 rounded-lg">
                                            <p class="text-sm text-gray-900">{{ $skillsAttendance->supervisor_comments }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($presentParticipants->count() > 0 || $absentParticipants->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Participants Attendance</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-green-50 border border-green-100 rounded-lg p-4">
                                    <h4 class="font-semibold text-green-700 mb-3">Present Participants ({{ $presentParticipants->count() }})</h4>
                                    @forelse($presentParticipants as $participant)
                                        <div class="border-b border-green-100 py-2 last:border-b-0">
                                            <div class="font-semibold text-gray-900">{{ $participant->participant_name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-600">{{ $participant->participant_number ?: 'N/A' }}</div>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">No present participants recorded.</p>
                                    @endforelse
                                </div>

                                <div class="bg-red-50 border border-red-100 rounded-lg p-4">
                                    <h4 class="font-semibold text-red-700 mb-3">Absent Participants ({{ $absentParticipants->count() }})</h4>
                                    @forelse($absentParticipants as $participant)
                                        <div class="border-b border-red-100 py-2 last:border-b-0">
                                            <div class="font-semibold text-gray-900">{{ $participant->participant_name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-600">{{ $participant->participant_number ?: 'N/A' }}</div>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">No absent participants recorded.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <a href="{{ route('skills-attendance.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>

                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $skillsAttendance->user_id)
                            <div class="space-x-3">
                                <a href="{{ route('skills-attendance.edit', $skillsAttendance->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('skills-attendance.destroy', $skillsAttendance->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
