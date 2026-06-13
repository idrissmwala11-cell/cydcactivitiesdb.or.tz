<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Skills Information Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Skills Information Record</h3>
                        <div class="flex space-x-2">
                            @if(auth()->user()->role === 'admin' || auth()->id() === (int) $skillsInformation->user_id)
                                <a href="{{ route('skills-information.edit', $skillsInformation->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>
                            @endif

                            <a href="{{ route('skills-information.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">Basic Information</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-600">Date:</span>
                                    <span class="ml-2">{{ $skillsInformation->created_at ? $skillsInformation->created_at->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Student Name:</span>
                                    <span class="ml-2">{{ $skillsInformation->student_name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Gender:</span>
                                    <span class="ml-2">{{ $skillsInformation->gender }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Student ID:</span>
                                    <span class="ml-2">{{ $skillsInformation->student_id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-2">Skill Details</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="font-medium text-gray-600">Skill Category:</span>
                                    <span class="ml-2">{{ $skillsInformation->skill_category }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Specific Skills:</span>
                                    <span class="ml-2">{{ $skillsInformation->specific_skills ?: 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Skills Type:</span>
                                    <span class="ml-2">{{ $skillsInformation->skills_type ?: 'Not specified' }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Skill Level:</span>
                                    <span class="ml-2">{{ $skillsInformation->skill_level }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-600">Submitted by:</span>
                                    <span class="ml-2"><x-user-identity :user="$skillsInformation->user" :show-email="true" /></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-4">Additional Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($skillsInformation->mentor)
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-blue-800 mb-2">Mentor</h5>
                                    <p class="text-gray-700">{{ $skillsInformation->mentor }}</p>
                                </div>
                            @endif

                            @if($skillsInformation->challenges)
                                <div class="bg-yellow-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-yellow-800 mb-2">Challenges</h5>
                                    <p class="text-gray-700">{{ $skillsInformation->challenges }}</p>
                                </div>
                            @endif

                            @if($skillsInformation->support_received)
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-green-800 mb-2">Support Received</h5>
                                    <p class="text-gray-700">{{ $skillsInformation->support_received }}</p>
                                </div>
                            @endif

                            @if($skillsInformation->comments)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-gray-800 mb-2">Comments</h5>
                                    <p class="text-gray-700">{{ $skillsInformation->comments }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <p>Created: {{ $skillsInformation->created_at ? $skillsInformation->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            @if($skillsInformation->updated_at && $skillsInformation->created_at && $skillsInformation->updated_at != $skillsInformation->created_at)
                                <p>Last updated: {{ $skillsInformation->updated_at->format('M d, Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
