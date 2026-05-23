<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Base Leader Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Full Name:</label>
                                <p class="text-gray-900 font-medium">{{ $baseLeader->first_name }} {{ $baseLeader->last_name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Phone Number:</label>
                                <p class="text-gray-900">{{ $baseLeader->phone_number }}</p>
                            </div>
                            
                            @if($baseLeader->email)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Email Address:</label>
                                <p class="text-gray-900">{{ $baseLeader->email }}</p>
                            </div>
                            @endif
                            
                            @if($baseLeader->date_of_birth)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Date of Birth:</label>
                                <p class="text-gray-900">{{ $baseLeader->date_of_birth }}</p>
                            </div>
                            @endif
                            
                            @if($baseLeader->gender)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Gender:</label>
                                <p class="text-gray-900">{{ ucfirst($baseLeader->gender) }}</p>
                            </div>
                            @endif
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Status:</label>
                                <p class="text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                        {{ $baseLeader->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($baseLeader->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Location Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Location Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Location:</label>
                                <p class="text-gray-900">{{ $baseLeader->location }}</p>
                            </div>
                            
                            @if($baseLeader->ward)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Ward:</label>
                                <p class="text-gray-900">{{ $baseLeader->ward }}</p>
                            </div>
                            @endif
                            
                            @if($baseLeader->district)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">District:</label>
                                <p class="text-gray-900">{{ $baseLeader->district }}</p>
                            </div>
                            @endif
                            
                            @if($baseLeader->region)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Region:</label>
                                <p class="text-gray-900">{{ $baseLeader->region }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Leadership Information -->
                    @if($baseLeader->leadership_position || $baseLeader->start_date)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Leadership Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($baseLeader->leadership_position)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Leadership Position:</label>
                                <p class="text-gray-900">{{ $baseLeader->leadership_position }}</p>
                            </div>
                            @endif
                            
                            @if($baseLeader->start_date)
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Start Date:</label>
                                <p class="text-gray-900">{{ $baseLeader->start_date }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($baseLeader->notes)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Notes</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $baseLeader->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Timestamps -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Record Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Created:</label>
                                <p class="text-gray-900">{{ $baseLeader->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600">Last Updated:</label>
                                <p class="text-gray-900">{{ $baseLeader->updated_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('base-leaders.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                        
                        <div class="space-x-2">
                            <a href="{{ route('base-leaders.edit', $baseLeader) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            
                            <form action="{{ route('base-leaders.destroy', $baseLeader) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this base leader?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
