<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Skills Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('skills-information.update', $skillsInformation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="student_name" :value="__('Student Name')" />
                                <x-text-input id="student_name" name="student_name" type="text" class="mt-1 block w-full"
                                    :value="old('student_name', $skillsInformation->student_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('student_name')" />
                            </div>

                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $skillsInformation->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $skillsInformation->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                            </div>

                            <div>
                                <x-input-label for="student_id" :value="__('Student ID')" />
                                <x-text-input id="student_id" name="student_id" type="text" class="mt-1 block w-full"
                                    :value="old('student_id', $skillsInformation->student_id)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('student_id')" />
                            </div>

                            <div>
                                <x-input-label for="skill_category" :value="__('Skill Category')" />
                                <x-text-input id="skill_category" name="skill_category" type="text" class="mt-1 block w-full"
                                    :value="old('skill_category', $skillsInformation->skill_category)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('skill_category')" />
                            </div>

                            <div>
                                <x-input-label for="skills_type" :value="__('Skills Type')" />
                                <x-text-input id="skills_type" name="skills_type" type="text" class="mt-1 block w-full"
                                    :value="old('skills_type', $skillsInformation->skills_type)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('skills_type')" />
                            </div>

                            <div>
                                <x-input-label for="skill_level" :value="__('Skill Level')" />
                                <select id="skill_level" name="skill_level" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Level</option>
                                    <option value="Beginner" {{ old('skill_level', $skillsInformation->skill_level) == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="Intermediate" {{ old('skill_level', $skillsInformation->skill_level) == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="Advanced" {{ old('skill_level', $skillsInformation->skill_level) == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="Expert" {{ old('skill_level', $skillsInformation->skill_level) == 'Expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('skill_level')" />
                            </div>

                            <div>
                                <x-input-label for="has_certification" :value="__('Has Certification')" />
                                <x-text-input id="has_certification" name="has_certification" type="text" class="mt-1 block w-full"
                                    :value="old('has_certification', $skillsInformation->has_certification)" />
                                <x-input-error class="mt-2" :messages="$errors->get('has_certification')" />
                            </div>

                            <div>
                                <x-input-label for="mentor" :value="__('Mentor')" />
                                <x-text-input id="mentor" name="mentor" type="text" class="mt-1 block w-full"
                                    :value="old('mentor', $skillsInformation->mentor)" />
                                <x-input-error class="mt-2" :messages="$errors->get('mentor')" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="specific_skills" :value="__('Specific Skills')" />
                            <textarea id="specific_skills" name="specific_skills" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>{{ old('specific_skills', $skillsInformation->specific_skills) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('specific_skills')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="group_skills_details" :value="__('Group Skills Details')" />
                            <textarea id="group_skills_details" name="group_skills_details" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('group_skills_details', $skillsInformation->group_skills_details) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('group_skills_details')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="certification_details" :value="__('Certification Details')" />
                            <textarea id="certification_details" name="certification_details" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('certification_details', $skillsInformation->certification_details) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('certification_details')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="challenges" :value="__('Challenges')" />
                            <textarea id="challenges" name="challenges" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('challenges', $skillsInformation->challenges) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('challenges')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="support_received" :value="__('Support Received')" />
                            <textarea id="support_received" name="support_received" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('support_received', $skillsInformation->support_received) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('support_received')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="comments" :value="__('Comments')" />
                            <textarea id="comments" name="comments" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('comments', $skillsInformation->comments) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('comments')" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('skills-information.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>