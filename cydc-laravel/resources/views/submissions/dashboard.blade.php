<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard - Program Day') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Program Day Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-600 text-white p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Program Day</h3>
                            <p class="text-gray-600">Select a section to fill out your program information</p>
                        </div>
                    </div>

                    <!-- Program Sections Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Masomo ya Mtaala -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-600 text-white p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800">Masomo ya Mtaala</h4>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">Curriculum and educational programs information</p>
                            @php
                                $masomoSubmission = isset($masomoSubmissions) ? $masomoSubmissions->first() : null;
                            @endphp
                            <div class="flex justify-between items-center">
                                <a href="{{ route('submissions.masomo-ya-mtaala') }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ $masomoSubmission ? 'Edit' : 'Start' }}
                                </a>
                                @if($masomoSubmission)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $masomoSubmission->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                                           ($masomoSubmission->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                           ($masomoSubmission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($masomoSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Fani -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-600 text-white p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800">Fani</h4>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">Technical and vocational skills information</p>
                            @php
                                $faniSubmission = isset($faniSubmissions) ? $faniSubmissions->first() : null;
                            @endphp
                            <div class="flex justify-between items-center">
                                <a href="{{ route('submissions.masomo-ya-fani') }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ $faniSubmission ? 'Edit' : 'Start' }}
                                </a>
                                @if($faniSubmission)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $faniSubmission->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                                           ($faniSubmission->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                           ($faniSubmission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($faniSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Special Program -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-purple-600 text-white p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800">Special Program</h4>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">Special initiatives and programs information</p>
                            @php
                                $specialSubmission = $submissions->where('section_type', 'special_program')->first();
                            @endphp
                            <div class="flex justify-between items-center">
                                <a href="{{ route('submissions.special-program') }}"
                                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:ring-2 focus:ring-purple-500">
                                    @if ($specialSubmission && $specialSubmission->status === 'draft')
                                        Endelea Kuhariri
                                    @else
                                        Anza Kujaza
                                    @endif
                                </a>
                                @if($specialSubmission)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $specialSubmission->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                                           ($specialSubmission->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                           ($specialSubmission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($specialSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Parents -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-orange-600 text-white p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800">Parents</h4>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">Parent engagement and family programs</p>
                            @php
                                $parentsSubmission = $submissions->where('section_type', 'parents')->first();
                            @endphp
                            <div class="flex justify-between items-center">
                                <a href="{{ route('submissions.create', ['section' => 'parents']) }}" 
                                   class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ $parentsSubmission ? 'Edit' : 'Start' }}
                                </a>
                                @if($parentsSubmission)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $parentsSubmission->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                                           ($parentsSubmission->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                           ($parentsSubmission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($parentsSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Vikoba -->
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="bg-indigo-600 text-white p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800">Vikoba</h4>
                            </div>
                            <p class="text-gray-600 mb-4 text-sm">Savings groups and financial programs</p>
                            @php
                                $vikobaSubmission = $submissions->where('section_type', 'vikoba')->first();
                            @endphp
                            <div class="flex justify-between items-center">
                                <a href="{{ route('submissions.create', ['section' => 'vikoba']) }}" 
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ $vikobaSubmission ? 'Edit' : 'Start' }}
                                </a>
                                @if($vikobaSubmission)
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $vikobaSubmission->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                                           ($vikobaSubmission->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                           ($vikobaSubmission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                        {{ ucfirst($vikobaSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Submissions -->
            @if($submissions->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Recent Submissions</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($submissions->take(5) as $submission)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ ucwords(str_replace('_', ' ', $submission->section_type)) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $submission->status === 'submitted' ? 'bg-green-100 text-green-800' : 
                                                       ($submission->status === 'approved' ? 'bg-blue-100 text-blue-800' : 
                                                       ($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                    {{ ucfirst($submission->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $submission->updated_at->format('M d, Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($submission->status === 'draft')
                                                    @php $editUrl = $submission->section_type === 'special_program' 
                                                        ? route('submissions.special-program') 
                                                        : route('submissions.create', ['section' => $submission->section_type]); @endphp
                                                    <a href="{{ $editUrl }}" 
                                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                    <form method="POST" action="{{ route('submissions.destroy', $submission) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                                onclick="return confirm('Are you sure you want to delete this draft?')">Delete</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400">View Only</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>