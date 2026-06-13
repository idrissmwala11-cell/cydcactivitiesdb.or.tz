@extends('layouts.app')

@section('title', 'Out-of-Ministry Leadership Details')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-blue-500">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">OUT-OF-MINISTRY LEADERSHIP DETAILS</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('out-of-ministry-leadership.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        @if(Auth::user()->role === 'admin' || $outOfMinistryLeadership->user_id === Auth::id())
                            <a href="{{ route('out-of-ministry-leadership.edit', $outOfMinistryLeadership) }}" 
                               class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        @endif
                    </div>
                </div>

                <!-- TAARIFA ZA MSINGI Section -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">BASIC INFORMATION</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Number of Leaders:</label>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $outOfMinistryLeadership->leaders_count }} Leaders</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Leadership Term End Date:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $outOfMinistryLeadership->term_end ? $outOfMinistryLeadership->term_end->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Submission Date:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $outOfMinistryLeadership->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Submitted By:</label>
                            <p class="mt-1 text-sm text-gray-900"><x-user-identity :user="$outOfMinistryLeadership->user" :show-email="true" /></p>
                        </div>
                    </div>
                </div>

                <!-- ORODHA YA VIONGOZI Section -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">LEADERS LIST</h3>
                    
                    @if($outOfMinistryLeadership->outOfMinistryLeaderDetails && $outOfMinistryLeadership->outOfMinistryLeaderDetails->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">No.</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Leader Name</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Position</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outOfMinistryLeadership->outOfMinistryLeaderDetails as $index => $detail)
                                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                            <td class="px-4 py-2 border border-gray-300 text-sm">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-sm font-medium">{{ $detail->leader_name }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-sm">{{ $detail->position }}</td>
                                            <td class="px-4 py-2 border border-gray-300 text-sm">
                                                @if($detail->gender === 'male')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Male
                                                    </span>
                                                @elseif($detail->gender === 'female')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                                        Female
                                                    </span>
                                                @else
                                                    <span class="text-gray-500">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">No leader information has been submitted.</p>
                        </div>
                    @endif
                </div>

                <!-- TAARIFA ZA ZIADA Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">ADDITIONAL INFORMATION</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated:</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $outOfMinistryLeadership->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Record ID:</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono">#{{ str_pad($outOfMinistryLeadership->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('out-of-ministry-leadership.index') }}" 
                       class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                    @if(Auth::user()->role === 'admin' || $outOfMinistryLeadership->user_id === Auth::id())
                        <a href="{{ route('out-of-ministry-leadership.edit', $outOfMinistryLeadership) }}" 
                           class="bg-yellow-500 text-white px-6 py-2 rounded-md hover:bg-yellow-600">
                            <i class="bi bi-pencil me-1"></i>Edit Record
                        </a>
                        <form action="{{ route('out-of-ministry-leadership.destroy', $outOfMinistryLeadership) }}" 
                              method="POST" class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this record? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600">
                                <i class="bi bi-trash me-1"></i>Delete Record
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
