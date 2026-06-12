<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Center Leadership Information') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('center-leadership.show', $centerLeadership) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Back
                </a>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 border-2 border-blue-300">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 uppercase">EDIT CENTER LEADERSHIP INFORMATION FORM</h2>
                </div>
                
                <form method="POST" action="{{ route('center-leadership.update', $centerLeadership) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- BASIC INFORMATION Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">BASIC INFORMATION</h3>
                        
                        <div class="space-y-4">
                            @php
                                $savedCenterName = old('center_name', $centerLeadership->center_name);
                                $displayCenterName = preg_match('/^\d+$/', (string) $savedCenterName) ? '' : $savedCenterName;
                            @endphp
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">1. Center Name <span class="text-red-500">*</span></label>
                                <input type="text" name="center_name" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ $displayCenterName }}" placeholder="Enter center name" required>
                                @if(preg_match('/^\d+$/', (string) $centerLeadership->center_name))
                                    <p class="mt-2 text-sm text-amber-600">This record previously saved a number instead of the center name. Please enter the correct center name.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- LEADERS LIST Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">LEADERS LIST</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">No.</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Leader Name</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Leader Phone Number</th>
                                        <th class="px-4 py-2 border border-gray-300 text-left text-sm font-medium text-gray-700">Position</th>
                                        <th class="px-4 py-2 border border-gray-300 text-center text-sm font-medium text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="leadership-table-body">
                                    @foreach(old('leadership_list', $centerLeadership->leadership_list) as $index => $leader)
                                        <tr class="leadership-row">
                                            <td class="px-4 py-2 border border-gray-300">
                                                <input type="text" name="leadership_list[{{ $index }}][namba]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" value="{{ $leader['namba'] }}" required>
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300">
                                                <input type="text" name="leadership_list[{{ $index }}][jina_la_kiongozi]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" value="{{ $leader['jina_la_kiongozi'] }}" required>
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300">
                                                <input type="text" name="leadership_list[{{ $index }}][namba_ya_kiongozi]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" value="{{ $leader['namba_ya_kiongozi'] }}" required>
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300">
                                                <input type="text" name="leadership_list[{{ $index }}][cheo]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" value="{{ $leader['cheo'] }}" required>
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 text-center">
                                                <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600" {{ count($centerLeadership->leadership_list) <= 1 ? 'style=display:none' : '' }}>Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" id="add-leadership-row" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Add Leader
                            </button>
                        </div>
                    </div>

                    <!-- CHALLENGES Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">CHALLENGES</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">3. Current Challenges</label>
                            <textarea name="challenges" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="4" placeholder="Describe any challenges the leaders are facing">{{ old('challenges', $centerLeadership->challenges) }}</textarea>
                        </div>
                    </div>

                    <!-- COMMENTS Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">COMMENTS</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">4. Additional Comments</label>
                            <textarea name="feedback" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="4" placeholder="Add any comments about the center leadership">{{ old('feedback', $centerLeadership->feedback) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-center pt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md uppercase tracking-wide transition duration-200">
                            Update Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let rowIndex = {{ count($centerLeadership->leadership_list) }};
        
        document.getElementById('add-leadership-row').addEventListener('click', function() {
            const tableBody = document.getElementById('leadership-table-body');
            const newRow = document.createElement('tr');
            newRow.className = 'leadership-row';
            newRow.innerHTML = `
                <td class="px-4 py-2 border border-gray-300">
                    <input type="text" name="leadership_list[${rowIndex}][namba]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" placeholder="${rowIndex + 1}" required>
                </td>
                <td class="px-4 py-2 border border-gray-300">
                    <input type="text" name="leadership_list[${rowIndex}][jina_la_kiongozi]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" placeholder="Leader name" required>
                </td>
                <td class="px-4 py-2 border border-gray-300">
                    <input type="text" name="leadership_list[${rowIndex}][namba_ya_kiongozi]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" placeholder="Phone number" required>
                </td>
                <td class="px-4 py-2 border border-gray-300">
                    <input type="text" name="leadership_list[${rowIndex}][cheo]" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500" placeholder="Position" required>
                </td>
                <td class="px-4 py-2 border border-gray-300 text-center">
                    <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">Remove</button>
                </td>
            `;
            tableBody.appendChild(newRow);
            rowIndex++;
            updateRemoveButtons();
        });
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
                updateRemoveButtons();
            }
        });
        
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.leadership-row');
            rows.forEach((row, index) => {
                const removeButton = row.querySelector('.remove-row');
                if (rows.length > 1) {
                    removeButton.style.display = 'inline-block';
                } else {
                    removeButton.style.display = 'none';
                }
            });
        }
        
        // Initialize remove buttons on page load
        updateRemoveButtons();
    </script>
</x-app-layout>
