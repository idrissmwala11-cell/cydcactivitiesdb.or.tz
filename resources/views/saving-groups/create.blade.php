@extends('layouts.app')
@section('title', 'Add New Savings Group')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Savings Group</h2>
                    <a href="{{ route('saving-groups.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Back</a>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('saving-groups.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Submitted Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="group_name" class="block text-sm font-medium text-gray-700 mb-2">Group Name *</label>
                                <input type="text" name="group_name" id="group_name" value="{{ old('group_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="member_count" class="block text-sm font-medium text-gray-700 mb-2">Number of Members *</label>
                                <input type="number" name="member_count" id="member_count" value="{{ old('member_count') }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="group_mentor" class="block text-sm font-medium text-gray-700 mb-2">Group Age in Months *</label>
                                <input type="text" name="group_mentor" id="group_mentor" value="{{ old('group_mentor') }}" placeholder="Example: 12" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="registration_status" class="block text-sm font-medium text-gray-700 mb-2">Registration Status *</label>
                                <select name="registration_status" id="registration_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Select status</option>
                                    <option value="Registered" {{ old('registration_status') == 'Registered' ? 'selected' : '' }}>Registered</option>
                                    <option value="Not Registered" {{ old('registration_status') == 'Not Registered' ? 'selected' : '' }}>Not Registered</option>
                                </select>
                            </div>
                            <div>
                                <label for="savings_level" class="block text-sm font-medium text-gray-700 mb-2">Amount of Money *</label>
                                <input type="text" name="savings_level" id="savings_level" value="{{ old('savings_level') }}" placeholder="Example: 19521000" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="bank_account" class="block text-sm font-medium text-gray-700 mb-2">Has a Bank Account? *</label>
                                <select name="bank_account" id="bank_account" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Select option</option>
                                    <option value="Yes" {{ old('bank_account') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="No" {{ old('bank_account') == 'No' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="group_progress" class="block text-sm font-medium text-gray-700 mb-2">Group Progress</label>
                                <textarea name="group_progress" id="group_progress" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe the current progress of the group">{{ old('group_progress') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Members</h3>
                            <button type="button" id="add-member" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add Member</button>
                        </div>

                        <div id="members-container" class="space-y-4">
                            @php $oldMembers = old('members', [['name' => '', 'phone' => '']]); @endphp
                            @foreach($oldMembers as $index => $member)
                                <div class="member-row grid grid-cols-1 md:grid-cols-2 gap-4 border rounded-lg p-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Member Name</label>
                                        <input type="text" name="members[{{ $index }}][name]" value="{{ $member['name'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="text" name="members[{{ $index }}][phone]" value="{{ $member['phone'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('saving-groups.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit Information</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let memberIndex = {{ count($oldMembers) }};
    document.getElementById('add-member').addEventListener('click', function () {
        const container = document.getElementById('members-container');
        const row = document.createElement('div');
        row.className = 'member-row grid grid-cols-1 md:grid-cols-2 gap-4 border rounded-lg p-4';
        row.innerHTML = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Member Name</label>
                <input type="text" name="members[${memberIndex}][name]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                <input type="text" name="members[${memberIndex}][phone]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        `;
        container.appendChild(row);
        memberIndex++;
    });
</script>
@endsection
