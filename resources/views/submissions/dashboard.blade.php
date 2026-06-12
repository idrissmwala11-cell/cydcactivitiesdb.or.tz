<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Dashboard - Program Day') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- PROGRAM DAY --}}
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">

                    <h3 class="text-2xl font-bold mb-4">Program Day</h3>
                    <p class="text-gray-600 mb-6">Select a section to fill out your program information</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- MASOMO YA MTAALA --}}
                        @php
                            $masomoSubmission = $masomoSubmissions->first() ?? null;
                        @endphp

                        <div class="bg-blue-50 border rounded-lg p-6">
                            <h4 class="font-semibold mb-2">Curriculum Studies</h4>

                            <div class="flex justify-between items-center">
                                @if(Route::has('submissions.masomo-ya-mtaala.index'))
                                    <a href="{{ route('submissions.masomo-ya-mtaala.index') }}"
                                       class="bg-blue-600 text-white px-4 py-2 rounded">
                                        {{ $masomoSubmission ? 'Edit' : 'Start' }}
                                    </a>
                                @endif

                                @if($masomoSubmission)
                                    <span class="text-xs px-2 py-1 rounded bg-gray-200">
                                        {{ ucfirst($masomoSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- FANI --}}
                        @php
                            $faniSubmission = $faniSubmissions->first() ?? null;
                        @endphp

                        <div class="bg-green-50 border rounded-lg p-6">
                            <h4 class="font-semibold mb-2">Fani</h4>

                            <div class="flex justify-between items-center">
                                @if(Route::has('submissions.masomo-ya-fani.index'))
                                    <a href="{{ route('submissions.masomo-ya-fani.index') }}"
                                       class="bg-green-600 text-white px-4 py-2 rounded">
                                        {{ $faniSubmission ? 'Edit' : 'Start' }}
                                    </a>
                                @endif

                                @if($faniSubmission)
                                    <span class="text-xs px-2 py-1 rounded bg-gray-200">
                                        {{ ucfirst($faniSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- SPECIAL PROGRAM --}}
                        @php
                            $specialSubmission = $submissions->where('section_type', 'special_program')->first();
                        @endphp

                        <div class="bg-purple-50 border rounded-lg p-6">
                            <h4 class="font-semibold mb-2">Special Program</h4>

                            <div class="flex justify-between items-center">
                              @if(Route::has('submissions.special-program.index'))
    <a href="{{ route('submissions.special-program.index') }}"
                                       class="bg-purple-600 text-white px-4 py-2 rounded">
                                        {{ $specialSubmission ? 'Edit' : 'Start' }}
                                    </a>
                                @endif

                                @if($specialSubmission)
                                    <span class="text-xs px-2 py-1 rounded bg-gray-200">
                                        {{ ucfirst($specialSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- PARENTS --}}
                        @php
                            $parentsSubmission = $submissions->where('section_type', 'parents')->first();
                        @endphp

                        <div class="bg-orange-50 border rounded-lg p-6">
                            <h4 class="font-semibold mb-2">Parents</h4>

                            <div class="flex justify-between items-center">
                                @if(Route::has('submissions.create'))
                                    <a href="{{ route('submissions.create', ['section' => 'parents']) }}"
                                       class="bg-orange-600 text-white px-4 py-2 rounded">
                                        {{ $parentsSubmission ? 'Edit' : 'Start' }}
                                    </a>
                                @endif

                                @if($parentsSubmission)
                                    <span class="text-xs px-2 py-1 rounded bg-gray-200">
                                        {{ ucfirst($parentsSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- VIKOBA --}}
                        @php
                            $vikobaSubmission = $submissions->where('section_type', 'vikoba')->first();
                        @endphp

                        <div class="bg-indigo-50 border rounded-lg p-6">
                            <h4 class="font-semibold mb-2">Vikoba</h4>

                            <div class="flex justify-between items-center">
                                @if(Route::has('submissions.create'))
                                    <a href="{{ route('submissions.create', ['section' => 'vikoba']) }}"
                                       class="bg-indigo-600 text-white px-4 py-2 rounded">
                                        {{ $vikobaSubmission ? 'Edit' : 'Start' }}
                                    </a>
                                @endif

                                @if($vikobaSubmission)
                                    <span class="text-xs px-2 py-1 rounded bg-gray-200">
                                        {{ ucfirst($vikobaSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RECENT SUBMISSIONS --}}
            @if($submissions->count() > 0)
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <h3 class="font-semibold mb-4">Recent Submissions</h3>

                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th>Section</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($submissions->take(5) as $submission)
                                    <tr>
                                        <td>{{ $submission->section_type }}</td>
                                        <td>{{ ucfirst($submission->status) }}</td>
                                        <td>{{ $submission->updated_at }}</td>

                                        <td>
                                            @if($submission->status === 'draft')
                                                <a href="{{ route('submissions.create', ['section' => $submission->section_type]) }}">
                                                    Edit
                                                </a>
                                            @else
                                                <span>View Only</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
