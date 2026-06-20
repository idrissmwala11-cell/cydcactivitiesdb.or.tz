@extends('layouts.app')
@section('title', 'Edit Special Program')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Edit Special Program</h2>
            </div>

            <div class="p-6">
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

                <form action="{{ route('submissions.special-program.update', $specialProgram->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" id="date" name="date"
                               value="{{ old('date', optional($specialProgram->date)->format('Y-m-d')) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="teacher" class="block text-sm font-medium text-gray-700 mb-2">Teacher</label>
                        <input type="text" id="teacher" name="teacher"
                               value="{{ old('teacher', $specialProgram->teacher) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">Topic</label>
                        <input type="text" id="topic" name="topic"
                               value="{{ old('topic', $specialProgram->topic) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="age_range" class="block text-sm font-medium text-gray-700 mb-2">Age Range</label>
                        <input type="text" id="age_range" name="age_range"
                               value="{{ old('age_range', $specialProgram->age_range) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="teacher_feedback" class="block text-sm font-medium text-gray-700 mb-2">Teacher Feedback</label>
                        <textarea id="teacher_feedback" name="teacher_feedback" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('teacher_feedback', $specialProgram->teacher_feedback) }}</textarea>
                    </div>

                    <div>
                        <label for="supervisor_feedback" class="block text-sm font-medium text-gray-700 mb-2">Supervisor Feedback</label>
                        <textarea id="supervisor_feedback" name="supervisor_feedback" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('supervisor_feedback', $specialProgram->supervisor_feedback) }}</textarea>
                    </div>

                    @include('program-day._participants-fields', ['record' => $specialProgram])

                    <div class="flex flex-wrap gap-3 pt-4 border-t">
                        <a href="{{ route('submissions.special-program.show', $specialProgram->id) }}"
                           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
