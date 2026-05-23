@extends('layouts.app')
@section('title', 'Add New Curriculum Record')
@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('masomo-ya-mtaala.store') }}" method="POST">
                    @csrf
                    <!-- Student Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="student_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Student Name *
                                </label>
                                <input type="text" name="student_name" id="student_name" 
                                       value="{{ old('student_name') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       required>
                            </div>

                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Student ID
                                </label>
                                <input type="text" name="student_id" id="student_id" 
                                       value="{{ old('student_id') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="grade_level" class="block text-sm font-medium text-gray-700 mb-2">
                                    Grade/Level *
                                </label>
                                <select name="grade_level" id="grade_level" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                    <option value="">Select Grade/Level</option>
                                    <option value="Standard 1" {{ old('grade_level') == 'Standard 1' ? 'selected' : '' }}>Standard 1</option>
                                    <option value="Standard 2" {{ old('grade_level') == 'Standard 2' ? 'selected' : '' }}>Standard 2</option>
                                    <option value="Standard 3" {{ old('grade_level') == 'Standard 3' ? 'selected' : '' }}>Standard 3</option>
                                    <option value="Standard 4" {{ old('grade_level') == 'Standard 4' ? 'selected' : '' }}>Standard 4</option>
                                    <option value="Standard 5" {{ old('grade_level') == 'Standard 5' ? 'selected' : '' }}>Standard 5</option>
                                    <option value="Standard 6" {{ old('grade_level') == 'Standard 6' ? 'selected' : '' }}>Standard 6</option>
                                    <option value="Standard 7" {{ old('grade_level') == 'Standard 7' ? 'selected' : '' }}>Standard 7</option>
                                    <option value="Form 1" {{ old('grade_level') == 'Form 1' ? 'selected' : '' }}>Form 1</option>
                                    <option value="Form 2" {{ old('grade_level') == 'Form 2' ? 'selected' : '' }}>Form 2</option>
                                    <option value="Form 3" {{ old('grade_level') == 'Form 3' ? 'selected' : '' }}>Form 3</option>
                                    <option value="Form 4" {{ old('grade_level') == 'Form 4' ? 'selected' : '' }}>Form 4</option>
                                    <option value="Form 5" {{ old('grade_level') == 'Form 5' ? 'selected' : '' }}>Form 5</option>
                                    <option value="Form 6" {{ old('grade_level') == 'Form 6' ? 'selected' : '' }}>Form 6</option>
                                </select>
                            </div>

                            <div>
                                <label for="class_section" class="block text-sm font-medium text-gray-700 mb-2">
                                    Class/Section
                                </label>
                                <input type="text" name="class_section" id="class_section" 
                                       value="{{ old('class_section') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Subject Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Subject Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                    Subject *
                                </label>
                                <input type="text" name="subject" id="subject" 
                                       value="{{ old('subject') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       required>
                            </div>

                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                    Topic/Chapter
                                </label>
                                <input type="text" name="topic" id="topic" 
                                       value="{{ old('topic') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="teacher_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teacher Name *
                                </label>
                                <input type="text" name="teacher_name" id="teacher_name" 
                                       value="{{ old('teacher_name') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       required>
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date *
                                </label>
                                <input type="date" name="date" id="date" 
                                       value="{{ old('date', date('Y-m-d')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Assessment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="assessment_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Assessment Type
                                </label>
                                <select name="assessment_type" id="assessment_type" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Assessment Type</option>
                                    <option value="quiz" {{ old('assessment_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                                    <option value="test" {{ old('assessment_type') == 'test' ? 'selected' : '' }}>Test</option>
                                    <option value="assignment" {{ old('assessment_type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                                    <option value="project" {{ old('assessment_type') == 'project' ? 'selected' : '' }}>Project</option>
                                    <option value="exam" {{ old('assessment_type') == 'exam' ? 'selected' : '' }}>Exam</option>
                                    <option value="practical" {{ old('assessment_type') == 'practical' ? 'selected' : '' }}>Practical</option>
                                </select>
                            </div>

                            <div>
                                <label for="score" class="block text-sm font-medium text-gray-700 mb-2">
                                    Score/Grade
                                </label>
                                <input type="text" name="score" id="score" 
                                       value="{{ old('score') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., 85%, A, B+">
                            </div>

                            <div>
                                <label for="max_score" class="block text-sm font-medium text-gray-700 mb-2">
                                    Maximum Score
                                </label>
                                <input type="number" name="max_score" id="max_score" 
                                       value="{{ old('max_score') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="e.g., 100">
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status *
                                </label>
                                <select name="status" id="status" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="reviewed" {{ old('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Comments/Notes -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Comments & Notes</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="teacher_comments" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teacher Comments
                                </label>
                                <textarea name="teacher_comments" id="teacher_comments" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Teacher's observations and comments...">{{ old('teacher_comments') }}</textarea>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Additional Notes
                                </label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Any additional notes or observations...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('masomo-ya-mtaala.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Create Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection