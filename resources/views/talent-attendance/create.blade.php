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
                            <x-attendance-checklist
                                field-name="participants"
                                :participants="old('participants', [['participant_name' => '', 'participant_number' => '', 'status' => 'present']])"
                                count-input-id="attendance_count"
                                count-input-mode="total"
                                title="Select Participants"
                                help-text="Tick waliopo na untick wasiokuwepo. Present na Absent zitahesabika zenyewe."
                                add-button-text="Add Participant"
                            />
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
@endsection
