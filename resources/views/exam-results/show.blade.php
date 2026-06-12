@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-data me-2"></i>
                        {{ $section['title'] }} Details
                    </h5>
                    <div>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $examResult->user_id)
                            <a href="{{ route($section['route'] . '.edit', $examResult) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route($section['route'] . '.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">STUDENT INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Student name:</strong>
                                    <p class="mb-0">{{ $examResult->student_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>School / institution name:</strong>
                                    <p class="mb-0">{{ $examResult->school_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Class / level:</strong>
                                    <p class="mb-0">{{ $examResult->class_level }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Exam year:</strong>
                                    <p class="mb-0">{{ $examResult->exam_year }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">RESULT INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Exam type:</strong>
                                    <p class="mb-0">{{ $examResult->exam_type }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ $section['uses_gpa'] ? 'GPA' : 'Overall performance' }}:</strong>
                                    <p class="mb-0">{{ $section['uses_gpa'] ? ($examResult->gpa ?: 'N/A') : ($examResult->performance ?: 'N/A') }}</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Best subjects:</strong>
                                <p class="mb-0">{{ $examResult->best_subjects ?: 'None provided' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Subjects with challenges:</strong>
                                <p class="mb-0">{{ $examResult->failed_subjects ?: 'None provided' }}</p>
                            </div>
                            <div class="mb-0">
                                <strong>Additional comments:</strong>
                                <p class="mb-0">{{ $examResult->comments ?: 'No comments' }}</p>
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
                                    <p class="mb-0">{{ $examResult->user->center_id ?? $examResult->user->email ?? $examResult->user->name ?? 'Legacy record' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Created at:</strong>
                                    <p class="mb-0">{{ $examResult->created_at?->format('d/m/Y H:i') }}</p>
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
