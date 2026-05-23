<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Parent Information') }}
        </h2>
    </x-slot>

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

                    <form action="{{ route('parents-information.update', $parentsInformation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Parent Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Parent Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        First Name *
                                    </label>
                                    <input type="text" name="first_name" id="first_name" 
                                           value="{{ old('first_name', $parentsInformation->first_name) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           required>
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Last Name *
                                    </label>
                                    <input type="text" name="last_name" id="last_name" 
                                           value="{{ old('last_name', $parentsInformation->last_name) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           required>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Phone Number *
                                    </label>
                                    <input type="tel" name="phone" id="phone" 
                                           value="{{ old('phone', $parentsInformation->phone) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           required>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email Address
                                    </label>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $parentsInformation->email) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                                        Date of Birth
                                    </label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" 
                                           value="{{ old('date_of_birth', $parentsInformation->date_of_birth) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                        Gender
                                    </label>
                                    <select name="gender" id="gender" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $parentsInformation->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $parentsInformation->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Occupation
                                    </label>
                                    <input type="text" name="occupation" id="occupation" 
                                           value="{{ old('occupation', $parentsInformation->occupation) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="education_level" class="block text-sm font-medium text-gray-700 mb-2">
                                        Education Level
                                    </label>
                                    <select name="education_level" id="education_level" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Education Level</option>
                                        <option value="primary" {{ old('education_level', $parentsInformation->education_level) == 'primary' ? 'selected' : '' }}>Primary Education</option>
                                        <option value="secondary" {{ old('education_level', $parentsInformation->education_level) == 'secondary' ? 'selected' : '' }}>Secondary Education</option>
                                        <option value="certificate" {{ old('education_level', $parentsInformation->education_level) == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                        <option value="diploma" {{ old('education_level', $parentsInformation->education_level) == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                        <option value="degree" {{ old('education_level', $parentsInformation->education_level) == 'degree' ? 'selected' : '' }}>Degree</option>
                                        <option value="postgraduate" {{ old('education_level', $parentsInformation->education_level) == 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                                        <option value="other" {{ old('education_level', $parentsInformation->education_level) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Child Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Child Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="child_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Child Name *
                                    </label>
                                    <input type="text" name="child_name" id="child_name" 
                                           value="{{ old('child_name', $parentsInformation->child_name) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           required>
                                </div>

                                <div>
                                    <label for="relationship" class="block text-sm font-medium text-gray-700 mb-2">
                                        Relationship to Child *
                                    </label>
                                    <select name="relationship" id="relationship" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                            required>
                                        <option value="">Select Relationship</option>
                                        <option value="father" {{ old('relationship', $parentsInformation->relationship) == 'father' ? 'selected' : '' }}>Father</option>
                                        <option value="mother" {{ old('relationship', $parentsInformation->relationship) == 'mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="guardian" {{ old('relationship', $parentsInformation->relationship) == 'guardian' ? 'selected' : '' }}>Guardian</option>
                                        <option value="stepfather" {{ old('relationship', $parentsInformation->relationship) == 'stepfather' ? 'selected' : '' }}>Stepfather</option>
                                        <option value="stepmother" {{ old('relationship', $parentsInformation->relationship) == 'stepmother' ? 'selected' : '' }}>Stepmother</option>
                                        <option value="grandparent" {{ old('relationship', $parentsInformation->relationship) == 'grandparent' ? 'selected' : '' }}>Grandparent</option>
                                        <option value="uncle" {{ old('relationship', $parentsInformation->relationship) == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                        <option value="aunt" {{ old('relationship', $parentsInformation->relationship) == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                        <option value="other" {{ old('relationship', $parentsInformation->relationship) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="child_age" class="block text-sm font-medium text-gray-700 mb-2">
                                        Child Age
                                    </label>
                                    <input type="number" name="child_age" id="child_age" 
                                           value="{{ old('child_age', $parentsInformation->child_age) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           min="0" max="25">
                                </div>

                                <div>
                                    <label for="child_grade" class="block text-sm font-medium text-gray-700 mb-2">
                                        Child Grade/Class
                                    </label>
                                    <input type="text" name="child_grade" id="child_grade" 
                                           value="{{ old('child_grade', $parentsInformation->child_grade) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Location Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                        Location/Village *
                                    </label>
                                    <input type="text" name="location" id="location" 
                                           value="{{ old('location', $parentsInformation->location) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           required>
                                </div>

                                <div>
                                    <label for="ward" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ward
                                    </label>
                                    <input type="text" name="ward" id="ward" 
                                           value="{{ old('ward', $parentsInformation->ward) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                                        District
                                    </label>
                                    <input type="text" name="district" id="district" 
                                           value="{{ old('district', $parentsInformation->district) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="region" class="block text-sm font-medium text-gray-700 mb-2">
                                        Region
                                    </label>
                                    <input type="text" name="region" id="region" 
                                           value="{{ old('region', $parentsInformation->region) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-2">
                                        Emergency Contact
                                    </label>
                                    <input type="tel" name="emergency_contact" id="emergency_contact" 
                                           value="{{ old('emergency_contact', $parentsInformation->emergency_contact) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status *
                                    </label>
                                    <select name="status" id="status" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                            required>
                                        <option value="active" {{ old('status', $parentsInformation->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $parentsInformation->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Notes
                                    </label>
                                    <textarea name="notes" id="notes" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="Any additional notes about the parent or child...">{{ old('notes', $parentsInformation->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('parents-information.show', $parentsInformation) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Update Parent Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>