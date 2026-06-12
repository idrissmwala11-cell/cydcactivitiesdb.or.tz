@extends('layouts.app')

@section('title', 'Edit Masomo ya Fani')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route($routePrefix . '.update', $masomoYaFani) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date"
                                   name="date"
                                   value="{{ old('date', optional($masomoYaFani->date)->format('Y-m-d')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teacher</label>
                            <input type="text"
                                   name="teacher"
                                   value="{{ old('teacher', $masomoYaFani->teacher) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fani</label>
                            <input type="text"
                                   name="fani_type"
                                   value="{{ old('fani_type', $masomoYaFani->fani_type) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Topic</label>
                            <input type="text"
                                   name="topic"
                                   value="{{ old('topic', $masomoYaFani->topic) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Student Preferences</label>
                            <textarea name="student_preferences"
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('student_preferences', $masomoYaFani->student_preferences) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Student Feedback</label>
                            <textarea name="student_feedback"
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('student_feedback', $masomoYaFani->student_feedback) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Teacher Feedback</label>
                            <textarea name="teacher_feedback"
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('teacher_feedback', $masomoYaFani->teacher_feedback) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    required>
                                @foreach (['draft', 'submitted', 'approved', 'rejected'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $masomoYaFani->status) === $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route($routePrefix . '.index') }}"
                           class="text-gray-600 hover:text-gray-800">
                            Back to list
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection