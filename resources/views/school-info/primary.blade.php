<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-book me-2"></i>{{ __('School Information: Primary') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

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
                <div class="px-4 py-3 border-bottom" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: #fff;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <h3 class="h5 mb-1"><i class="bi bi-mortarboard-fill me-2"></i>Primary School Information</h3>
                            <p class="mb-0" style="color: rgba(255,255,255,.9);">Fill in the student's school details and academic progress.</p>
                        </div>
                        <span class="badge bg-light text-primary px-3 py-2">Primary Form</span>
                    </div>
                </div>

                <form method="POST" action="{{ route($sectionRoute . '.store') }}" class="p-4 p-md-5">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-person me-2 text-primary"></i>Student Name</label>
                            <input type="text" name="form_data[student_name]" class="form-control form-control-lg" value="{{ old('form_data.student_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-building me-2 text-primary"></i>School Name</label>
                            <input type="text" name="form_data[school_name]" class="form-control form-control-lg" value="{{ old('form_data.school_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-journal-text me-2 text-primary"></i>Current Class</label>
                            <input type="text" name="form_data[class_level]" class="form-control form-control-lg" value="{{ old('form_data.class_level') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-2 text-primary"></i>Graduation Year</label>
                            <input type="number" name="form_data[graduation_year]" min="2000" max="2100" class="form-control form-control-lg" value="{{ old('form_data.graduation_year') }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Overall Performance</label>
                            <div class="row g-3">
                                @foreach(['Excellent', 'Good', 'Average', 'Poor'] as $performance)
                                    <div class="col-sm-6 col-lg-3">
                                        <label class="w-100 border rounded-3 px-3 py-3 d-flex align-items-center gap-2" style="cursor: pointer; background: #f8fafc;">
                                            <input type="radio" name="form_data[performance]" value="{{ $performance }}" class="form-check-input mt-0" {{ old('form_data.performance') == $performance ? 'checked' : '' }}>
                                            <span class="fw-semibold">{{ $performance }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-star me-2 text-primary"></i>Best Subjects</label>
                            <input type="text" name="form_data[best_subjects]" class="form-control form-control-lg" value="{{ old('form_data.best_subjects') }}" placeholder="Example: English, Science">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-exclamation-circle me-2 text-primary"></i>Subjects with Challenges</label>
                            <input type="text" name="form_data[failed_subjects]" class="form-control form-control-lg" value="{{ old('form_data.failed_subjects') }}" placeholder="Example: Mathematics, English">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-lightbulb me-2 text-primary"></i>Child's Dream</label>
                            <input type="text" name="form_data[child_dream]" class="form-control form-control-lg" value="{{ old('form_data.child_dream') }}" placeholder="Example: Doctor">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-chat-left-text me-2 text-primary"></i>Comments</label>
                            <textarea name="form_data[general_comments]" class="form-control form-control-lg" rows="5">{{ old('form_data.general_comments') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4 pt-4 border-top">
                        <a href="{{ route($sectionRoute . '.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
                        <button type="submit" name="action" value="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-send me-2"></i>Submit Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
