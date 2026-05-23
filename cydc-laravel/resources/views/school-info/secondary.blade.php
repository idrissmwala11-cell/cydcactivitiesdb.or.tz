<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maelezo ya Shule: Sekondari') }}
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
                    <h2 class="text-xl font-bold text-gray-800 uppercase">FOMU YA TAARIFA ZA SHULE YA SEKONDARI</h2>
                </div>
                
                <form method="POST" action="{{ route('submissions.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="section_type" value="school_secondary">

                    <!-- TAARIFA ZA MSINGI Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">TAARIFA ZA MSINGI</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">1. Jina la Mwanafunzi: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[student_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.student_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">2. Jina la Shule: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[school_name]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.school_name') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">3. Kidato/Form: <span class="text-red-500">*</span></label>
                                <select name="form_data[form_level]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Chagua --</option>
                                    <option value="Form 1" {{ old('form_data.form_level') == 'Form 1' ? 'selected' : '' }}>Form 1</option>
                                    <option value="Form 2" {{ old('form_data.form_level') == 'Form 2' ? 'selected' : '' }}>Form 2</option>
                                    <option value="Form 3" {{ old('form_data.form_level') == 'Form 3' ? 'selected' : '' }}>Form 3</option>
                                    <option value="Form 4" {{ old('form_data.form_level') == 'Form 4' ? 'selected' : '' }}>Form 4</option>
                                    <option value="Form 5" {{ old('form_data.form_level') == 'Form 5' ? 'selected' : '' }}>Form 5</option>
                                    <option value="Form 6" {{ old('form_data.form_level') == 'Form 6' ? 'selected' : '' }}>Form 6</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">4. Ufaulu: <span class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[performance]" value="Vizuri Sana" class="form-radio text-blue-600" {{ old('form_data.performance') == 'Vizuri Sana' ? 'checked' : '' }}>
                                        <span class="ml-2">Vizuri Sana</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[performance]" value="Wastani" class="form-radio text-blue-600" {{ old('form_data.performance') == 'Wastani' ? 'checked' : '' }}>
                                        <span class="ml-2">Wastani</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="form_data[performance]" value="Duni" class="form-radio text-blue-600" {{ old('form_data.performance') == 'Duni' ? 'checked' : '' }}>
                                        <span class="ml-2">Duni</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">5. Daraja la Elimu/kiwango: <span class="text-red-500">*</span></label>
                                <select name="form_data[education_level]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Chagua --</option>
                                    <option value="O-Level" {{ old('form_data.education_level') == 'O-Level' ? 'selected' : '' }}>O-Level</option>
                                    <option value="A-Level" {{ old('form_data.education_level') == 'A-Level' ? 'selected' : '' }}>A-Level</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">7. Tarehe ya kumaliza shule: <span class="text-red-500">*</span></label>
                                <input type="date" name="form_data[completion_date]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.completion_date') }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">8. Combination/darasa: <span class="text-red-500">*</span></label>
                                <input type="text" name="form_data[combination]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.combination') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- UFAULU WA MASOMO Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-blue-600 mb-4 uppercase">UFAULU WA MASOMO</h3>
                        <p class="text-sm text-gray-600 mb-4">9. Jana alama aliyopata kwa kila somo: <span class="text-red-500">*</span></p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">1. Kiswahili:</label>
                                <input type="text" name="form_data[kiswahili]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.kiswahili') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">2. Hisabati:</label>
                                <input type="text" name="form_data[hisabati]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.hisabati') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">3. Kiingereza:</label>
                                <input type="text" name="form_data[english]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.english') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">4. Uraia:</label>
                                <input type="text" name="form_data[uraia]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.uraia') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">5. Historia:</label>
                                <input type="text" name="form_data[historia]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.historia') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">6. Biolojia:</label>
                                <input type="text" name="form_data[biology]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.biology') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">7. Kemia:</label>
                                <input type="text" name="form_data[chemistry]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.chemistry') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">8. Uthabiti:</label>
                                <input type="text" name="form_data[physics]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.physics') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">9. Biashara:</label>
                                <input type="text" name="form_data[commerce]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" value="{{ old('form_data.commerce') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">10. Maoni ya Malimu/maelezo: <span class="text-red-500">*</span></label>
                                <textarea name="form_data[teacher_comments]" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" rows="4" required>{{ old('form_data.teacher_comments') }}</textarea>
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