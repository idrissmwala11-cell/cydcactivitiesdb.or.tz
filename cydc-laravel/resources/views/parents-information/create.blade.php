@extends('layouts.app')

@section('title', 'Add New Parent Information')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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

                    <form action="{{ route('parents-information.store') }}" method="POST">
                        @csrf

                        <!-- Parents Information Form (Aligned with Controller Validation) -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-center text-gray-800 mb-6">PARENTS INFORMATION FORM</h3>
                            <div class="bg-gray-50 border rounded-lg p-6 space-y-6">
                                <!-- 1. Parent Name -->
                                <div>
                                    <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-2">1. Jina la Mzazi/Mlezi *</label>
                                    <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jina kamili la mzazi/mlezi">
                                </div>

                                <!-- 2. Parent Of (Child Name) -->
                                <div>
                                    <label for="parent_of" class="block text-sm font-medium text-gray-700 mb-2">2. Mzazi wa *</label>
                                    <input type="text" name="parent_of" id="parent_of" value="{{ old('parent_of') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jina la mtoto">
                                </div>

                                <!-- 3. Activity -->
                                <div>
                                    <label for="activity" class="block text-sm font-medium text-gray-700 mb-2">3. Shughuli yake *</label>
                                    <input type="text" name="activity" id="activity" value="{{ old('activity') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Kazi yake">
                                </div>

                                <!-- 4. Support Type (Radios) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">4. Je, Mzazi anapokea Afua? *</label>
                                    <div class="flex flex-wrap gap-6 items-center">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="support_type" value="Hapana" class="mr-2" {{ old('support_type') == 'Hapana' ? 'checked' : '' }} required>
                                            <span>Hapana</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="support_type" value="HVC" class="mr-2" {{ old('support_type') == 'HVC' ? 'checked' : '' }} required>
                                            <span>HVC</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="support_type" value="IGA" class="mr-2" {{ old('support_type') == 'IGA' ? 'checked' : '' }} required>
                                            <span>IGA</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="support_type" value="CIV" class="mr-2" {{ old('support_type') == 'CIV' ? 'checked' : '' }} required>
                                            <span>CIV</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- 5. Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">5. Mahali anaopishi *</label>
                                    <textarea name="address" id="address" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Anwani kamili ya nyumba">{{ old('address') }}</textarea>
                                </div>

                                <!-- 6. Parent Comments -->
                                <div>
                                    <label for="parent_comments" class="block text-sm font-medium text-gray-700 mb-2">6. Maoni ya Mzazi kuhusu huduma</label>
                                    <textarea name="parent_comments" id="parent_comments" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Maoni yako kuhusu huduma tunayotoa">{{ old('parent_comments') }}</textarea>
                                </div>

                                <!-- 7. Supervisor Comments -->
                                <div>
                                    <label for="supervisor_comments" class="block text-sm font-medium text-gray-700 mb-2">7. Maoni ya Msimamizi</label>
                                    <textarea name="supervisor_comments" id="supervisor_comments" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Maoni ya msimamizi">{{ old('supervisor_comments') }}</textarea>
                                </div>

                                <!-- 8. Submission Date -->
                                <div>
                                    <label for="submission_date" class="block text-sm font-medium text-gray-700 mb-2">8. Tarehe ya kujaza taarifa *</label>
                                    <input type="date" name="submission_date" id="submission_date" value="{{ old('submission_date') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('parents-information.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Submit Information</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection