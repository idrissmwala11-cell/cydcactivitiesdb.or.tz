<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Special Program Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Program Header -->
                    <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $specialProgram->program_name }}</h1>
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($specialProgram->program_type) }}
                                    </span>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                        @if($specialProgram->status == 'active') bg-green-100 text-green-800
                                        @elseif($specialProgram->status == 'completed') bg-blue-100 text-blue-800
                                        @elseif($specialProgram->status == 'suspended') bg-yellow-100 text-yellow-800
                                        @elseif($specialProgram->status == 'planning') bg-purple-100 text-purple-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($specialProgram->status) }}
                                    </span>
                                </div>
                            </div>
                            @if($specialProgram->current_participants && $specialProgram->target_participants)
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600">{{ $specialProgram->current_participants }}/{{ $specialProgram->target_participants }}</div>
                                    <div class="text-sm text-gray-600">Participants</div>
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($specialProgram->current_participants / $specialProgram->target_participants) * 100) }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Program Description -->
                    @if($specialProgram->description)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Program Description</h3>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $specialProgram->description }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Schedule Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Schedule Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($specialProgram->start_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <p class="text-gray-900">{{ $specialProgram->start_date->format('F j, Y') }}</p>
                                <p class="text-sm text-gray-500">{{ $specialProgram->start_date->diffForHumans() }}</p>
                            </div>
                            @endif

                            @if($specialProgram->end_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <p class="text-gray-900">{{ $specialProgram->end_date->format('F j, Y') }}</p>
                                <p class="text-sm text-gray-500">{{ $specialProgram->end_date->diffForHumans() }}</p>
                            </div>
                            @endif

                            @if($specialProgram->duration_weeks)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                <p class="text-gray-900">{{ $specialProgram->duration_weeks }} weeks</p>
                            </div>
                            @endif

                            @if($specialProgram->meeting_frequency)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Frequency</label>
                                <p class="text-gray-900 capitalize">{{ str_replace('-', ' ', $specialProgram->meeting_frequency) }}</p>
                            </div>
                            @endif

                            <!-- Program Timeline -->
                            @if($specialProgram->start_date && $specialProgram->end_date)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Timeline</label>
                                <div class="bg-blue-50 p-4 rounded-md">
                                    @php
                                        $totalDays = $specialProgram->start_date->diffInDays($specialProgram->end_date);
                                        $daysPassed = $specialProgram->start_date->isPast() ? $specialProgram->start_date->diffInDays(now()) : 0;
                                        $progress = $totalDays > 0 ? min(100, ($daysPassed / $totalDays) * 100) : 0;
                                    @endphp
                                    <div class="flex justify-between text-sm text-blue-800 mb-2">
                                        <span>{{ $specialProgram->start_date->format('M j, Y') }}</span>
                                        <span>{{ number_format($progress, 1) }}% Complete</span>
                                        <span>{{ $specialProgram->end_date->format('M j, Y') }}</span>
                                    </div>
                                    <div class="w-full bg-blue-200 rounded-full h-3">
                                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <div class="text-xs text-blue-700 mt-1">
                                        {{ $daysPassed }} of {{ $totalDays }} days completed
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Participants Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Participants Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($specialProgram->target_participants)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target Participants</label>
                                <p class="text-gray-900">{{ number_format($specialProgram->target_participants) }} people</p>
                            </div>
                            @endif

                            @if($specialProgram->current_participants !== null)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Participants</label>
                                <p class="text-gray-900">{{ number_format($specialProgram->current_participants) }} people</p>
                                @if($specialProgram->target_participants)
                                    <p class="text-sm text-gray-500">
                                        {{ number_format(($specialProgram->current_participants / $specialProgram->target_participants) * 100, 1) }}% of target reached
                                    </p>
                                @endif
                            </div>
                            @endif

                            @if($specialProgram->target_audience)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Target Audience</label>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <p class="text-gray-900">{{ $specialProgram->target_audience }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Location Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Venue/Location</label>
                                <p class="text-gray-900">{{ $specialProgram->location }}</p>
                            </div>

                            @if($specialProgram->ward)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ward</label>
                                <p class="text-gray-900">{{ $specialProgram->ward }}</p>
                            </div>
                            @endif

                            @if($specialProgram->district)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">District</label>
                                <p class="text-gray-900">{{ $specialProgram->district }}</p>
                            </div>
                            @endif

                            @if($specialProgram->region)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                                <p class="text-gray-900">{{ $specialProgram->region }}</p>
                            </div>
                            @endif

                            <!-- Full Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                                <p class="text-gray-900">
                                    {{ $specialProgram->location }}
                                    @if($specialProgram->ward), {{ $specialProgram->ward }}@endif
                                    @if($specialProgram->district), {{ $specialProgram->district }}@endif
                                    @if($specialProgram->region), {{ $specialProgram->region }}@endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Program Management -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Program Management</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($specialProgram->coordinator_name)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Coordinator</label>
                                <p class="text-gray-900">{{ $specialProgram->coordinator_name }}</p>
                                @if($specialProgram->coordinator_phone)
                                    <p class="text-sm text-gray-600">📞 {{ $specialProgram->coordinator_phone }}</p>
                                @endif
                            </div>
                            @endif

                            @if($specialProgram->budget)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Budget</label>
                                <p class="text-gray-900">TSH {{ number_format($specialProgram->budget, 2) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Program Statistics -->
                    @if($specialProgram->target_participants || $specialProgram->budget)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Program Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if($specialProgram->current_participants && $specialProgram->target_participants)
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="text-2xl font-bold text-green-600">{{ number_format(($specialProgram->current_participants / $specialProgram->target_participants) * 100, 1) }}%</div>
                                <div class="text-sm text-green-800">Enrollment Rate</div>
                            </div>
                            @endif

                            @if($specialProgram->budget && $specialProgram->current_participants)
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="text-2xl font-bold text-blue-600">TSH {{ number_format($specialProgram->budget / max(1, $specialProgram->current_participants), 0) }}</div>
                                <div class="text-sm text-blue-800">Cost per Participant</div>
                            </div>
                            @endif

                            @if($specialProgram->start_date && $specialProgram->end_date)
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="text-2xl font-bold text-purple-600">{{ $specialProgram->start_date->diffInDays($specialProgram->end_date) }}</div>
                                <div class="text-sm text-purple-800">Total Days</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($specialProgram->notes)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Notes & Comments</h3>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $specialProgram->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Record Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Record Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Created At</label>
                                <p class="text-gray-900">{{ $specialProgram->created_at->format('F j, Y g:i A') }}</p>
                                <p class="text-sm text-gray-500">{{ $specialProgram->created_at->diffForHumans() }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <p class="text-gray-900">{{ $specialProgram->updated_at->format('F j, Y g:i A') }}</p>
                                <p class="text-sm text-gray-500">{{ $specialProgram->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="mb-8">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="text-md font-medium text-yellow-900 mb-2">Quick Program Summary</h4>
                            <div class="text-sm text-yellow-800">
                                <p><strong>{{ $specialProgram->program_name }}</strong> ({{ ucfirst($specialProgram->program_type) }} Program)</p>
                                <p>📍 {{ $specialProgram->location }}@if($specialProgram->district), {{ $specialProgram->district }}@endif</p>
                                @if($specialProgram->coordinator_name)
                                    <p>👤 Coordinator: {{ $specialProgram->coordinator_name }}@if($specialProgram->coordinator_phone) ({{ $specialProgram->coordinator_phone }})@endif</p>
                                @endif
                                @if($specialProgram->current_participants && $specialProgram->target_participants)
                                    <p>👥 Participants: {{ $specialProgram->current_participants }}/{{ $specialProgram->target_participants }}</p>
                                @endif
                                @if($specialProgram->start_date)
                                    <p>📅 
                                        @if($specialProgram->start_date->isFuture())
                                            Starts {{ $specialProgram->start_date->diffForHumans() }}
                                        @elseif($specialProgram->end_date && $specialProgram->end_date->isFuture())
                                            Running until {{ $specialProgram->end_date->diffForHumans() }}
                                        @elseif($specialProgram->end_date && $specialProgram->end_date->isPast())
                                            Completed {{ $specialProgram->end_date->diffForHumans() }}
                                        @else
                                            Currently running
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-6 border-t">
                        <a href="{{ route('special-programs.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            ← Back to Programs
                        </a>

                        <div class="flex space-x-4">
                            <a href="{{ route('special-programs.edit', $specialProgram) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Edit Program
                            </a>

                            <form action="{{ route('special-programs.destroy', $specialProgram) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this special program? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Delete Program
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>