@extends('layouts.app')
@section('title', 'Savings Group Details')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex items-start justify-between gap-4 flex-wrap mb-6">
                    <div>
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Savings Group</h2>
                        <div class="text-sm text-gray-500 mt-1">Submitted by {{ $savingGroup->user->center_id ?? $savingGroup->user->email ?? $savingGroup->user->name ?? 'Legacy record' }}</div>
                    </div>
                    <div class="text-end">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $savingGroup->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($savingGroup->status ?? 'approved') }}
                        </span>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->user->center_id ?? $savingGroup->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->user->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Submitted At</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->created_at->format('F d, Y \\a\\t H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->updated_at->format('F d, Y \\a\\t H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Submitted Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Group Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->group_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Number of Members</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->member_count }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Group Age in Months</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->group_mentor }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Registration Status</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->registration_status }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Amount of Money</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->savings_level }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Has a Bank Account?</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->bank_account }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Group Progress</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $savingGroup->group_progress ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Members</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        @if($savingGroup->groupMembers->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($savingGroup->groupMembers as $member)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $member->member_name }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $member->member_phone ?: 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No members were added to this group.</p>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('saving-groups.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Back to Groups</a>
                    <div class="space-x-4">
                        <a href="{{ route('saving-groups.edit', $savingGroup) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Edit</a>
                        <form action="{{ route('saving-groups.destroy', $savingGroup) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this group? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
