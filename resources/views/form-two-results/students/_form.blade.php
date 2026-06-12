@csrf
@if(isset($student)) @method('PUT') @endif
<input type="hidden" name="education_level" value="{{ $educationLevel }}">
<input type="hidden" name="class_level" value="{{ $classLevel }}">
@php($isPrimary = $educationLevel === 'primary')
<div class="row g-3">
    <div class="col-12"><div class="alert alert-info py-2 mb-0"><strong>Ngazi/Darasa:</strong> {{ $isPrimary ? 'Msingi' : 'Secondary' }} / {{ $classLevel }}</div></div>
    <div class="col-md-3"><label class="form-label">{{ $isPrimary ? 'Namba ya Mwanafunzi' : 'Student No.' }}</label><input class="form-control" name="student_number" value="{{ old('student_number', $student->student_number ?? '') }}" placeholder="{{ $isPrimary ? 'Itawekwa moja kwa moja ikiachwa wazi' : 'Auto if empty' }}"></div>
    <div class="col-md-5"><label class="form-label">{{ $isPrimary ? 'Jina la Mwanafunzi' : "Candidate's Name" }} *</label><input class="form-control" name="candidate_name" value="{{ old('candidate_name', $student->candidate_name ?? '') }}" required></div>
    <div class="col-md-3"><label class="form-label">Jina la FCP</label><input class="form-control" name="fcp_name" value="{{ old('fcp_name', $student->fcp_name ?? '') }}"></div>
    <div class="col-md-1"><label class="form-label">{{ $isPrimary ? 'Jinsi' : 'Sex' }} *</label><select class="form-select" name="sex" required><option value="F" @selected(old('sex', $student->sex ?? '') === 'F')>{{ $isPrimary ? 'Mke' : 'F' }}</option><option value="M" @selected(old('sex', $student->sex ?? '') === 'M')>{{ $isPrimary ? 'Mme' : 'M' }}</option></select></div>
    <div class="col-12">
        <label class="form-label fw-bold">{{ $isPrimary ? 'Masomo Anayofanya' : 'Registered Subjects (REG)' }}</label>
        @php($selected = collect(old('subject_ids', isset($student) ? $student->subjects->pluck('id')->all() : $subjects->where('is_active', true)->pluck('id')->all())))
        <div class="row g-2">
            @foreach($subjects as $subject)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <label class="border rounded p-2 w-100 {{ $subject->is_active ? '' : 'opacity-50' }}">
                        <input class="form-check-input me-1" type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" @checked($selected->contains($subject->id)) @disabled(! $subject->is_active && ! $selected->contains($subject->id))>
                        <strong>{{ $subject->abbreviation }}</strong> <span class="small text-muted">({{ $subject->code }})</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>
