@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Header with Actions -->
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="h2 fw-bold text-dark">{{ $vocationalTraining->program_name }}</h1>
                            <div class="d-flex align-items-center mt-2">
                                <span class="badge me-3
                                    @if($vocationalTraining->status === 'active') bg-success
                                    @elseif($vocationalTraining->status === 'completed') bg-primary
                                    @elseif($vocationalTraining->status === 'planning') bg-warning
                                    @elseif($vocationalTraining->status === 'suspended') bg-secondary
                                    @else bg-danger @endif">
                                    {{ ucfirst($vocationalTraining->status) }}
                                </span>
                                <span class="text-muted me-3">
                                    {{ ucfirst($vocationalTraining->training_type) }} Training
                                </span>
                                @if($vocationalTraining->certification_provided)
                                    <span class="badge bg-info">
                                        <i class="fas fa-certificate me-1"></i>
                                        Certificate
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('vocational-training.edit', $vocationalTraining) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>
                                Edit
                            </a>
                            <form action="{{ route('vocational-training.destroy', $vocationalTraining) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this training program? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Program Overview Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-primary bg-opacity-25 rounded">
                                            <i class="fas fa-users text-primary fa-lg"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-primary fw-medium mb-1">Participants</p>
                                            <h4 class="text-primary fw-bold mb-0">
                                                {{ $vocationalTraining->current_participants ?? 0 }}
                                                @if($vocationalTraining->max_participants)
                                                    <small class="fw-normal">/ {{ $vocationalTraining->max_participants }}</small>
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-success bg-opacity-25 rounded">
                                            <i class="fas fa-clock text-success fa-lg"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-success fw-medium mb-1">Duration</p>
                                            <h4 class="text-success fw-bold mb-0">
                                                {{ $vocationalTraining->duration_weeks ?? 'N/A' }}
                                                @if($vocationalTraining->duration_weeks)
                                                    <small class="fw-normal">weeks</small>
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-info bg-opacity-10 border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-info bg-opacity-25 rounded">
                                            <i class="fas fa-money-bill text-info fa-lg"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-info fw-medium mb-1">Training Fee</p>
                                            <h4 class="text-info fw-bold mb-0">
                                                @if($vocationalTraining->training_fee)
                                                    TSH {{ number_format($vocationalTraining->training_fee) }}
                                                @else
                                                    Free
                                                @endif
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning bg-opacity-10 border-warning">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-warning bg-opacity-25 rounded">
                                            <i class="fas fa-map-marker-alt text-warning fa-lg"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="text-warning fw-medium mb-1">Location</p>
                                            <h5 class="text-warning fw-bold mb-0">{{ $vocationalTraining->location }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-6">
                            <!-- Program Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">Program Information</h5>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium text-muted">Program Name</label>
                                        <p class="text-dark mb-0">{{ $vocationalTraining->program_name }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-medium text-muted">Training Type</label>
                                        <p class="text-dark mb-0">{{ ucfirst($vocationalTraining->training_type) }}</p>
                                    </div>
                                    @if($vocationalTraining->description)
                                        <div class="mb-0">
                                            <label class="form-label fw-medium text-muted">Description</label>
                                            <p class="text-dark mb-0" style="white-space: pre-wrap;">{{ $vocationalTraining->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Schedule Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">Schedule Information</h5>
                                    <div class="row">
                                        @if($vocationalTraining->start_date)
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label fw-medium text-muted">Start Date</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->start_date->format('F j, Y') }}</p>
                                                <small class="text-muted">{{ $vocationalTraining->start_date->diffForHumans() }}</small>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->end_date)
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label fw-medium text-muted">End Date</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->end_date->format('F j, Y') }}</p>
                                                <small class="text-muted">{{ $vocationalTraining->end_date->diffForHumans() }}</small>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->duration_weeks)
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label fw-medium text-muted">Duration</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->duration_weeks }} weeks</p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->hours_per_week)
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label fw-medium text-muted">Hours per Week</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->hours_per_week }} hours</p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->schedule_days)
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-medium text-muted">Training Days</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->schedule_days }}</p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->schedule_time)
                                            <div class="col-12 mb-0">
                                                <label class="form-label fw-medium text-muted">Training Time</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->schedule_time }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Instructor Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Instructor Information
                                    </h5>
                                    @if($vocationalTraining->instructor_name)
                                        <div class="mb-3">
                                            <label class="form-label fw-medium text-muted">Instructor Name</label>
                                            <p class="text-dark mb-0">{{ $vocationalTraining->instructor_name }}</p>
                                        </div>
                                    @endif
                                    <div class="row">
                                        @if($vocationalTraining->instructor_phone)
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label fw-medium text-muted">Phone</label>
                                                <p class="text-dark mb-0">
                                                    <a href="tel:{{ $vocationalTraining->instructor_phone }}" class="text-primary text-decoration-none">
                                                        <i class="fas fa-phone me-1"></i>{{ $vocationalTraining->instructor_phone }}
                                                    </a>
                                                </p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->instructor_email)
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label fw-medium text-muted">Email</label>
                                                <p class="text-dark mb-0">
                                                    <a href="mailto:{{ $vocationalTraining->instructor_email }}" class="text-primary text-decoration-none">
                                                        <i class="fas fa-envelope me-1"></i>{{ $vocationalTraining->instructor_email }}
                                                    </a>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    @if($vocationalTraining->instructor_qualification)
                                        <div class="mb-0">
                                            <label class="form-label fw-medium text-muted">Qualification</label>
                                            <p class="text-dark mb-0">{{ $vocationalTraining->instructor_qualification }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-6">
                            <!-- Participants Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">
                                        <i class="fas fa-users me-2"></i>Participants Information
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="form-label fw-medium text-muted">Enrollment Progress</span>
                                                <span class="text-muted">{{ $vocationalTraining->current_participants ?? 0 }}/{{ $vocationalTraining->max_participants ?? 0 }}</span>
                                            </div>
                                            @if($vocationalTraining->max_participants)
                                                @php
                                                    $maxParticipants = $vocationalTraining->max_participants;
                                                    $currentParticipants = $vocationalTraining->current_participants ?? 0;
                                                    $percentage = ($currentParticipants / $maxParticipants) * 100;
                                                @endphp
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min($percentage, 100) }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <p class="text-muted small mt-1">
                                                    {{ number_format(min(100, $percentage), 1) }}% capacity
                                                </p>
                                            @endif
                                        </div>
                                        @if($vocationalTraining->max_participants)
                                            <div class="col-sm-6">
                                                <label class="form-label fw-medium text-muted">Maximum Participants</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->max_participants }}</p>
                                            </div>
                                        @endif
                                        <div class="col-sm-6">
                                            <label class="form-label fw-medium text-muted">Current Participants</label>
                                            <p class="text-dark mb-0">{{ $vocationalTraining->current_participants ?? 0 }}</p>
                                        </div>
                                        @if($vocationalTraining->target_audience)
                                            <div class="col-12">
                                                <label class="form-label fw-medium text-muted">Target Audience</label>
                                                <p class="text-dark mb-0" style="white-space: pre-wrap;">{{ $vocationalTraining->target_audience }}</p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->prerequisites)
                                            <div class="col-12">
                                                <label class="form-label fw-medium text-muted">Prerequisites</label>
                                                <p class="text-dark mb-0" style="white-space: pre-wrap;">{{ $vocationalTraining->prerequisites }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">
                                        <i class="fas fa-map-marker-alt me-2"></i>Location Information
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted">Training Venue</label>
                                            <p class="text-dark mb-0">{{ $vocationalTraining->location }}</p>
                                        </div>
                                        @if($vocationalTraining->ward)
                                            <div class="col-sm-6">
                                                <label class="form-label fw-medium text-muted">Ward</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->ward }}</p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->district)
                                            <div class="col-sm-6">
                                                <label class="form-label fw-medium text-muted">District</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->district }}</p>
                                            </div>
                                        @endif
                                        @if($vocationalTraining->region)
                                            <div class="col-12">
                                                <label class="form-label fw-medium text-muted">Region</label>
                                                <p class="text-dark mb-0">{{ $vocationalTraining->region }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Program Management -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">
                                        <i class="fas fa-cogs me-2"></i>Program Management
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label fw-medium text-muted">Training Fee</label>
                                            <p class="text-dark mb-0">
                                                @if($vocationalTraining->training_fee)
                                                    TSH {{ number_format($vocationalTraining->training_fee) }}
                                                @else
                                                    Free
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label fw-medium text-muted">Materials Cost</label>
                                            <p class="text-dark mb-0">
                                                @if($vocationalTraining->materials_cost)
                                                    TSH {{ number_format($vocationalTraining->materials_cost) }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label fw-medium text-muted">Status</label>
                                            <div>
                                                <span class="badge
                                                    @if($vocationalTraining->status === 'active') bg-success
                                                    @elseif($vocationalTraining->status === 'completed') bg-primary
                                                    @elseif($vocationalTraining->status === 'planning') bg-warning
                                                    @elseif($vocationalTraining->status === 'suspended') bg-secondary
                                                    @else bg-danger @endif">
                                                    {{ ucfirst($vocationalTraining->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label fw-medium text-muted">Certification</label>
                                            <p class="text-dark mb-0">
                                                @if($vocationalTraining->certification_provided)
                                                    <span class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Certificate Provided
                                                    </span>
                                                @else
                                                    <span class="text-muted">No Certificate</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($vocationalTraining->learning_objectives || $vocationalTraining->notes)
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Additional Information
                                </h5>
                                <div class="row g-3">
                                    @if($vocationalTraining->learning_objectives)
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted mb-2">Learning Objectives</label>
                                            <div class="bg-light p-3 rounded">
                                                <p class="text-dark mb-0" style="white-space: pre-wrap;">{{ $vocationalTraining->learning_objectives }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($vocationalTraining->notes)
                                        <div class="col-12">
                                            <label class="form-label fw-medium text-muted mb-2">Notes & Comments</label>
                                            <div class="bg-light p-3 rounded">
                                                <p class="text-dark mb-0" style="white-space: pre-wrap;">{{ $vocationalTraining->notes }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Record Information -->
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-dark mb-3">
                                <i class="fas fa-clock me-2"></i>Record Information
                            </h5>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label class="form-label fw-medium text-muted mb-1">Created At</label>
                                    <p class="text-dark mb-0">{{ $vocationalTraining->created_at->format('F j, Y g:i A') }}</p>
                                    <small class="text-muted">{{ $vocationalTraining->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label fw-medium text-muted mb-1">Last Updated</label>
                                    <p class="text-dark mb-0">{{ $vocationalTraining->updated_at->format('F j, Y g:i A') }}</p>
                                    <small class="text-muted">{{ $vocationalTraining->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between align-items-center pt-3 mt-4 border-top">
                        <a href="{{ route('vocational-training.index') }}" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Training Programs
                        </a>

                        <div class="d-flex gap-2">
                            <a href="{{ route('vocational-training.edit', $vocationalTraining) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>
                                Edit Program
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection