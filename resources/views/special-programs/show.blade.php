@extends('layouts.app')
@section('title', 'Special Program Details')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Special Program Details</h2>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <div class="mt-1 text-gray-900">
                            {{ $specialProgram->date ? \Carbon\Carbon::parse($specialProgram->date)->format('M d, Y') : '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teacher</label>
                        <div class="mt-1 text-gray-900">{{ $specialProgram->teacher ?? '-' }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Topic</label>
                        <div class="mt-1 text-gray-900">{{ $specialProgram->topic ?? '-' }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Age Range</label>
                        <div class="mt-1 text-gray-900">{{ $specialProgram->age_range ?? '-' }}</div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Teacher Feedback</label>
                    <div class="mt-1 text-gray-900 whitespace-pre-line">{{ $specialProgram->teacher_feedback ?? '-' }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Supervisor Feedback</label>
                    <div class="mt-1 text-gray-900 whitespace-pre-line">{{ $specialProgram->supervisor_feedback ?? '-' }}</div>
                </div>

                <div class="flex flex-wrap gap-3 pt-4 border-t">
                    <a href="{{ route('submissions.special-program.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Back
                    </a>

                    <a href="{{ route('submissions.special-program.edit', $specialProgram->id) }}"
                       class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Edit
                    </a>

                    <form action="{{ route('submissions.special-program.destroy', $specialProgram->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection