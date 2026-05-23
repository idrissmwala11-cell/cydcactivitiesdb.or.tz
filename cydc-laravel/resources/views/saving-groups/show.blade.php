<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Saving Group Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Group Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Group Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Group Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->group_name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Formation Date</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $savingGroup->formation_date ? $savingGroup->formation_date->format('M d, Y') : 'Not specified' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Location</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->location }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ward</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->ward ?: 'Not specified' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">District</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->district ?: 'Not specified' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Region</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->region ?: 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Group Details</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meeting Day</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->meeting_day ?: 'Not specified' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Meeting Time</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->meeting_time ?: 'Not specified' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $savingGroup->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($savingGroup->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Members Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Members</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <p class="text-sm text-gray-600">
                                    Total Members: <span class="font-semibold">{{ $savingGroup->members->count() }}</span>
                                </p>
                                <a href="{{ route('group-members.create', ['group_id' => $savingGroup->id]) }}" 
                                   class="text-blue-600 hover:text-blue-900 text-sm">
                                    Add Member
                                </a>
                            </div>
                            
                            @if($savingGroup->members->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Join Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($savingGroup->members as $member)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $member->phone }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $member->role ?: 'Member' }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">
                                                    {{ $member->join_date ? $member->join_date->format('M d, Y') : 'N/A' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">No members added yet.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($savingGroup->notes)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-900">{{ $savingGroup->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Record Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Record Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->created_at->format('M d, Y \\a\\t g:i A') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->updated_at->format('M d, Y \\a\\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between">
                        <a href="{{ route('saving-groups.index') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            ← Back to Groups
                        </a>
                        
                        <div class="space-x-4">
                            <a href="{{ route('saving-groups.edit', $savingGroup) }}" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Edit Group
                            </a>
                            
                            <form action="{{ route('saving-groups.destroy', $savingGroup) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this group? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Delete Group
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>