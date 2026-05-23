@extends('layouts.app')

@section('title', 'FOMU YA TAARIFA ZA VIONGOZI WA KITAIFA')

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

                <form action="{{ route('national-leadership.store') }}" method="POST">
                    @csrf

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">FOMU YA TAARIFA ZA VIONGOZI WA KITAIFA</h2>
                    </div>

                    <!-- TAARIFA ZA MSINGI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">TAARIFA ZA MSINGI</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Kituo -->
                            <div>
                                <label for="center" class="block text-sm font-medium text-gray-700 mb-2">
                                    1. Kituo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="center" name="center" value="{{ old('center') }}" 
                                       placeholder="Weka jina la kituo"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>

                            <!-- Muda wa Kumaliza Uongozi -->
                            <div>
                                <label for="term_end" class="block text-sm font-medium text-gray-700 mb-2">
                                    2. Muda wa Kumaliza Uongozi <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="term_end" name="term_end" value="{{ old('term_end') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>
                    </div>

                    <!-- ORODHA YA VIONGOZI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">ORODHA YA VIONGOZI</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Namba</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Jina la Kiongozi</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Namba ya Mshiriki</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Cheo</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Jinsia</th>
                                    </tr>
                                </thead>
                                <tbody id="leaders-table">
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">1</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" name="leaders[0][leader_name]" 
                                                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                   placeholder="Jina la kiongozi" required>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" name="leaders[0][participant_number]" 
                                                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                   placeholder="Namba ya mshiriki" required>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <input type="text" name="leaders[0][position]" 
                                                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                                                   placeholder="Cheo cha kiongozi" required>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <select name="leaders[0][gender]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                                                <option value="">Chagua jinsia</option>
                                                <option value="male">Mwanaume</option>
                                                <option value="female">Mwanamke</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" id="add-leader" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Ongeza Kiongozi
                            </button>
                            <button type="button" id="remove-leader" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">
                                Ondoa Kiongozi
                            </button>
                        </div>
                    </div>

                    <!-- CHANGAMOTO -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">CHANGAMOTO</h3>
                        
                        <div>
                            <label for="challenges" class="block text-sm font-medium text-gray-700 mb-2">
                                3. Changamoto za Uongozi
                            </label>
                            <textarea id="challenges" name="challenges" rows="4" 
                                      placeholder="Weka changamoto zozote za uongozi"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('challenges') }}</textarea>
                        </div>
                    </div>

                    <!-- MAONI -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 border-b border-blue-300 pb-2">MAONI</h3>
                        
                        <div>
                            <label for="comments" class="block text-sm font-medium text-gray-700 mb-2">
                                4. Maoni ya Ziada
                            </label>
                            <textarea id="comments" name="comments" rows="4" 
                                      placeholder="Weka maoni yoyote kuhusu uongozi wa kitaifa"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('comments') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg font-semibold">
                            WASILISHA TAARIFA
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
        <td class="border border-gray-300 px-4 py-2">${leaderIndex + 1}</td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][leader_name]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Jina la kiongozi" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][participant_number]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Namba ya mshiriki" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <input type="text" name="leaders[${leaderIndex}][position]" 
                   class="w-full px-2 py-1 border border-gray-300 rounded" 
                   placeholder="Cheo cha kiongozi" required>
        </td>
        <td class="border border-gray-300 px-4 py-2">
            <select name="leaders[${leaderIndex}][gender]" class="w-full px-2 py-1 border border-gray-300 rounded" required>
                <option value="">Chagua jinsia</option>
                <option value="male">Mwanaume</option>
                <option value="female">Mwanamke</option>
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