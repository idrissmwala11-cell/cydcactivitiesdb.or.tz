@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                    <div>
                        <h4 class="mb-0 fw-bold text-dark">{{ __('Talent Attendance Records') }}</h4>
                        <small class="text-muted">{{ __('Manage and review all submitted talent attendance sessions.') }}</small>
                    </div>

                    <a href="{{ route('talent-attendance.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus me-1"></i> {{ __('Add Attendance Record') }}
                    </a>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($attendances->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="py-3">{{ __('Date') }}</th>
                                        <th class="py-3">{{ __('Instructor') }}</th>
                                        <th class="py-3">{{ __('Talent Taught') }}</th>
                                        <th class="py-3">{{ __('Lesson Topic') }}</th>
                                        <th class="py-3 text-center">{{ __('Total') }}</th>
                                        <th class="py-3 text-center">{{ __('Present') }}</th>
                                        <th class="py-3 text-center">{{ __('Absent') }}</th>
                                        <th class="py-3">{{ __('Submitted By') }}</th>
                                        <th class="py-3 text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr class="border-bottom" style="transition: all 0.2s ease;">
                                            <td>
                                                <span class="badge rounded-pill bg-info-subtle text-dark border px-3 py-2 fw-semibold">
                                                    {{ $attendance->date ? $attendance->date->format('M d, Y') : 'N/A' }}
                                                </span>
                                            </td>

                                            <td class="fw-semibold text-dark">
                                                {{ $attendance->instructor_name }}
                                            </td>

                                            <td>
                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    {{ $attendance->talent_taught }}
                                                </span>
                                            </td>

                                            <td class="text-dark">
                                                {{ \Illuminate\Support\Str::limit($attendance->lesson_topic, 35) }}
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                                                    {{ $attendance->attendance_count }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                                                    {{ $attendance->present_count }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">
                                                    {{ $attendance->absent_count }}
                                                </span>
                                            </td>

                                            <td class="fw-semibold text-dark"><x-user-identity :user="$attendance->user" :show-email="true" /></td>

                                            <td class="text-center">
                                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                                    <a href="{{ route('talent-attendance.show', $attendance->id) }}"
                                                       class="btn btn-sm btn-info text-white fw-semibold px-3 rounded-pill shadow-sm"
                                                       title="View">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>

                                                    @if(auth()->user()->role === 'admin' || auth()->id() === (int) $attendance->user_id)
                                                        <a href="{{ route('talent-attendance.edit', $attendance->id) }}"
                                                           class="btn btn-sm btn-warning text-dark fw-semibold px-3 rounded-pill shadow-sm"
                                                           title="Edit">
                                                            <i class="fas fa-edit me-1"></i> Edit
                                                        </a>

                                                        <form action="{{ route('talent-attendance.destroy', $attendance->id) }}"
                                                              method="POST"
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-danger text-white fw-semibold px-3 rounded-pill shadow-sm"
                                                                    title="Delete">
                                                                <i class="fas fa-trash me-1"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-check fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted fw-bold">{{ __('No attendance records found') }}</h5>
                            <p class="text-muted">{{ __('Start by adding your first attendance record.') }}</p>
                            <a href="{{ route('talent-attendance.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="fas fa-plus me-1"></i> {{ __('Add Attendance Record') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
</style>
@endsection
