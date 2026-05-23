<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-clipboard-data me-2"></i>{{ $pageTitle ?? 'Exam Results' }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-3 border-bottom" style="background: linear-gradient(135deg, #c026d3, #7c3aed); color: #fff;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h3 class="h5 mb-1"><i class="bi bi-graph-up me-2"></i>Fomu ya {{ $sectionName ?? 'Exam Results' }}</h3>
                            <p class="mb-0" style="color: rgba(255,255,255,.9);">Andika matokeo ya mitihani kwa mpangilio wa wazi na wa haraka kujaza.</p>
                        </div>
                        <span class="badge bg-light text-dark px-3 py-2">Exam Entry</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('submissions.store') }}" class="p-4 p-md-5">
                    @csrf
                    <input type="hidden" name="section_type" value="{{ $sectionType }}">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-person me-2 text-primary"></i>Child / Student Name</label>
                            <input type="text" name="form_data[student_name]" class="form-control form-control-lg" value="{{ old('form_data.student_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-2 text-primary"></i>School / Institution Name</label>
                            <input type="text" name="form_data[school_name]" class="form-control form-control-lg" value="{{ old('form_data.school_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-journal-text me-2 text-primary"></i>Darasa / ngazi</label>
                            <select name="form_data[class_level]" class="form-select form-select-lg" required>
                                <option value="">-- Select --</option>
                                @foreach($classOptions as $option)
                                    <option value="{{ $option }}" {{ old('form_data.class_level') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>Aina ya mtihani</label>
                            <select name="form_data[exam_type]" class="form-select form-select-lg" required>
                                <option value="">-- Select --</option>
                                @foreach($examOptions as $option)
                                    <option value="{{ $option }}" {{ old('form_data.exam_type') === $option ? 'selected' : '' }}>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar3 me-2 text-primary"></i>Mwaka wa mtihani</label>
                            <input type="number" name="form_data[exam_year]" min="2000" max="2100" class="form-control form-control-lg" value="{{ old('form_data.exam_year', now()->year) }}" required>
                        </div>

                        <div class="col-md-6">
                            @if($usesGpa)
                                <label class="form-label fw-semibold"><i class="bi bi-calculator me-2 text-primary"></i>GPA</label>
                                <input type="text" name="form_data[gpa]" class="form-control form-control-lg" value="{{ old('form_data.gpa') }}" placeholder="Mfano: 3.8 / 5.0" required>
                            @else
                                <label class="form-label fw-semibold"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Ufaulu wa jumla</label>
                                <select name="form_data[performance]" class="form-select form-select-lg" required>
                                    <option value="">-- Select --</option>
                                    @foreach(['Nzuri Sana', 'Nzuri', 'Wastani', 'Hafifu'] as $performance)
                                        <option value="{{ $performance }}" {{ old('form_data.performance') === $performance ? 'selected' : '' }}>{{ $performance }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-award me-2 text-primary"></i>Masomo aliyofanya vizuri</label>
                            <input type="text" name="form_data[best_subjects]" class="form-control form-control-lg" value="{{ old('form_data.best_subjects') }}" placeholder="Example: English, Biology">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-exclamation-diamond me-2 text-primary"></i>Masomo yenye changamoto</label>
                            <input type="text" name="form_data[failed_subjects]" class="form-control form-control-lg" value="{{ old('form_data.failed_subjects') }}" placeholder="Mfano: Hisabati, Chemistry">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold"><i class="bi bi-chat-square-text me-2 text-primary"></i>Additional Comments</label>
                            <textarea name="form_data[comments]" class="form-control form-control-lg" rows="5">{{ old('form_data.comments') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end align-items-center gap-3 mt-4 pt-4 border-top">
                        <button type="submit" name="action" value="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-send-fill me-2"></i>Submit Results
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
