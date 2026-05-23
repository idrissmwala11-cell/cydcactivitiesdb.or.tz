<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Masomo ya Fani Record') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <strong class="block mb-2">Please fix the following errors:</strong>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="text-xl font-semibold">Masomo ya Fani Form</h3>
                    <a href="{{ route('submissions.masomo-ya-fani.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                        Back to Records
                    </a>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('submissions.masomo-ya-fani.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date <span class="text-red-600">*</span>
                                </label>
                                <input type="date"
                                       id="date"
                                       name="date"
                                       value="{{ old('date', isset($existingSubmission) && $existingSubmission->date ? \Carbon\Carbon::parse($existingSubmission->date)->format('Y-m-d') : date('Y-m-d')) }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                       required>
                            </div>

                            <div>
                                <label for="teacher" class="block text-sm font-medium text-gray-700 mb-2">
                                    Instructor / Teacher <span class="text-red-600">*</span>
                                </label>
                                <input type="text"
                                       id="teacher"
                                       name="teacher"
                                       value="{{ old('teacher', $existingSubmission->teacher ?? '') }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                       required>
                            </div>

                            <div>
                                <label for="fani_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fani Type <span class="text-red-600">*</span>
                                </label>
                                <input type="text"
                                       id="fani_type"
                                       name="fani_type"
                                       value="{{ old('fani_type', $existingSubmission->fani_type ?? '') }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                       required>
                            </div>

                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                    Topic <span class="text-red-600">*</span>
                                </label>
                                <input type="text"
                                       id="topic"
                                       name="topic"
                                       value="{{ old('topic', $existingSubmission->topic ?? '') }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label for="student_preferences" class="block text-sm font-medium text-gray-700 mb-2">
                                    Student Preferences
                                </label>
                                <textarea id="student_preferences"
                                          name="student_preferences"
                                          rows="3"
                                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">{{ old('student_preferences', $existingSubmission->student_preferences ?? '') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="student_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                    Student Feedback
                                </label>
                                <textarea id="student_feedback"
                                          name="student_feedback"
                                          rows="3"
                                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">{{ old('student_feedback', $existingSubmission->student_feedback ?? '') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label for="teacher_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teacher Feedback
                                </label>
                                <textarea id="teacher_feedback"
                                          name="teacher_feedback"
                                          rows="3"
                                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">{{ old('teacher_feedback', $existingSubmission->teacher_feedback ?? '') }}</textarea>
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status
                                </label>
                                <select id="status"
                                        name="status"
                                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                                    <option value="draft" {{ old('status', $existingSubmission->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="submitted" {{ old('status', $existingSubmission->status ?? '') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                </select>
                            </div>

                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                                Save Record
                            </button>

                            <a href="{{ route('submissions.masomo-ya-fani.index') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>