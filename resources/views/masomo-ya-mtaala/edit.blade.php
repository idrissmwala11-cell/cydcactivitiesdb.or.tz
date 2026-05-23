<x-app-layout>
    <x-slot name="header">
        @php
            $isAdminView = auth()->user()->role === 'admin';
            $showRoute = $isAdminView
                ? route('admin.masomo-ya-mtaala.show', $masomoYaMtaala)
                : route('submissions.masomo-ya-mtaala.show', $masomoYaMtaala);
            $updateRoute = $isAdminView
                ? route('admin.masomo-ya-mtaala.update', $masomoYaMtaala)
                : route('submissions.masomo-ya-mtaala.update', $masomoYaMtaala);
        @endphp
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600">Curriculum Studies</p>
                <h2 class="mt-1 text-2xl font-bold leading-tight text-gray-900">
                    Edit Curriculum Record
                </h2>
            </div>

            <a href="{{ $showRoute }}"
               class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                Back to Record
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700 shadow-sm">
                    <p class="mb-2 font-semibold">Please fix the following issues:</p>
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $updateRoute }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="overflow-hidden rounded-[2rem] border border-blue-100 bg-white shadow-[0_24px_60px_-32px_rgba(37,99,235,0.35)]">
                    <div class="border-b border-blue-100 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-6 py-6 text-white">
                        <h3 class="text-xl font-semibold">Lesson Information</h3>
                        <p class="mt-1 text-sm text-blue-100">Update the teacher, lesson, and grade details below.</p>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="lesson_date" class="mb-2 block text-sm font-semibold text-gray-700">Date</label>
                                <input type="date" name="lesson_date" id="lesson_date"
                                       value="{{ old('lesson_date', $masomoYaMtaala->lesson_date?->format('Y-m-d')) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label for="instructor_name" class="mb-2 block text-sm font-semibold text-gray-700">Teacher Name</label>
                                <input type="text" name="instructor_name" id="instructor_name"
                                       value="{{ old('instructor_name', $masomoYaMtaala->instructor_name) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label for="subject" class="mb-2 block text-sm font-semibold text-gray-700">Subject Taught</label>
                                <input type="text" name="subject" id="subject"
                                       value="{{ old('subject', $masomoYaMtaala->subject) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label for="grade_level" class="mb-2 block text-sm font-semibold text-gray-700">Grade / Level</label>
                                <select name="grade_level" id="grade_level"
                                        class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                                    <option value="">Select grade/level...</option>
                                    @for($i = 1; $i <= 7; $i++)
                                        <option value="Standard {{ $i }}" {{ old('grade_level', $masomoYaMtaala->grade_level) === 'Standard '.$i ? 'selected' : '' }}>
                                            Standard {{ $i }}
                                        </option>
                                    @endfor
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="Form {{ $i }}" {{ old('grade_level', $masomoYaMtaala->grade_level) === 'Form '.$i ? 'selected' : '' }}>
                                            Form {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="lesson_topic" class="mb-2 block text-sm font-semibold text-gray-700">Lesson Topic</label>
                                <input type="text" name="lesson_topic" id="lesson_topic"
                                       value="{{ old('lesson_topic', $masomoYaMtaala->lesson_topic) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div class="md:col-span-2">
                                <label for="class_section" class="mb-2 block text-sm font-semibold text-gray-700">Class Section</label>
                                <input type="text" name="class_section" id="class_section"
                                       value="{{ old('class_section', $masomoYaMtaala->class_section) }}"
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-[2rem] border border-emerald-100 bg-white shadow-[0_24px_60px_-32px_rgba(16,185,129,0.28)]">
                    <div class="border-b border-emerald-100 bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-6 text-white">
                        <h3 class="text-xl font-semibold">Assessment Settings</h3>
                        <p class="mt-1 text-sm text-emerald-100">Choose the lesson type and update performance details.</p>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="mb-3 block text-sm font-semibold text-gray-700">Lesson Category</label>
                                <div class="rounded-3xl border border-emerald-100 bg-emerald-50/60 p-5">
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        @foreach(['kiroho' => 'Spiritual', 'kimwili' => 'Physical', 'kiakili' => 'Mental', 'kijamii' => 'Social'] as $type => $label)
                                            <label for="edit_category_{{ $type }}" class="flex cursor-pointer items-center gap-3 rounded-2xl border border-white bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50">
                                                <input type="radio"
                                                       name="category"
                                                       value="{{ $type }}"
                                                       id="edit_category_{{ $type }}"
                                                       {{ old('category', $masomoYaMtaala->current_category) === $type ? 'checked' : '' }}
                                                       required
                                                       class="h-4 w-4 border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                                <span>{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="performance_rating" class="mb-2 block text-sm font-semibold text-gray-700">Performance Rating (1-10)</label>
                                <input type="number" name="performance_rating" id="performance_rating" min="1" max="10"
                                       value="{{ old('performance_rating', $masomoYaMtaala->performance_rating) }}"
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-100">
                            </div>

                            <div>
                                <label for="status" class="mb-2 block text-sm font-semibold text-gray-700">Status</label>
                                <select name="status" id="status" required
                                        class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-100">
                                    <option value="pending" {{ old('status', $masomoYaMtaala->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ old('status', $masomoYaMtaala->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ old('status', $masomoYaMtaala->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="reviewed" {{ old('status', $masomoYaMtaala->status) === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-[2rem] border border-amber-100 bg-white shadow-[0_24px_60px_-32px_rgba(245,158,11,0.28)]">
                    <div class="border-b border-amber-100 bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-6 text-white">
                        <h3 class="text-xl font-semibold">Comments</h3>
                        <p class="mt-1 text-sm text-amber-100">Record notes from the instructor and supervisor.</p>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="instructor_comments" class="mb-2 block text-sm font-semibold text-gray-700">Instructor Comments</label>
                                <textarea name="instructor_comments" id="instructor_comments" rows="5"
                                          class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100">{{ old('instructor_comments', $masomoYaMtaala->instructor_comments) }}</textarea>
                            </div>

                            <div>
                                <label for="supervisor_comments" class="mb-2 block text-sm font-semibold text-gray-700">Supervisor Comments</label>
                                <textarea name="supervisor_comments" id="supervisor_comments" rows="5"
                                          class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100">{{ old('supervisor_comments', $masomoYaMtaala->supervisor_comments) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-[2rem] border border-gray-200 bg-white shadow-sm">
                    <div class="p-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ $showRoute }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:-translate-y-0.5 hover:bg-blue-700">
                            Update Record
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
