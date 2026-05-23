@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Talent Attendance Records') }}</h4>
                    <a href="{{ route('talent-attendance.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Add Attendance Record') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($attendances->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Instructor') }}</th>
                                        <th>{{ __('Talent Taught') }}</th>
                                        <th>{{ __('Lesson Topic') }}</th>
                                        <th>{{ __('Attendance Count') }}</th>
                                        <th>{{ __('Absent Participants') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $attendance->date->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>{{ $attendance->instructor_name }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $attendance->talent_taught }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($attendance->lesson_topic, 30) }}</td>
                                            <td>
                                                <span class="badge bg-primary fs-6">
                                                    {{ $attendance->attendance_count }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($attendance->absentParticipants->count() > 0)
                                                    <span class="badge bg-warning">
                                                        {{ $attendance->absentParticipants->count() }} {{ __('absent') }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">{{ __('All present') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('talent-attendance.show', $attendance) }}" class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('talent-attendance.edit', $attendance) }}" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('talent-attendance.destroy', $attendance) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-check fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('No attendance records found') }}</h5>
                            <p class="text-muted">{{ __('Start by adding your first attendance record.') }}</p>
                            <a href="{{ route('talent-attendance.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add Attendance Record') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection