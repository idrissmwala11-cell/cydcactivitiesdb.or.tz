<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vocational Training Information') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Back
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 uppercase">VOCATIONAL TRAINING INFORMATION</h2>
                </div>
                
                <form method="POST" action="{{ route($sectionRoute . '.store') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Student Name <span class="text-red-500">*</span></label>
                            <input type="text" name="form_data[student_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.student_name') }}" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">School/Institution Name <span class="text-red-500">*</span></label>
                            <input type="text" name="form_data[school_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.school_name') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category of Skills <span class="text-red-500">*</span></label>
                            <select name="form_data[skill_category]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">-- Select Category --</option>
                                @php
                                    $categories = ['Carpentry','Tailoring','Welding','Mechanics','ICT','Agriculture','Hospitality','Electrical','Plumbing','Other'];
                                @endphp
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('form_data.skill_category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Training Level <span class="text-red-500">*</span></label>
                            <select name="form_data[training_level]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">-- Select Level --</option>
                                @php
                                    $levels = ['Beginner','Intermediate','Advanced','Certificate','Diploma'];
                                @endphp
                                @foreach($levels as $lvl)
                                    <option value="{{ $lvl }}" {{ old('form_data.training_level') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-center pt-6">
                        <button type="submit" name="action" value="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md uppercase tracking-wide transition duration-200">
                            Submit Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
