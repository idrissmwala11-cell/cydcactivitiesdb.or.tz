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
                    <form action="{{ route('skills-information.update', $skillsInformation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', $skillsInformation->date->format('Y-m-d'))" required />
                                <x-input-error class="mt-2" :messages="$errors->get('date')" />
                            </div>

                            <div>
                                <x-input-label for="skill_name" :value="__('Skill Name')" />
                                <x-text-input id="skill_name" name="skill_name" type="text" class="mt-1 block w-full" :value="old('skill_name', $skillsInformation->skill_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('skill_name')" />
                            </div>

                            <div>
                                <x-input-label for="teacher_name" :value="__('Teacher Name')" />
                                <x-text-input id="teacher_name" name="teacher_name" type="text" class="mt-1 block w-full" :value="old('teacher_name', $skillsInformation->teacher_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('teacher_name')" />
                            </div>

                            <div>
                                <x-input-label for="students_count" :value="__('Students Count')" />
                                <x-text-input id="students_count" name="students_count" type="number" class="mt-1 block w-full" :value="old('students_count', $skillsInformation->students_count)" required min="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('students_count')" />
                            </div>

                            <div>
                                <x-input-label for="lesson_topic" :value="__('Lesson Topic')" />
                                <x-text-input id="lesson_topic" name="lesson_topic" type="text" class="mt-1 block w-full" :value="old('lesson_topic', $skillsInformation->lesson_topic)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lesson_topic')" />
                            </div>

                            <div>
                                <x-input-label for="materials_used" :value="__('Materials Used')" />
                                <x-text-input id="materials_used" name="materials_used" type="text" class="mt-1 block w-full" :value="old('materials_used', $skillsInformation->materials_used)" />
                                <x-input-error class="mt-2" :messages="$errors->get('materials_used')" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label for="teacher_comments" :value="__('Teacher Comments')" />
                            <textarea id="teacher_comments" name="teacher_comments" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('teacher_comments', $skillsInformation->teacher_comments) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('teacher_comments')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="supervisor_comments" :value="__('Supervisor Comments')" />
                            <textarea id="supervisor_comments" name="supervisor_comments" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('supervisor_comments', $skillsInformation->supervisor_comments) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('supervisor_comments')" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('skills-information.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-3">
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
