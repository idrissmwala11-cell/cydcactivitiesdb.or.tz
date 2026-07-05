@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                    <h4 class="mb-0 fw-bold">{{ __('Edit Attendance Record') }}</h4>
                    <a href="{{ route('talent-attendance.show', $attendance->id) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Details') }}
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('talent-attendance.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="date" class="form-label">{{ __('Date') }} <span class="text-danger">*</span></label>
                                <input type="date"
                                       class="form-control @error('date') is-invalid @enderror"
                                       id="date"
                                       name="date"
                                       value="{{ old('date', $attendance->date ? $attendance->date->format('Y-m-d') : '') }}"
                                       required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="instructor_name" class="form-label">{{ __('Instructor Name') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('instructor_name') is-invalid @enderror"
                                       id="instructor_name"
                                       name="instructor_name"
                                       value="{{ old('instructor_name', $attendance->instructor_name) }}"
                                       required>
                                @error('instructor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="attendance_count" class="form-label">{{ __('Attendance Count') }}</label>
                                <input type="number"
                                       class="form-control bg-light"
                                       id="attendance_count"
                                       name="attendance_count"
                                       value="{{ old('attendance_count', $attendance->attendance_count) }}"
                                       min="0"
                                       readonly>
                                <small class="text-muted">{{ __('Calculated automatically from participants below.') }}</small>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="talent_taught" class="form-label">{{ __('Talent Taught') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('talent_taught') is-invalid @enderror"
                                       id="talent_taught"
                                       name="talent_taught"
                                       value="{{ old('talent_taught', $attendance->talent_taught) }}"
                                       required>
                                @error('talent_taught')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="lesson_topic" class="form-label">{{ __('Lesson Topic') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('lesson_topic') is-invalid @enderror"
                                       id="lesson_topic"
                                       name="lesson_topic"
                                       value="{{ old('lesson_topic', $attendance->lesson_topic) }}"
                                       required>
                                @error('lesson_topic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="instructor_comments" class="form-label">{{ __('Instructor Comments') }}</label>
                                <textarea class="form-control @error('instructor_comments') is-invalid @enderror"
                                          id="instructor_comments"
                                          name="instructor_comments"
                                          rows="3">{{ old('instructor_comments', $attendance->instructor_comments) }}</textarea>
                                @error('instructor_comments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="supervisor_comments" class="form-label">{{ __('Supervisor Comments') }}</label>
                                <textarea class="form-control @error('supervisor_comments') is-invalid @enderror"
                                          id="supervisor_comments"
                                          name="supervisor_comments"
                                          rows="3">{{ old('supervisor_comments', $attendance->supervisor_comments) }}</textarea>
                                @error('supervisor_comments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            @php
                                $existingParticipants = old('participants', $attendance->absentParticipants->map(function ($participant) {
                                    return [
                                        'participant_name' => $participant->participant_name,
                                        'participant_number' => $participant->participant_number,
                                        'status' => $participant->status ?? 'absent',
                                    ];
                                })->toArray());

                                if (empty($existingParticipants)) {
                                    $existingParticipants = [
                                        ['participant_name' => '', 'participant_number' => '', 'status' => 'present']
                                    ];
                                }
                            @endphp

                            <x-attendance-checklist
                                field-name="participants"
                                :participants="$existingParticipants"
                                count-input-id="attendance_count"
                                count-input-mode="total"
                                title="Select Participants"
                                help-text="Tick waliopo na untick wasiokuwepo. Present na Absent zitahesabika zenyewe."
                                add-button-text="Add Participant"
                            />
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('talent-attendance.show', $attendance->id) }}" class="btn btn-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> {{ __('Update Attendance') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
