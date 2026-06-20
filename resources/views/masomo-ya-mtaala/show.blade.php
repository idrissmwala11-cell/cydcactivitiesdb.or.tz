<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curriculum Studies Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Record Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="font-medium text-gray-700">Date:</span>
                        <p class="text-gray-900">
                            {{ $masomoYaMtaala->date ? $masomoYaMtaala->date->format('F j, Y') : 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Teacher Name:</span>
                        <p class="text-gray-900">{{ $masomoYaMtaala->teacher ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Subject:</span>
                        <p class="text-gray-900">{{ $masomoYaMtaala->subject_type ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Age Group:</span>
                        <p class="text-gray-900">{{ $masomoYaMtaala->age_group ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Category:</span>
                        <p class="text-gray-900">{{ $masomoYaMtaala->category_label }}</p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Status:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($masomoYaMtaala->status === 'submitted' || $masomoYaMtaala->status === 'approved')
                                bg-green-100 text-green-800
                            @elseif($masomoYaMtaala->status === 'draft')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($masomoYaMtaala->status ?? 'N/A') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Lesson Information</h3>

                <div class="space-y-4">
                    <div>
                        <span class="font-medium text-gray-700">Lesson Topic:</span>
                        <div class="bg-gray-50 p-3 rounded-md mt-1">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $masomoYaMtaala->topic ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($masomoYaMtaala->student_feedback || $masomoYaMtaala->teacher_feedback)
                <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Comments</h3>

                    <div class="space-y-4">
                        @if($masomoYaMtaala->student_feedback)
                            <div>
                                <span class="font-medium text-gray-700">Student Comments:</span>
                                <div class="bg-gray-50 p-3 rounded-md mt-1">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $masomoYaMtaala->student_feedback }}</p>
                                </div>
                            </div>
                        @endif

                        @if($masomoYaMtaala->teacher_feedback)
                            <div>
                                <span class="font-medium text-gray-700">Teacher Comments:</span>
                                <div class="bg-gray-50 p-3 rounded-md mt-1">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $masomoYaMtaala->teacher_feedback }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @include('program-day._participants-summary', ['record' => $masomoYaMtaala])

            <div class="bg-white shadow-sm rounded-lg p-6 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="space-y-1">
                    <div>
                        <span class="font-medium text-gray-700">Created At:</span>
                        <p class="text-gray-900">{{ $masomoYaMtaala->created_at ? $masomoYaMtaala->created_at->format('F j, Y g:i A') : 'N/A' }}</p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-700">Last Updated:</span>
                        <p class="text-gray-900">{{ $masomoYaMtaala->updated_at ? $masomoYaMtaala->updated_at->format('F j, Y g:i A') : 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                    @if(request()->routeIs('admin.*'))
                        <a href="{{ route('admin.masomo-ya-mtaala.index') }}"
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            ← Back
                        </a>

                        <a href="{{ route('admin.masomo-ya-mtaala.edit', $masomoYaMtaala) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Edit
                        </a>

                        <form action="{{ route('admin.masomo-ya-mtaala.destroy', $masomoYaMtaala) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    @else
                        <a href="{{ route('submissions.masomo-ya-mtaala.index') }}"
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            ← Back
                        </a>

                        <a href="{{ route('submissions.masomo-ya-mtaala.edit', $masomoYaMtaala) }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Edit
                        </a>

                        <form action="{{ route('submissions.masomo-ya-mtaala.destroy', $masomoYaMtaala) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
