<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Submission - ' . ucwords(str_replace('_', ' ', $submission->section_type))) }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('admin.submissions.show', $submission) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Back to Submission
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Form Data</h3>

                    <form method="POST" action="{{ route('admin.submissions.update', $submission) }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        @php
                            $formData = is_array($submission->form_data) ? $submission->form_data : (array) $submission->form_data;
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($formData as $key => $value)
                                @php
                                    $label = ucwords(str_replace('_', ' ', (string) $key));
                                    $raw = old("form_data.$key", is_array($value) ? json_encode($value) : $value);
                                    $isNumeric = is_numeric($raw);
                                    $isDate = \Illuminate\Support\Str::contains($key, ['date', 'tarehe']);
                                    $isLong = is_string($raw) && strlen($raw) > 120;
                                @endphp

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>

                                    @if($isDate)
                                        <input type="date" name="form_data[{{ $key }}]" value="{{ old("form_data.$key", $raw) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @elseif($isNumeric)
                                        <input type="number" step="any" name="form_data[{{ $key }}]" value="{{ old("form_data.$key", $raw) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @elseif(is_array($value))
                                        <textarea name="form_data[{{ $key }}]" rows="4" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder='{{ "Enter JSON (e.g., " . json_encode($value) . ")" }}'>{{ $raw }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Value detected as array. Provide JSON if you need to modify it.</p>
                                    @elseif($isLong)
                                        <textarea name="form_data[{{ $key }}]" rows="4" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old("form_data.$key", $raw) }}</textarea>
                                    @else
                                        <input type="text" name="form_data[{{ $key }}]" value="{{ old("form_data.$key", $raw) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @endif
                                </div>
                            @empty
                                <p class="text-sm text-gray-600">No form fields were found for this submission.</p>
                            @endforelse
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>