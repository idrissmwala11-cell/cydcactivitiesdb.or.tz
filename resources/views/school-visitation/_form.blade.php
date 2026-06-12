@csrf

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">SCHOOL VISITATION INFORMATION</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="participant_name" class="form-label">1. Participant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('participant_name') is-invalid @enderror" id="participant_name" name="participant_name" value="{{ old('participant_name', $schoolVisitation->participant_name ?? '') }}" required>
                @error('participant_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="registration_number" class="form-label">2. Registration Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('registration_number') is-invalid @enderror" id="registration_number" name="registration_number" value="{{ old('registration_number', $schoolVisitation->registration_number ?? '') }}" required>
                @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="school_name" class="form-label">3. School Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('school_name') is-invalid @enderror" id="school_name" name="school_name" value="{{ old('school_name', $schoolVisitation->school_name ?? '') }}" required>
                @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="class_level" class="form-label">4. Class Level <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('class_level') is-invalid @enderror" id="class_level" name="class_level" value="{{ old('class_level', $schoolVisitation->class_level ?? '') }}" required>
                @error('class_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="participant_presence" class="form-label">5. Participant Presence <span class="text-danger">*</span></label>
                <select class="form-select @error('participant_presence') is-invalid @enderror" id="participant_presence" name="participant_presence" required>
                    <option value="">-- Select --</option>
                    <option value="Present" @selected(old('participant_presence', $schoolVisitation->participant_presence ?? '') === 'Present')>Present</option>
                    <option value="Absent" @selected(old('participant_presence', $schoolVisitation->participant_presence ?? '') === 'Absent')>Absent</option>
                </select>
                @error('participant_presence') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="academic_progress" class="form-label">6. Academic Progress <span class="text-danger">*</span></label>
                <select class="form-select @error('academic_progress') is-invalid @enderror" id="academic_progress" name="academic_progress" required>
                    <option value="">-- Select --</option>
                    <option value="Satisfactory" @selected(old('academic_progress', $schoolVisitation->academic_progress ?? '') === 'Satisfactory')>Satisfactory</option>
                    <option value="Unsatisfactory" @selected(old('academic_progress', $schoolVisitation->academic_progress ?? '') === 'Unsatisfactory')>Unsatisfactory</option>
                </select>
                @error('academic_progress') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label for="academic_challenges" class="form-label">7. If unsatisfactory, what are the challenges?</label>
                <textarea class="form-control @error('academic_challenges') is-invalid @enderror" id="academic_challenges" name="academic_challenges" rows="3">{{ old('academic_challenges', $schoolVisitation->academic_challenges ?? '') }}</textarea>
                @error('academic_challenges') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="discipline_status" class="form-label">8. Discipline Status <span class="text-danger">*</span></label>
                <select class="form-select @error('discipline_status') is-invalid @enderror" id="discipline_status" name="discipline_status" required>
                    <option value="">-- Select --</option>
                    <option value="Good" @selected(old('discipline_status', $schoolVisitation->discipline_status ?? '') === 'Good')>Good</option>
                    <option value="Average" @selected(old('discipline_status', $schoolVisitation->discipline_status ?? '') === 'Average')>Average</option>
                    <option value="Poor" @selected(old('discipline_status', $schoolVisitation->discipline_status ?? '') === 'Poor')>Poor</option>
                </select>
                @error('discipline_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label for="cleanliness_status" class="form-label">9. Cleanliness Status <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('cleanliness_status') is-invalid @enderror" id="cleanliness_status" name="cleanliness_status" value="{{ old('cleanliness_status', $schoolVisitation->cleanliness_status ?? '') }}" placeholder="Example: Clean, Average, Unsatisfactory" required>
                @error('cleanliness_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label for="bad_behaviors" class="form-label">10. If discipline is poor, what bad behavior does the participant have?</label>
                <textarea class="form-control @error('bad_behaviors') is-invalid @enderror" id="bad_behaviors" name="bad_behaviors" rows="3">{{ old('bad_behaviors', $schoolVisitation->bad_behaviors ?? '') }}</textarea>
                @error('bad_behaviors') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label for="teacher_comments" class="form-label">11. Teacher Comments</label>
                <textarea class="form-control @error('teacher_comments') is-invalid @enderror" id="teacher_comments" name="teacher_comments" rows="3">{{ old('teacher_comments', $schoolVisitation->teacher_comments ?? '') }}</textarea>
                @error('teacher_comments') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label for="visitor_comments" class="form-label">12. Visitor Comments</label>
                <textarea class="form-control @error('visitor_comments') is-invalid @enderror" id="visitor_comments" name="visitor_comments" rows="4">{{ old('visitor_comments', $schoolVisitation->visitor_comments ?? '') }}</textarea>
                @error('visitor_comments') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="{{ route('school-visitation.index') }}" class="btn btn-secondary me-md-2">
        <i class="bi bi-x-circle me-1"></i> Cancel
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> Save
    </button>
</div>
