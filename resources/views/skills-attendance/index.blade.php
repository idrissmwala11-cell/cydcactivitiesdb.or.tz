@extends('layouts.app')
@section('title', 'Skills Attendance')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h3 class="mb-1 fw-bold text-dark">
                        <i class="bi bi-calendar2-check text-success me-2"></i>
                        Skills Attendance Records
                    </h3>
                    <p class="text-muted mb-0">Track class attendance, teachers, and submitted records clearly.</p>
                </div>

                <x-module-report-actions module="skills_attendance">
                    <a href="{{ route('skills-attendance.create') }}" class="btn btn-primary px-4">
                        <i class="bi bi-plus-circle me-1"></i>Add New Record
                    </a>
                </x-module-report-actions>
            </div>
        </div>

        <div class="card-body px-4 pb-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Total Records</div>
                            <div class="h4 mb-0 fw-bold">{{ number_format($attendances->total()) }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Visible On This Page</div>
                            <div class="h4 mb-0 fw-bold">{{ number_format($attendances->count()) }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-info bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Unique Teachers On This Page</div>
                            <div class="h4 mb-0 fw-bold">{{ number_format($attendances->pluck('teacher_name')->filter()->unique()->count()) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Teacher</th>
                            <th>Lesson Topic</th>
                            <th>Present Count</th>
                            <th>Absent Count</th>
                            <th>Submitted By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            @php
                                $submittedBy = $attendance->user->center_id
                                    ?? $attendance->user->email
                                    ?? $attendance->user->name
                                    ?? null;
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $attendance->date ? $attendance->date->format('M d, Y') : 'N/A' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark">{{ $attendance->teacher_name }}</div>
                                </td>

                                <td style="min-width: 240px;">
                                    <div class="text-dark fw-medium">{{ $attendance->lesson_topic }}</div>
                                    @if(!empty($attendance->lesson_topic_details))
                                        <small class="text-muted">{{ \Illuminate\Support\Str::limit($attendance->lesson_topic_details, 70) }}</small>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        {{ $attendance->present_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                        {{ $attendance->absent_count }}
                                    </span>
                                </td>

                                <td>
                                    @if($submittedBy)
                                        <x-user-identity :user="$attendance->user" :show-email="true" />
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Legacy record</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('skills-attendance.show', $attendance->id) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $attendance->user_id)
                                            <a href="{{ route('skills-attendance.edit', $attendance->id) }}" class="btn btn-sm btn-outline-warning">
                                                Edit
                                            </a>

                                            <form action="{{ route('skills-attendance.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    No skills attendance records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
