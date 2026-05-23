@extends('layouts.app')

@section('content')
@php
    $presentParticipants = $attendance->absentParticipants->where('status', 'present');
    $absentParticipants = $attendance->absentParticipants->where('status', 'absent');
@endphp

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                    <h4 class="mb-0 fw-bold text-dark">{{ __('Talent Attendance Details') }}</h4>
                    <div>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $attendance->user_id)
                            <a href="{{ route('talent-attendance.edit', $attendance->id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                            </a>
                        @endif
                        <a href="{{ route('talent-attendance.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">

                    {{-- Top Summary --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 bg-light h-100">
                                <h5 class="fw-bold text-dark mb-3">{{ __('Basic Information') }}</h5>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('Date') }}</small>
                                    <div class="fw-semibold">{{ $attendance->date ? $attendance->date->format('d-m-Y') : 'N/A' }}</div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('Instructor Name') }}</small>
                                    <div class="fw-semibold">{{ $attendance->instructor_name ?? 'N/A' }}</div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('Talent Taught') }}</small>
                                    <div class="fw-semibold">{{ $attendance->talent_taught ?? 'N/A' }}</div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('Lesson Topic') }}</small>
                                    <div class="fw-semibold">{{ $attendance->lesson_topic ?? 'N/A' }}</div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted d-block">{{ __('Created By') }}</small>
                                    <div class="fw-semibold">
                                        {{ $attendance->user?->center_id ?? $attendance->user?->name ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 bg-light h-100 text-center">
                                <h5 class="fw-bold text-dark mb-4">{{ __('Summary') }}</h5>

                                <div class="row g-3 mb-4">
                                    <div class="col-4">
                                        <div class="bg-white rounded-4 shadow-sm p-3 border">
                                            <div class="fs-3 fw-bold text-primary">{{ $attendance->attendance_count ?? 0 }}</div>
                                            <div class="small text-muted">{{ __('Total') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-white rounded-4 shadow-sm p-3 border">
                                            <div class="fs-3 fw-bold text-success">{{ $presentParticipants->count() }}</div>
                                            <div class="small text-muted">{{ __('Present') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="bg-white rounded-4 shadow-sm p-3 border">
                                            <div class="fs-3 fw-bold text-danger">{{ $absentParticipants->count() }}</div>
                                            <div class="small text-muted">{{ __('Absent') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <span class="badge bg-success-subtle text-success border px-3 py-2 rounded-pill">
                                                {{ $presentParticipants->count() }} {{ __('present participants') }}
                                            </span>
                                        </div>
                                        <div class="col-6">
                                            <span class="badge bg-danger-subtle text-danger border px-3 py-2 rounded-pill">
                                                {{ $absentParticipants->count() }} {{ __('absent participants') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Comments --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">{{ __('Comments') }}</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="rounded-4 border border-primary-subtle bg-primary-subtle p-4 h-100">
                                    <h6 class="fw-bold mb-3">{{ __('Instructor Comments') }}</h6>
                                    <p class="mb-0 text-dark">
                                        {{ $attendance->instructor_comments ?: __('No comments provided') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="rounded-4 border border-warning-subtle bg-warning-subtle p-4 h-100">
                                    <h6 class="fw-bold mb-3">{{ __('Supervisor Comments') }}</h6>
                                    <p class="mb-0 text-dark">
                                        {{ $attendance->supervisor_comments ?: __('No comments provided') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Participants --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">{{ __('Participants') }}</h5>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="rounded-4 border border-success-subtle bg-success-subtle p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-success mb-0">✔ {{ __('Present Participants') }}</h6>
                                        <span class="badge bg-success rounded-pill">{{ $presentParticipants->count() }}</span>
                                    </div>

                                    @if($presentParticipants->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover align-middle mb-0 bg-white rounded overflow-hidden">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>{{ __('Name') }}</th>
                                                        <th class="text-center">{{ __('Number') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($presentParticipants as $participant)
                                                        <tr>
                                                            <td>{{ $participant->participant_name ?? 'N/A' }}</td>
                                                            <td class="text-center">{{ $participant->participant_number ?: 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-light border mb-0">
                                            {{ __('No present participants recorded.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="rounded-4 border border-danger-subtle bg-danger-subtle p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-danger mb-0">✖ {{ __('Absent Participants') }}</h6>
                                        <span class="badge bg-danger rounded-pill">{{ $absentParticipants->count() }}</span>
                                    </div>

                                    @if($absentParticipants->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover align-middle mb-0 bg-white rounded overflow-hidden">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>{{ __('Name') }}</th>
                                                        <th class="text-center">{{ __('Number') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($absentParticipants as $participant)
                                                        <tr>
                                                            <td>{{ $participant->participant_name ?? 'N/A' }}</td>
                                                            <td class="text-center">{{ $participant->participant_number ?: 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-light border mb-0">
                                            {{ __('No absent participants recorded.') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Record Information --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">{{ __('Record Information') }}</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded-4 p-3 bg-light h-100">
                                    <small class="text-muted d-block">{{ __('Created By') }}</small>
                                    <div class="fw-semibold">
                                        {{ $attendance->user?->center_id ?? $attendance->user?->name ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-3 bg-light h-100">
                                    <small class="text-muted d-block">{{ __('Created At') }}</small>
                                    <div class="fw-semibold">
                                        {{ $attendance->created_at ? $attendance->created_at->format('F j, Y g:i A') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-4 p-3 bg-light h-100">
                                    <small class="text-muted d-block">{{ __('Last Updated') }}</small>
                                    <div class="fw-semibold">
                                        {{ $attendance->updated_at ? $attendance->updated_at->format('F j, Y g:i A') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('talent-attendance.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to List') }}
                        </a>

                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $attendance->user_id)
                            <div>
                                <a href="{{ route('talent-attendance.edit', $attendance->id) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-1"></i> {{ __('Edit Record') }}
                                </a>
                                <form action="{{ route('talent-attendance.destroy', $attendance->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('{{ __('Are you sure you want to delete this attendance record?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection