<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum Record Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Student Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Student Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->student_name }}</p>
                            </div>

                            @if($masomoYaMtaala->student_id)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->student_id }}</p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Grade/Level</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->grade_level }}</p>
                            </div>

                            @if($masomoYaMtaala->class_section)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Class/Section</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->class_section }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Subject Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Subject Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->subject }}</p>
                            </div>

                            @if($masomoYaMtaala->topic)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Topic/Chapter</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->topic }}</p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teacher Name</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->teacher_name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <p class="text-gray-900">{{ \Carbon\Carbon::parse($masomoYaMtaala->date)->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Assessment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($masomoYaMtaala->assessment_type)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Assessment Type</label>
                                <p class="text-gray-900 capitalize">{{ str_replace('_', ' ', $masomoYaMtaala->assessment_type) }}</p>
                            </div>
                            @endif

                            @if($masomoYaMtaala->score)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Score/Grade</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->score }}</p>
                            </div>
                            @endif

                            @if($masomoYaMtaala->max_score)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Score</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->max_score }}</p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($masomoYaMtaala->status == 'completed') bg-green-100 text-green-800
                                    @elseif($masomoYaMtaala->status == 'in_progress') bg-yellow-100 text-yellow-800
                                    @elseif($masomoYaMtaala->status == 'reviewed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $masomoYaMtaala->status)) }}
                                </span>
                            </div>

                            @if($masomoYaMtaala->score && $masomoYaMtaala->max_score && is_numeric($masomoYaMtaala->score) && is_numeric($masomoYaMtaala->max_score))
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Percentage</label>
                                <p class="text-gray-900">{{ number_format(($masomoYaMtaala->score / $masomoYaMtaala->max_score) * 100, 1) }}%</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Comments/Notes -->
                    @if($masomoYaMtaala->teacher_comments || $masomoYaMtaala->notes)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Comments & Notes</h3>
                        <div class="grid grid-cols-1 gap-6">
                            @if($masomoYaMtaala->teacher_comments)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Teacher Comments</label>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $masomoYaMtaala->teacher_comments }}</p>
                                </div>
                            </div>
                            @endif

                            @if($masomoYaMtaala->notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes</label>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $masomoYaMtaala->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Record Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Record Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->created_at->format('F j, Y g:i A') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <p class="text-gray-900">{{ $masomoYaMtaala->updated_at->format('F j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('admin.masomo-ya-mtaala.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            ← Back to List
                        </a>

                        <div class="flex space-x-4">
                            <a href="{{ route('admin.masomo-ya-mtaala.edit', $masomoYaMtaala) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Edit Record
                            </a>

                            <form action="{{ route('admin.masomo-ya-mtaala.destroy', $masomoYaMtaala) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this curriculum record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Delete Record
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>