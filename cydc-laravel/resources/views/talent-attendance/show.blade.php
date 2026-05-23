@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Attendance Record Details') }}</h4>
                    <div>
                        <a href="{{ route('talent-attendance.edit', $attendance->id) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                        </a>
                        <a href="{{ route('talent-attendance.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Session Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-calendar-alt"></i> {{ __('Session Information') }}
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <strong>{{ __('Date') }}:</strong>
                            <p class="mb-0">{{ $attendance->date ? $attendance->date->format('F j, Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>{{ __('Instructor') }}:</strong>
                            <p class="mb-0">{{ $attendance->instructor_name }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>{{ __('Talent Taught') }}:</strong>
                            <p class="mb-0">{{ $attendance->talent_taught }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>{{ __('Attendance Count') }}:</strong>
                            <p class="mb-0">
                                <span class="badge bg-success fs-6">{{ $attendance->attendance_count }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <strong>{{ __('Lesson Topic') }}:</strong>
                            <p class="mb-0">{{ $attendance->lesson_topic }}</p>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-comments"></i> {{ __('Comments') }}
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <strong>{{ __('Instructor Comments') }}</strong>
                                </div>
                                <div class="card-body">
                                    @if($attendance->instructor_comments)
                                        <p class="mb-0">{{ $attendance->instructor_comments }}</p>
                                    @else
                                        <p class="text-muted mb-0">{{ __('No comments provided') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <strong>{{ __('Supervisor Comments') }}</strong>
                                </div>
                                <div class="card-body">
                                    @if($attendance->supervisor_comments)
                                        <p class="mb-0">{{ $attendance->supervisor_comments }}</p>
                                    @else
                                        <p class="text-muted mb-0">{{ __('No comments provided') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Absent Participants Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="text-warning border-bottom pb-2 mb-3">
                                <i class="fas fa-user-times"></i> {{ __('Absent Participants') }}
                                @if($attendance->absentParticipants->count() > 0)
                                    <span class="badge bg-warning text-dark ms-2">{{ $attendance->absentParticipants->count() }}</span>
                                @endif
                            </h5>
                        </div>
                    </div>

                    @if($attendance->absentParticipants->count() > 0)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('Participant Name') }}</th>
                                                <th>{{ __('Participant Number') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($attendance->absentParticipants as $index => $participant)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $participant->participant_name }}</td>
                                                    <td>{{ $participant->participant_number ?: __('N/A') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle"></i> {{ __('No absent participants recorded for this session.') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Record Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="text-secondary border-bottom pb-2 mb-3">
                                <i class="fas fa-info-circle"></i> {{ __('Record Information') }}
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>{{ __('Created By') }}:</strong>
                            <p class="mb-0">{{ $attendance->user->center_id ?? 'No Center ID' }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>{{ __('Created At') }}:</strong>
                            <p class="mb-0">{{ $attendance->created_at ? $attendance->created_at->format('F j, Y g:i A') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>{{ __('Last Updated') }}:</strong>
                            <p class="mb-0">{{ $attendance->updated_at ? $attendance->updated_at->format('F j, Y g:i A') : 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <a href="{{ route('talent-attendance.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('talent-attendance.edit', $attendance->id) }}" class="btn btn-warning me-2">
                                        <i class="fas fa-edit"></i> {{ __('Edit Record') }}
                                    </a>
                                    <form action="{{ route('talent-attendance.destroy', $attendance->id) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('{{ __('Are you sure you want to delete this attendance record?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection