@extends('layouts.app')

@section('title', 'Edit Out-of-Ministry Leadership Information')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-blue-500">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">EDIT OUT-OF-MINISTRY LEADERSHIP INFORMATION</h2>
                    <a href="{{ route('out-of-ministry-leadership.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <!-- Success Alert -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('out-of-ministry-leadership.update', $outOfMinistryLeadership) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- TAARIFA ZA MSINGI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">BASIC INFORMATION</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Number of Leaders -->
                            <div>
                                <label for="leaders_count" class="block text-sm font-medium text-gray-700 mb-2">
                                    1. Number of Leaders <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="leaders_count" name="leaders_count" 
                                       value="{{ old('leaders_count', $outOfMinistryLeadership->leaders_count) }}" 
                                       placeholder="Enter number of leaders" min="1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <!-- Leadership Term End Date -->
                            <div>
                                <label for="term_end" class="block text-sm font-medium text-gray-700 mb-2">
                                    2. Leadership Term End Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="term_end" name="term_end" 
                                       value="{{ old('term_end', $outOfMinistryLeadership->term_end ? $outOfMinistryLeadership->term_end->format('Y-m-d') : '') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>
                    </div>

                    <!-- ORODHA YA VIONGOZI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">LEADERS LIST</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left">No.</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Leader Name</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Position</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Gender</th>
                                    </tr>
                                </thead>
                                <tbody id="leaders-table">
                                    @if($outOfMinistryLeadership->outOfMinistryLeaderDetails && $outOfMinistryLeadership->outOfMinistryLeaderDetails->count() > 0)
                                        @foreach($outOfMinistryLeadership->outOfMinistryLeaderDetails as $index => $detail)
                                            <tr>
                                                <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="text" name="leaders[{{ $index }}][leader_name]" 
                                                           value="{{ old('leaders.'.$index.'.leader_name', $detail->leader_name) }}"
                                                           class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                           placeholder="Leader name" required>
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    <input type="text" name="leaders[{{ $index }}][position]" 
                                                           value="{{ old('leaders.'.$index.'.position', $detail->position) }}"
                                                           class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                           placeholder="Leader position" required>
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    <select name="leaders[{{ $index }}][gender]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                                                        <option value="">Select gender</option>
                                                        <option value="male" {{ old('leaders.'.$index.'.gender', $detail->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ old('leaders.'.$index.'.gender', $detail->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="border border-gray-300 px-4 py-2">1</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="text" name="leaders[0][leader_name]" 
                                                       class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                       placeholder="Leader name" required>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <input type="text" name="leaders[0][position]" 
                                                       class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                       placeholder="Leader position" required>
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                <select name="leaders[0][gender]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                                                    <option value="">Select gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" id="add-leader" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Add Leader
                            </button>
                            <button type="button" id="remove-leader" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">
                                Remove Leader
                            </button>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('out-of-ministry-leadership.index') }}" 
                           class="bg-gray-500 text-white px-6 py-3 rounded-md hover:bg-gray-600">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg font-semibold">
                            UPDATE INFORMATION
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let leaderIndex = {{ $outOfMinistryLeadership->outOfMinistryLeaderDetails ? $outOfMinistryLeadership->outOfMinistryLeaderDetails->count() : 1 }};

document.getElementById('add-leader').addEventListener('click', function() {
    const tableBody = document.getElementById('leaders-table');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td class="border border-gray-300 px-4 py-2">${leaderIndex + 1}</td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][leader_name]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Leader name" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][position]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Leader position" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <select name="leaders[${leaderIndex}][gender]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                <option value="">Select gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </td>
    `;
    
    tableBody.appendChild(newRow);
    leaderIndex++;
    
    // Update row numbers
    updateRowNumbers();
});

document.getElementById('remove-leader').addEventListener('click', function() {
    const tableBody = document.getElementById('leaders-table');
    if (tableBody.children.length > 1) {
        tableBody.removeChild(tableBody.lastElementChild);
        leaderIndex--;
        updateRowNumbers();
    }
});

function updateRowNumbers() {
    const tableBody = document.getElementById('leaders-table');
    const rows = tableBody.children;
    
    for (let i = 0; i < rows.length; i++) {
        rows[i].children[0].textContent = i + 1;
    }
}
</script>
@endsection
