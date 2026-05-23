<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maelezo ya Chuo Kikuu') }}
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
                    <h2 class="text-xl font-bold text-gray-800 uppercase">FOMU YA TAARIFA ZA CHUO KIKUU</h2>
                </div>
                
                <form method="POST" action="{{ route('submissions.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="section_type" value="school_university">

                    <!-- TAARIFA ZA MWANAFUNZI Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">TAARIFA ZA MWANAFUNZI</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">1. Jina la Mwanafunzi: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[student_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.student_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">2. Jina la Chuo Kikuu: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[university_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.university_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">3. Kozi/Programu: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[course_program]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.course_program') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">4. Kiwango cha Programu: <span class="text-red-500">*</span></label>
                                <select name="form_data[program_level]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Chagua Kiwango cha Programu --</option>
                                    <option value="Certificate" {{ old('form_data.program_level') == 'Certificate' ? 'selected' : '' }}>Certificate</option>
                                    <option value="Diploma" {{ old('form_data.program_level') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                    <option value="Bachelor's Degree" {{ old('form_data.program_level') == 'Bachelor\'s Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="Master's Degree" {{ old('form_data.program_level') == 'Master\'s Degree' ? 'selected' : '' }}>Master's Degree</option>
                                    <option value="PhD" {{ old('form_data.program_level') == 'PhD' ? 'selected' : '' }}>PhD</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">5. Mbinu wa Masomo: <span class="text-red-500">*</span></label>
                                <select name="form_data[study_method]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Chagua Mbinu --</option>
                                    <option value="Full Time" {{ old('form_data.study_method') == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="Part Time" {{ old('form_data.study_method') == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="Distance Learning" {{ old('form_data.study_method') == 'Distance Learning' ? 'selected' : '' }}>Distance Learning</option>
                                    <option value="Online" {{ old('form_data.study_method') == 'Online' ? 'selected' : '' }}>Online</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">6. Tarehe ya Kukamaliza (inayotarajiwa): <span class="text-red-500">*</span></label>
                                <input type="date" name="form_data[completion_date]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.completion_date') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">7. Hali ya Kielimu: <span class="text-red-500">*</span></label>
                                <select name="form_data[education_status]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Chagua Hali --</option>
                                    <option value="Currently Studying" {{ old('form_data.education_status') == 'Currently Studying' ? 'selected' : '' }}>Currently Studying</option>
                                    <option value="Graduated" {{ old('form_data.education_status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                                    <option value="Suspended" {{ old('form_data.education_status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                    <option value="Dropped Out" {{ old('form_data.education_status') == 'Dropped Out' ? 'selected' : '' }}>Dropped Out</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">8. Anwani ya Chuo Kikuu: <span class="text-red-500">*</span></label>
                                <textarea name="form_data[university_address]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="3" required>{{ old('form_data.university_address') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">9. Changamoto za Mwanafunzi:</label>
                                <textarea name="form_data[student_challenges]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="4" placeholder="Tafadhali eleza changamoto zozote za kimasomo, kifedha au binafsi ambazo mwanafunzi anakabiliana nazo">{{ old('form_data.student_challenges') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">10. Mafanikio Unathiligika:</label>
                                <textarea name="form_data[achievements]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="4" placeholder="Ni nini gani ya mafanikio ya mwanafunzi anakumbukwa nayo">{{ old('form_data.achievements') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center pt-6">
                        <button type="submit" name="action" value="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-md uppercase tracking-wide transition duration-200">
                            WASILISHA FOMU
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>