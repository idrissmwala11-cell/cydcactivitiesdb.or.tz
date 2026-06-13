<x-app-layout>
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
                                <p class="mt-1 text-sm text-gray-900">{{ $skillsAttendance->absentParticipants ? $skillsAttendance->absentParticipants->count() : 0 }}</p>
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

                    @if($skillsAttendance->absentParticipants && $skillsAttendance->absentParticipants->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                Absent Participants ({{ $skillsAttendance->absentParticipants->count() }})
                            </h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Participant Name
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Participant Number
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($skillsAttendance->absentParticipants as $participant)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $participant->participant_name ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $participant->participant_number ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
