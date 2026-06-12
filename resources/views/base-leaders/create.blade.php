@extends('layouts.app')

@section('title', 'Base Leadership Information Form')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-blue-500">
            <div class="p-6">
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

                <form action="{{ route('base-leaders.store') }}" method="POST">
                    @csrf

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">BASE LEADERSHIP INFORMATION FORM</h2>
                    </div>

                    <!-- TAARIFA ZA MSINGI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">BASIC INFORMATION</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Base Name -->
                            <div>
                                <label for="base_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    1. Base Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="base_name" name="base_name" value="{{ old('base_name') }}" 
                                       placeholder="Enter base name"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <!-- Number of Leaders -->
                            <div>
                                <label for="leaders_count" class="block text-sm font-medium text-gray-700 mb-2">
                                    2. Number of Leaders <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="leaders_count" name="leaders_count" value="{{ old('leaders_count') }}" 
                                       placeholder="Enter number of leaders" min="1"
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
                                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Leader Number</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Position</th>
                                    </tr>
                                </thead>
                                <tbody id="leaders-table">
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="number" name="leaders[0][leader_number]" value="1" 
                                                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                   placeholder="No." required readonly>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" name="leaders[0][leader_name]" 
                                                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                   placeholder="Leader name" required>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" name="leaders[0][leader_id]" 
                                                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                   placeholder="Leader number" required>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <select name="leaders[0][leader_position]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                                                <option value="">Select position</option>
                                                <option value="Chairperson">Chairperson</option>
                                                <option value="Vice Chairperson">Vice Chairperson</option>
                                                <option value="Secretary">Secretary</option>
                                                <option value="Treasurer">Treasurer</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </td>
                                    </tr>
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

                    <!-- TAARIFA ZA VIKAO -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">MEETING INFORMATION</h3>
                        
                        <div>
                            <label for="meeting_count" class="block text-sm font-medium text-gray-700 mb-2">
                                3. Number of Meetings (7 Months) <span class="text-red-500">*</span>
                            </label>
                            <select id="meeting_count" name="meeting_count" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select number of meetings</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </div>
                    </div>

                    <!-- MUDA WA UONGOZI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">LEADERSHIP TERM</h3>
                        
                        <div>
                            <label for="term_end" class="block text-sm font-medium text-gray-700 mb-2">
                                4. Leadership Term End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="term_end" name="term_end" value="{{ old('term_end') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <!-- MAONI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">COMMENTS</h3>
                        
                        <div>
                            <label for="additional_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                5. Additional Comments
                            </label>
                            <textarea id="additional_notes" name="additional_notes" rows="4" 
                                      placeholder="Enter any comments about base leadership"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('additional_notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg font-semibold">
                            SUBMIT INFORMATION
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let leaderIndex = 1;

document.getElementById('add-leader').addEventListener('click', function() {
    const tableBody = document.getElementById('leaders-table');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td class="border border-gray-300 px-4 py-2">
            <input type="number" name="leaders[${leaderIndex}][leader_number]" value="${leaderIndex + 1}" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="No." required readonly>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][leader_name]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Leader name" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][leader_id]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Leader number" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <select name="leaders[${leaderIndex}][leader_position]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                <option value="">Select position</option>
                <option value="Chairperson">Chairperson</option>
                <option value="Vice Chairperson">Vice Chairperson</option>
                <option value="Secretary">Secretary</option>
                <option value="Treasurer">Treasurer</option>
                <option value="Other">Other</option>
            </select>
        </td>
    `;
    
    tableBody.appendChild(newRow);
    leaderIndex++;
});

document.getElementById('remove-leader').addEventListener('click', function() {
    const tableBody = document.getElementById('leaders-table');
    if (tableBody.children.length > 1) {
        tableBody.removeChild(tableBody.lastElementChild);
        leaderIndex--;
    }
});
</script>
@endsection
