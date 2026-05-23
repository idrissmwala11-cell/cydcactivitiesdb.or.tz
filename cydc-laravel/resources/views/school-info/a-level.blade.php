<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maelezo ya Shule: A-Level') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                    Rudi Nyuma
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
                    <h2 class="text-xl font-bold text-gray-800 uppercase">A LEVEL (FORM 5 & 6) INFORMATION FORM</h2>
                </div>
                
                <form method="POST" action="{{ route('submissions.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="section_type" value="school_a_level">

                    <!-- BASIC INFORMATION Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">BASIC INFORMATION</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">1. Student Name: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[student_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.student_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">2. School Name: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[school_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.school_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">3. School Address: <span class="text-red-500">*</span></label>
                                <textarea name="form_data[school_address]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="3" required>{{ old('form_data.school_address') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">4. Form Level: <span class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[form_level]" value="Form 5" class="form-radio text-blue-600" {{ old('form_data.form_level') == 'Form 5' ? 'checked' : '' }}>
                                        <span class="ml-2">Form 5</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[form_level]" value="Form 6" class="form-radio text-blue-600" {{ old('form_data.form_level') == 'Form 6' ? 'checked' : '' }}>
                                        <span class="ml-2">Form 6</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">5. School Completion Date (Form 6): <span class="text-red-500">*</span></label>
                                <input type="date" name="form_data[completion_date]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.completion_date') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">6. Student Performance: <span class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[performance]" value="Excellent" class="form-radio text-blue-600" {{ old('form_data.performance') == 'Excellent' ? 'checked' : '' }}>
                                        <span class="ml-2">Excellent</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[performance]" value="Average" class="form-radio text-blue-600" {{ old('form_data.performance') == 'Average' ? 'checked' : '' }}>
                                        <span class="ml-2">Average</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[performance]" value="Unsatisfactory" class="form-radio text-blue-600" {{ old('form_data.performance') == 'Unsatisfactory' ? 'checked' : '' }}>
                                        <span class="ml-2">Unsatisfactory</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">7. Division Achieved: <span class="text-red-500">*</span></label>
                                <select name="form_data[division]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">--Select--</option>
                                    <option value="Division I" {{ old('form_data.division') == 'Division I' ? 'selected' : '' }}>Division I</option>
                                    <option value="Division II" {{ old('form_data.division') == 'Division II' ? 'selected' : '' }}>Division II</option>
                                    <option value="Division III" {{ old('form_data.division') == 'Division III' ? 'selected' : '' }}>Division III</option>
                                    <option value="Division IV" {{ old('form_data.division') == 'Division IV' ? 'selected' : '' }}>Division IV</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Points Achieved: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[points]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.points') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">8. Subject Combination: <span class="text-red-500">*</span></label>
                                <div class="space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="HKL (History, Kiswahili, Literature)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'HKL (History, Kiswahili, Literature)' ? 'checked' : '' }}>
                                        <span class="ml-2">HKL (History, Kiswahili, Literature)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="HGK (History, Geography, Kiswahili)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'HGK (History, Geography, Kiswahili)' ? 'checked' : '' }}>
                                        <span class="ml-2">HGK (History, Geography, Kiswahili)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="PCB (Physics, Chemistry, Biology)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'PCB (Physics, Chemistry, Biology)' ? 'checked' : '' }}>
                                        <span class="ml-2">PCB (Physics, Chemistry, Biology)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="PCM (Physics, Chemistry, Mathematics)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'PCM (Physics, Chemistry, Mathematics)' ? 'checked' : '' }}>
                                        <span class="ml-2">PCM (Physics, Chemistry, Mathematics)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="CBG (Chemistry, Biology, Geography)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'CBG (Chemistry, Biology, Geography)' ? 'checked' : '' }}>
                                        <span class="ml-2">CBG (Chemistry, Biology, Geography)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="ECA (Economics, Commerce, Accountancy)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'ECA (Economics, Commerce, Accountancy)' ? 'checked' : '' }}>
                                        <span class="ml-2">ECA (Economics, Commerce, Accountancy)</span>
                                    </label>
                                    <br>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[subject_combination]" value="Other (Specify below)" class="form-radio text-blue-600" {{ old('form_data.subject_combination') == 'Other (Specify below)' ? 'checked' : '' }}>
                                        <span class="ml-2">Other (Specify below)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center pt-6">
                        <button type="submit" name="action" value="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md uppercase tracking-wide transition duration-200">
                            SUBMIT FORM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>