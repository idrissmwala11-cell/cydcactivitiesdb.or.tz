@csrf

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">{{ strtoupper($section['title']) }}</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="student_name" class="form-label">1. Student Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('student_name') is-invalid @enderror" id="student_name" name="student_name" value="{{ old('student_name', $examResult->student_name ?? '') }}" required>
                @error('student_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="school_name" class="form-label">2. School / Institution Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('school_name') is-invalid @enderror" id="school_name" name="school_name" value="{{ old('school_name', $examResult->school_name ?? '') }}" required>
                @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="class_level" class="form-label">3. Class / Level <span class="text-danger">*</span></label>
                <select class="form-select @error('class_level') is-invalid @enderror" id="class_level" name="class_level" required>
                    <option value="">-- Select --</option>
                    @foreach($section['class_options'] as $option)
                        <option value="{{ $option }}" @selected(old('class_level', $examResult->class_level ?? '') === $option)>{{ $option }}</option>
                    @endforeach
                </select>
                @error('class_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="exam_type" class="form-label">4. Exam Type <span class="text-danger">*</span></label>
                <select class="form-select @error('exam_type') is-invalid @enderror" id="exam_type" name="exam_type" required>
                    <option value="">-- Select --</option>
                    @foreach($section['exam_options'] as $option)
                        <option value="{{ $option }}" @selected(old('exam_type', $examResult->exam_type ?? '') === $option)>{{ $option }}</option>
                    @endforeach
                </select>
                @error('exam_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="exam_year" class="form-label">5. Exam Year <span class="text-danger">*</span></label>
                <input type="number" min="2000" max="2100" class="form-control @error('exam_year') is-invalid @enderror" id="exam_year" name="exam_year" value="{{ old('exam_year', $examResult->exam_year ?? now()->year) }}" required>
                @error('exam_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                @if($section['uses_gpa'])
                    <label for="gpa" class="form-label">6. GPA <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('gpa') is-invalid @enderror" id="gpa" name="gpa" value="{{ old('gpa', $examResult->gpa ?? '') }}" placeholder="Example: 3.8 / 5.0" required>
                    @error('gpa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @else
                    <label for="performance" class="form-label">6. Overall Performance <span class="text-danger">*</span></label>
                    <select class="form-select @error('performance') is-invalid @enderror" id="performance" name="performance" required>
                        <option value="">-- Select --</option>
                        @foreach(['Excellent', 'Good', 'Average', 'Poor'] as $option)
                            <option value="{{ $option }}" @selected(old('performance', $examResult->performance ?? '') === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                    @error('performance') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @endif
            </div>

            <div class="col-md-6">
                <label for="best_subjects" class="form-label">7. Best Subjects</label>
                <textarea class="form-control @error('best_subjects') is-invalid @enderror" id="best_subjects" name="best_subjects" rows="3">{{ old('best_subjects', $examResult->best_subjects ?? '') }}</textarea>
                @error('best_subjects') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="failed_subjects" class="form-label">8. Subjects with Challenges</label>
                <textarea class="form-control @error('failed_subjects') is-invalid @enderror" id="failed_subjects" name="failed_subjects" rows="3">{{ old('failed_subjects', $examResult->failed_subjects ?? '') }}</textarea>
                @error('failed_subjects') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label for="comments" class="form-label">9. Additional Comments</label>
                <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" rows="4">{{ old('comments', $examResult->comments ?? '') }}</textarea>
                @error('comments') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="{{ route($section['route'] . '.index') }}" class="btn btn-secondary me-md-2">
        <i class="bi bi-x-circle me-1"></i> Cancel
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> Save
    </button>
</div>
