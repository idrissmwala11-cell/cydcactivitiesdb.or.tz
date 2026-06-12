@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Add Attendance Record') }}</h4>
                    <a href="{{ route('talent-attendance.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('talent-attendance.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="date" class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                       id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="instructor_name" class="form-label">{{ __('Instructor Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instructor_name') is-invalid @enderror"
                                       id="instructor_name" name="instructor_name" value="{{ old('instructor_name') }}" required>
                                @error('instructor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="attendance_count" class="form-label">{{ __('Attendance Count') }}</label>
                                <input type="number" class="form-control bg-light"
                                       id="attendance_count" name="attendance_count" value="{{ old('attendance_count', 0) }}" min="0" readonly>
                                <small class="text-muted">Calculated automatically from participants below.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="talent_taught" class="form-label">{{ __('Talent Taught') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('talent_taught') is-invalid @enderror"
                                       id="talent_taught" name="talent_taught" value="{{ old('talent_taught') }}" required>
                                @error('talent_taught')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lesson_topic" class="form-label">{{ __('Lesson Topic') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lesson_topic') is-invalid @enderror"
                                       id="lesson_topic" name="lesson_topic" value="{{ old('lesson_topic') }}" required>
                                @error('lesson_topic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instructor_comments" class="form-label">{{ __('Instructor Comments') }}</label>
                                <textarea class="form-control @error('instructor_comments') is-invalid @enderror"
                                          id="instructor_comments" name="instructor_comments" rows="3">{{ old('instructor_comments') }}</textarea>
                                @error('instructor_comments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="supervisor_comments" class="form-label">{{ __('Supervisor Comments') }}</label>
                                <textarea class="form-control @error('supervisor_comments') is-invalid @enderror"
                                          id="supervisor_comments" name="supervisor_comments" rows="3">{{ old('supervisor_comments') }}</textarea>
                                @error('supervisor_comments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="text-primary mb-1">{{ __('Participants Attendance') }}</h5>
                                    <p class="text-muted small mb-0">{{ __('Add present and absent participants for this session.') }}</p>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-participant">
                                    <i class="fas fa-plus"></i> {{ __('Add Participant') }}
                                </button>
                            </div>

                            <div id="participants-container">
                                @php
                                    $oldParticipants = old('participants', [
                                        ['participant_name' => '', 'participant_number' => '', 'status' => 'present']
                                    ]);
                                @endphp

                                @foreach($oldParticipants as $index => $participant)
                                    <div class="row mb-2 participant-row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                   name="participants[{{ $index }}][participant_name]"
                                                   placeholder="{{ __('Participant Name') }}"
                                                   value="{{ $participant['participant_name'] ?? '' }}">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control"
                                                   name="participants[{{ $index }}][participant_number]"
                                                   placeholder="{{ __('Participant Number') }}"
                                                   value="{{ $participant['participant_number'] ?? '' }}">
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-control participant-status"
                                                    name="participants[{{ $index }}][status]">
                                                <option value="present" {{ (($participant['status'] ?? '') === 'present') ? 'selected' : '' }}>Present</option>
                                                <option value="absent" {{ (($participant['status'] ?? '') === 'absent') ? 'selected' : '' }}>Absent</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-participant w-100">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('talent-attendance.index') }}" class="btn btn-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Attendance') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let participantIndex = {{ old('participants') ? count(old('participants')) : 1 }};
    const container = document.getElementById('participants-container');
    const addButton = document.getElementById('add-participant');
    const attendanceCountInput = document.getElementById('attendance_count');

    function updateAttendanceCount() {
        const rows = container.querySelectorAll('.participant-row');
        let count = 0;

        rows.forEach(row => {
            const nameInput = row.querySelector('input[name*="[participant_name]"]');
            if (nameInput && nameInput.value.trim() !== '') {
                count++;
            }
        });

        attendanceCountInput.value = count;
    }

    addButton.addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'row mb-2 participant-row';
        row.innerHTML = `
            <div class="col-md-4">
                <input type="text" class="form-control"
                       name="participants[${participantIndex}][participant_name]"
                       placeholder="{{ __('Participant Name') }}">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control"
                       name="participants[${participantIndex}][participant_number]"
                       placeholder="{{ __('Participant Number') }}">
            </div>
            <div class="col-md-3">
                <select class="form-control participant-status"
                        name="participants[${participantIndex}][status]">
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-outline-danger remove-participant w-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        participantIndex++;
        updateAttendanceCount();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-participant') || (e.target.parentElement && e.target.parentElement.classList.contains('remove-participant'))) {
            const row = e.target.closest('.participant-row');
            if (row) {
                const rows = container.querySelectorAll('.participant-row');
                if (rows.length > 1) {
                    row.remove();
                    updateAttendanceCount();
                }
            }
        }
    });

    container.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.includes('[participant_name]')) {
            updateAttendanceCount();
        }
    });

    updateAttendanceCount();
});
</script>
@endsection