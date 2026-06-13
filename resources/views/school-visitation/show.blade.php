@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-building-check me-2"></i>
                        School Visitation Details
                    </h5>
                    <div>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $schoolVisitation->user_id)
                            <a href="{{ route('school-visitation.edit', $schoolVisitation) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('school-visitation.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">PARTICIPANT INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Participant name:</strong>
                                    <p class="mb-0">{{ $schoolVisitation->participant_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Registration number:</strong>
                                    <p class="mb-0">{{ $schoolVisitation->registration_number }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>School name:</strong>
                                    <p class="mb-0">{{ $schoolVisitation->school_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Class level:</strong>
                                    <p class="mb-0">{{ $schoolVisitation->class_level }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Participant presence:</strong><br>
                                    <span class="badge bg-{{ $schoolVisitation->participant_presence === 'Present' ? 'success' : 'danger' }}">
                                        {{ $schoolVisitation->participant_presence }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">ACADEMIC AND DISCIPLINE INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Academic progress:</strong><br>
                                    <span class="badge bg-{{ $schoolVisitation->academic_progress === 'Satisfactory' ? 'success' : 'warning text-dark' }}">
                                        {{ $schoolVisitation->academic_progress }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Discipline status:</strong><br>
                                    <span class="badge bg-{{ $schoolVisitation->discipline_status === 'Good' ? 'success' : ($schoolVisitation->discipline_status === 'Poor' ? 'danger' : 'secondary') }}">
                                        {{ $schoolVisitation->discipline_status }}
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Academic challenges:</strong>
                                <p class="mb-0">{{ $schoolVisitation->academic_challenges ?: 'None provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Bad behaviors:</strong>
                                <p class="mb-0">{{ $schoolVisitation->bad_behaviors ?: 'None provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Cleanliness status:</strong>
                                <p class="mb-0">{{ $schoolVisitation->cleanliness_status }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">COMMENTS</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Teacher comments:</strong>
                                <p class="mb-0">{{ $schoolVisitation->teacher_comments ?: 'No comments' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Visitor comments:</strong>
                                <p class="mb-0">{{ $schoolVisitation->visitor_comments ?: 'No comments' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">USER INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Submitted by:</strong>
                                    <p class="mb-0"><x-user-identity :user="$schoolVisitation->user" :show-email="true" /></p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Created at:</strong>
                                    <p class="mb-0">{{ $schoolVisitation->created_at?->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('school-visitation.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back to List
                        </a>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $schoolVisitation->user_id)
                            <div>
                                <a href="{{ route('school-visitation.edit', $schoolVisitation) }}" class="btn btn-warning me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('school-visitation.destroy', $schoolVisitation) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="bi bi-trash"></i> Delete
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
