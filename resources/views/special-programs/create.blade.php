@extends('layouts.app')
@section('title', 'Add New Special Program')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Add New Special Program') }}
                    </h2>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('submissions.special-program.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="date" name="date" value="{{ old('date') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="teacher" class="block text-sm font-medium text-gray-700 mb-2">
                                Teacher <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="teacher" name="teacher" value="{{ old('teacher') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                Topic <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="topic" name="topic" value="{{ old('topic') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="age_range" class="block text-sm font-medium text-gray-700 mb-2">
                                Age Range <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="age_range" name="age_range" value="{{ old('age_range') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label for="teacher_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                Teacher Feedback
                            </label>
                            <textarea id="teacher_feedback" name="teacher_feedback" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('teacher_feedback') }}</textarea>
                        </div>

                        <div>
                            <label for="supervisor_feedback" class="block text-sm font-medium text-gray-700 mb-2">
                                Supervisor Feedback
                            </label>
                            <textarea id="supervisor_feedback" name="supervisor_feedback" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('supervisor_feedback') }}</textarea>
                        </div>

                        <div class="flex justify-between items-center pt-6 border-t">
                            <a href="{{ route('submissions.special-program.index') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection