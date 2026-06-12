@extends('layouts.app')

@section('title', 'Masomo ya Fani - Details')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 space-y-6">

                <div>
                    <h2 class="text-xl font-semibold">General Info</h2>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-500">Date:</span>
                            {{ $masomoYaFani->date ? $masomoYaFani->date->format('M d, Y') : 'N/A' }}
                        </div>

                        <div>
                            <span class="text-gray-500">Teacher:</span>
                            {{ $masomoYaFani->teacher ?? 'N/A' }}
                        </div>

                        <div>
                            <span class="text-gray-500">Fani:</span>
                            {{ $masomoYaFani->fani_type ?? 'N/A' }}
                        </div>

                        <div>
                            <span class="text-gray-500">Topic:</span>
                            {{ $masomoYaFani->topic ?? 'N/A' }}
                        </div>

                        <div>
                            <span class="text-gray-500">Status:</span>
                            {{ ucfirst($masomoYaFani->status ?? 'N/A') }}
                        </div>
                    </div>
                </div>

                @if($masomoYaFani->student_preferences)
                    <div>
                        <h2 class="text-xl font-semibold">Student Preferences</h2>
                        <p class="mt-2 text-gray-700">{{ $masomoYaFani->student_preferences }}</p>
                    </div>
                @endif

                @if($masomoYaFani->student_feedback)
                    <div>
                        <h2 class="text-xl font-semibold">Student Feedback</h2>
                        <p class="mt-2 text-gray-700">{{ $masomoYaFani->student_feedback }}</p>
                    </div>
                @endif

                @if($masomoYaFani->teacher_feedback)
                    <div>
                        <h2 class="text-xl font-semibold">Teacher Feedback</h2>
                        <p class="mt-2 text-gray-700">{{ $masomoYaFani->teacher_feedback }}</p>
                    </div>
                @endif

                <div class="flex items-center justify-between pt-6">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.masomo-ya-fani.index') }}"
                           class="text-gray-600 hover:text-gray-800">
                            Back to list
                        </a>

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.masomo-ya-fani.edit', $masomoYaFani) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Edit
                            </a>

                            <form action="{{ route('admin.masomo-ya-fani.destroy', $masomoYaFani) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('submissions.masomo-ya-fani.index') }}"
                           class="text-gray-600 hover:text-gray-800">
                            Back to list
                        </a>

                        <div class="flex space-x-2">
                            <a href="{{ route('submissions.masomo-ya-fani.edit', $masomoYaFani) }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Edit
                            </a>

                            <form action="{{ route('submissions.masomo-ya-fani.destroy', $masomoYaFani) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
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
@endsection