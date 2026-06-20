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
                                <label for="date" class="mb-2 block text-sm font-semibold text-gray-700">Date</label>
                                <input type="date" name="date" id="date"
                                       value="{{ old('date', $masomoYaMtaala->date?->format('Y-m-d')) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label for="jina_la_mwalimu" class="mb-2 block text-sm font-semibold text-gray-700">Teacher Name</label>
                                <input type="text" name="jina_la_mwalimu" id="jina_la_mwalimu"
                                       value="{{ old('jina_la_mwalimu', $masomoYaMtaala->teacher) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label for="somo_analofundisha" class="mb-2 block text-sm font-semibold text-gray-700">Subject Taught</label>
                                <input type="text" name="somo_analofundisha" id="somo_analofundisha"
                                       value="{{ old('somo_analofundisha', $masomoYaMtaala->subject_type) }}"
                                       required
                                       class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                            </div>

                            <div>
                                <label for="darasa_la_mjaka_mingapi" class="mb-2 block text-sm font-semibold text-gray-700">Grade / Level</label>
                                <select name="darasa_la_mjaka_mingapi" id="darasa_la_mjaka_mingapi"
                                        class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-100">
                                    <option value="">Select grade/level...</option>
                                    @for($i = 1; $i <= 7; $i++)
                                        <option value="Standard {{ $i }}" {{ old('darasa_la_mjaka_mingapi', $masomoYaMtaala->age_group) === 'Standard '.$i ? 'selected' : '' }}>
                                            Standard {{ $i }}
                                        </option>
                                    @endfor
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="Form {{ $i }}" {{ old('darasa_la_mjaka_mingapi', $masomoYaMtaala->age_group) === 'Form '.$i ? 'selected' : '' }}>
                                            Form {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="mada_aliyo_fundisha" class="mb-2 block text-sm font-semibold text-gray-700">Lesson Topic</label>
                                <input type="text" name="mada_aliyo_fundisha" id="mada_aliyo_fundisha"
                                       value="{{ old('mada_aliyo_fundisha', $masomoYaMtaala->topic) }}"
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
                                <label for="action" class="mb-2 block text-sm font-semibold text-gray-700">Save Option</label>
                                <select name="action" id="action" required
                                        class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-100">
                                    <option value="draft" {{ old('action', $masomoYaMtaala->status === 'submitted' ? 'submit' : 'draft') === 'draft' ? 'selected' : '' }}>Save as Draft</option>
                                    <option value="submit" {{ old('action', $masomoYaMtaala->status === 'submitted' ? 'submit' : 'draft') === 'submit' ? 'selected' : '' }}>Submit Record</option>
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
                                <label for="maoni_ya_mwanafunzi" class="mb-2 block text-sm font-semibold text-gray-700">Student Comments</label>
                                <textarea name="maoni_ya_mwanafunzi" id="maoni_ya_mwanafunzi" rows="5"
                                          class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100">{{ old('maoni_ya_mwanafunzi', $masomoYaMtaala->student_feedback) }}</textarea>
                            </div>

                            <div>
                                <label for="maoni_ya_mwalimu" class="mb-2 block text-sm font-semibold text-gray-700">Teacher Comments</label>
                                <textarea name="maoni_ya_mwalimu" id="maoni_ya_mwalimu" rows="5"
                                          class="w-full rounded-2xl border border-gray-200 bg-slate-50 px-4 py-3 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-100">{{ old('maoni_ya_mwalimu', $masomoYaMtaala->teacher_feedback) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                @include('program-day._participants-fields', ['record' => $masomoYaMtaala])

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
