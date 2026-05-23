<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum Attendance Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Date:</label>
                                    <p class="text-gray-900">{{ $curriculumAttendance->date }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Teacher Name:</label>
                                    <p class="text-gray-900">{{ $curriculumAttendance->teacher_name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Lesson Topic:</label>
                                    <p class="text-gray-900">{{ $curriculumAttendance->lesson_topic }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Present Count:</label>
                                    <p class="text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ $curriculumAttendance->present_count }} participants
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Summary</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <div class="text-2xl font-bold text-green-600">{{ $curriculumAttendance->present_count }}</div>
                                        <div class="text-sm text-gray-600">Present</div>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-red-600">{{ $curriculumAttendance->absentParticipants->count() }}</div>
                                        <div class="text-sm text-gray-600">Absent</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lesson Details -->
                    @if($curriculumAttendance->lesson_topic_details)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Lesson Topic Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $curriculumAttendance->lesson_topic_details }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Comments -->
                    @if($curriculumAttendance->teacher_comments || $curriculumAttendance->supervisor_comments)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Comments</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($curriculumAttendance->teacher_comments)
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Teacher Comments:</h4>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $curriculumAttendance->teacher_comments }}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($curriculumAttendance->supervisor_comments)
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Supervisor Comments:</h4>
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $curriculumAttendance->supervisor_comments }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Absent Participants -->
                    @if($curriculumAttendance->absentParticipants->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Absent Participants</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Reason
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($curriculumAttendance->absentParticipants as $participant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $participant->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $participant->reason ?: 'No reason provided' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('curriculum-attendance.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                        
                        <div class="space-x-2">
                            <a href="{{ route('curriculum-attendance.edit', $curriculumAttendance) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            
                            <form action="{{ route('curriculum-attendance.destroy', $curriculumAttendance) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this curriculum attendance record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
