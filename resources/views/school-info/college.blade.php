<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('College Information') }}
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
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <h2 class="text-xl font-bold text-gray-800 uppercase mb-0">College Information Form</h2>
                    <a href="{{ route($sectionRoute . '.index') }}" class="inline-flex items-center px-4 py-2 rounded-pill border border-gray-300 bg-gray-50 text-gray-700 shadow-sm hover:bg-white hover:shadow transition">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                </div>
                
                <form method="POST" action="{{ route($sectionRoute . '.store') }}" class="space-y-6">
                    @csrf

                    <!-- STUDENT INFORMATION Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">Student Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">1. Student Name: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[student_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.student_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">2. College Name: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[college_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.college_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">3. Course / Program: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[course_program]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.course_program') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">4. Program Level: <span class="text-red-500">*</span></label>
                                <select name="form_data[program_level]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Select Program Level --</option>
                                    <option value="Certificate" {{ old('form_data.program_level') == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                                    <option value="Diploma" {{ old('form_data.program_level') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="Advanced Diploma" {{ old('form_data.program_level') == 'Advanced Diploma' ? 'selected' : '' }}>Advanced Diploma</option>
                                    <option value="Professional Course" {{ old('form_data.program_level') == 'Professional Course' ? 'selected' : '' }}>Professional Course</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">5. Expected Completion Date: <span class="text-red-500">*</span></label>
                                <input type="date" name="form_data[completion_date]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.completion_date') }}" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">6. College Address: <span class="text-red-500">*</span></label>
                                <textarea name="form_data[college_address]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="3" required>{{ old('form_data.college_address') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">7. Current Challenges:</label>
                                <textarea name="form_data[current_challenges]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="4" placeholder="Please describe any challenges the student is facing">{{ old('form_data.current_challenges') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3 pt-6">
                        <button type="submit" name="action" value="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md uppercase tracking-wide transition duration-200">
                            Submit Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
