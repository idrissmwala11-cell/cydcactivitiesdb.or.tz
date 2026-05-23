@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Edit Vocational Training Program
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="alert-heading mb-2">
                                        <i class="bi bi-x-circle me-1"></i>There were {{ $errors->count() }} error(s) with your submission
                                    </h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vocational-training.update', $vocationalTraining) }}">
                        @csrf
                        @method('PUT')

                        <!-- Program Information -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Program Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="program_name" class="form-label fw-medium text-muted">
                                            <i class="bi bi-bookmark me-1"></i>Program Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="program_name" 
                                               id="program_name" 
                                               value="{{ old('program_name', $vocationalTraining->program_name) }}"
                                               required
                                               class="form-control"
                                               placeholder="e.g., Computer Basics Training">
                                        @error('program_name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="training_type" class="form-label fw-medium text-muted">
                                            <i class="bi bi-gear me-1"></i>Training Type <span class="text-danger">*</span>
                                        </label>
                                        <select name="training_type" 
                                                id="training_type" 
                                                required
                                                class="form-select">
                                            <option value="">Select Training Type</option>
                                            <option value="technical" {{ old('training_type', $vocationalTraining->training_type) == 'technical' ? 'selected' : '' }}>Technical</option>
                                            <option value="business" {{ old('training_type', $vocationalTraining->training_type) == 'business' ? 'selected' : '' }}>Business</option>
                                            <option value="agriculture" {{ old('training_type', $vocationalTraining->training_type) == 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                                            <option value="handicraft" {{ old('training_type', $vocationalTraining->training_type) == 'handicraft' ? 'selected' : '' }}>Handicraft</option>
                                            <option value="computer" {{ old('training_type', $vocationalTraining->training_type) == 'computer' ? 'selected' : '' }}>Computer</option>
                                            <option value="other" {{ old('training_type', $vocationalTraining->training_type) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('training_type')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="description" class="form-label fw-medium text-muted">
                                            <i class="bi bi-file-text me-1"></i>Program Description
                                        </label>
                                        <textarea name="description" 
                                                  id="description" 
                                                  rows="4"
                                                  class="form-control"
                                                  placeholder="Describe the training program objectives, content, and expected outcomes...">{{ old('description', $vocationalTraining->description) }}</textarea>
                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-calendar-event me-2"></i>Schedule Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label fw-medium text-muted">
                                            <i class="bi bi-calendar-plus me-1"></i>Start Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" 
                                               name="start_date" 
                                               id="start_date" 
                                               value="{{ old('start_date', $vocationalTraining->start_date?->format('Y-m-d')) }}"
                                               required
                                               class="form-control">
                                        @error('start_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label fw-medium text-muted">
                                            <i class="bi bi-calendar-check me-1"></i>End Date
                                        </label>
                                        <input type="date" 
                                               name="end_date" 
                                               id="end_date" 
                                               value="{{ old('end_date', $vocationalTraining->end_date?->format('Y-m-d')) }}"
                                               class="form-control">
                                        @error('end_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="duration_weeks" class="form-label fw-medium text-muted">
                                            <i class="bi bi-clock me-1"></i>Duration (Weeks)
                                        </label>
                                        <input type="number" 
                                               name="duration_weeks" 
                                               id="duration_weeks" 
                                               value="{{ old('duration_weeks', $vocationalTraining->duration_weeks) }}"
                                               min="1"
                                               class="form-control"
                                               placeholder="e.g., 12">
                                        @error('duration_weeks')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="hours_per_week" class="form-label fw-medium text-muted">
                                            <i class="bi bi-hourglass-split me-1"></i>Hours per Week
                                        </label>
                                        <input type="number" 
                                               name="hours_per_week" 
                                               id="hours_per_week" 
                                               value="{{ old('hours_per_week', $vocationalTraining->hours_per_week) }}"
                                               min="1"
                                               step="0.5"
                                               class="form-control"
                                               placeholder="e.g., 20">
                                        @error('hours_per_week')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="schedule_days" class="form-label fw-medium text-muted">
                                            <i class="bi bi-calendar-week me-1"></i>Training Days
                                        </label>
                                        <input type="text" 
                                               name="schedule_days" 
                                               id="schedule_days" 
                                               value="{{ old('schedule_days', $vocationalTraining->schedule_days) }}"
                                               class="form-control"
                                               placeholder="e.g., Monday, Wednesday, Friday">
                                        @error('schedule_days')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="schedule_time" class="form-label fw-medium text-muted">
                                            <i class="bi bi-clock-history me-1"></i>Training Time
                                        </label>
                                        <input type="text" 
                                               name="schedule_time" 
                                               id="schedule_time" 
                                               value="{{ old('schedule_time', $vocationalTraining->schedule_time) }}"
                                               class="form-control"
                                               placeholder="e.g., 9:00 AM - 12:00 PM">
                                        @error('schedule_time')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <!-- Instructor Information -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-person-badge me-2"></i>Instructor Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="instructor_name" class="form-label fw-medium text-muted">
                                            <i class="bi bi-person me-1"></i>Instructor Name
                                        </label>
                                        <input type="text" 
                                               name="instructor_name" 
                                               id="instructor_name" 
                                               value="{{ old('instructor_name', $vocationalTraining->instructor_name) }}"
                                               class="form-control"
                                               placeholder="Full name of the instructor">
                                        @error('instructor_name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="instructor_phone" class="form-label fw-medium text-muted">
                                            <i class="bi bi-telephone me-1"></i>Instructor Phone
                                        </label>
                                        <input type="tel" 
                                               name="instructor_phone" 
                                               id="instructor_phone" 
                                               value="{{ old('instructor_phone', $vocationalTraining->instructor_phone) }}"
                                               class="form-control"
                                               placeholder="e.g., +255 123 456 789">
                                        @error('instructor_phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="instructor_email" class="form-label fw-medium text-muted">
                                            <i class="bi bi-envelope me-1"></i>Instructor Email
                                        </label>
                                        <input type="email" 
                                               name="instructor_email" 
                                               id="instructor_email" 
                                               value="{{ old('instructor_email', $vocationalTraining->instructor_email) }}"
                                               class="form-control"
                                               placeholder="instructor@example.com">
                                        @error('instructor_email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="instructor_qualification" class="form-label fw-medium text-muted">
                                            <i class="bi bi-award me-1"></i>Instructor Qualification
                                        </label>
                                        <input type="text" 
                                               name="instructor_qualification" 
                                               id="instructor_qualification" 
                                               value="{{ old('instructor_qualification', $vocationalTraining->instructor_qualification) }}"
                                               class="form-control"
                                               placeholder="e.g., Certified Computer Trainer">
                                        @error('instructor_qualification')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <!-- Participants Information -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-people me-2"></i>Participants Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="max_participants" class="form-label fw-medium text-muted">
                                            <i class="bi bi-person-plus me-1"></i>Maximum Participants
                                        </label>
                                        <input type="number" 
                                               name="max_participants" 
                                               id="max_participants" 
                                               value="{{ old('max_participants', $vocationalTraining->max_participants) }}"
                                               min="1"
                                               class="form-control"
                                               placeholder="e.g., 25">
                                        @error('max_participants')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="current_participants" class="form-label fw-medium text-muted">
                                            <i class="bi bi-person-check me-1"></i>Current Participants
                                        </label>
                                        <input type="number" 
                                               name="current_participants" 
                                               id="current_participants" 
                                               value="{{ old('current_participants', $vocationalTraining->current_participants) }}"
                                               min="0"
                                               class="form-control"
                                               placeholder="e.g., 15">
                                        @error('current_participants')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="target_audience" class="form-label fw-medium text-muted">
                                            <i class="bi bi-bullseye me-1"></i>Target Audience
                                        </label>
                                        <textarea name="target_audience" 
                                                  id="target_audience" 
                                                  rows="3"
                                                  class="form-control"
                                                  placeholder="Describe the target audience for this training program...">{{ old('target_audience', $vocationalTraining->target_audience) }}</textarea>
                                        @error('target_audience')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="prerequisites" class="form-label fw-medium text-muted">
                                            <i class="bi bi-list-check me-1"></i>Prerequisites
                                        </label>
                                        <textarea name="prerequisites" 
                                                  id="prerequisites" 
                                                  rows="3"
                                                  class="form-control"
                                                  placeholder="List any prerequisites or requirements for participants...">{{ old('prerequisites', $vocationalTraining->prerequisites) }}</textarea>
                                        @error('prerequisites')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <!-- Location Details -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>Location Details
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="location" class="form-label fw-medium text-muted">
                                            <i class="bi bi-building me-1"></i>Training Venue <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="location" 
                                               id="location" 
                                               value="{{ old('location', $vocationalTraining->location) }}"
                                               required
                                               class="form-control"
                                               placeholder="e.g., Community Center, School Hall">
                                        @error('location')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="ward" class="form-label fw-medium text-muted">
                                            <i class="bi bi-map me-1"></i>Ward
                                        </label>
                                        <input type="text" 
                                               name="ward" 
                                               id="ward" 
                                               value="{{ old('ward', $vocationalTraining->ward) }}"
                                               class="form-control"
                                               placeholder="Ward name">
                                        @error('ward')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="district" class="form-label fw-medium text-muted">
                                            <i class="bi bi-geo me-1"></i>District
                                        </label>
                                        <input type="text" 
                                               name="district" 
                                               id="district" 
                                               value="{{ old('district', $vocationalTraining->district) }}"
                                               class="form-control"
                                               placeholder="District name">
                                        @error('district')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="region" class="form-label fw-medium text-muted">
                                            <i class="bi bi-globe me-1"></i>Region
                                        </label>
                                        <input type="text" 
                                               name="region" 
                                               id="region" 
                                               value="{{ old('region', $vocationalTraining->region) }}"
                                               class="form-control"
                                               placeholder="Region name">
                                        @error('region')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <!-- Program Management -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-gear me-2"></i>Program Management
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="training_fee" class="form-label fw-medium text-muted">
                                            <i class="bi bi-currency-dollar me-1"></i>Training Fee (TSH)
                                        </label>
                                        <input type="number" 
                                               name="training_fee" 
                                               id="training_fee" 
                                               value="{{ old('training_fee', $vocationalTraining->training_fee) }}"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               placeholder="e.g., 50000">
                                        @error('training_fee')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="materials_cost" class="form-label fw-medium text-muted">
                                            <i class="bi bi-box me-1"></i>Materials Cost (TSH)
                                        </label>
                                        <input type="number" 
                                               name="materials_cost" 
                                               id="materials_cost" 
                                               value="{{ old('materials_cost', $vocationalTraining->materials_cost) }}"
                                               min="0"
                                               step="0.01"
                                               class="form-control"
                                               placeholder="e.g., 15000">
                                        @error('materials_cost')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label fw-medium text-muted">
                                            <i class="bi bi-flag me-1"></i>Status <span class="text-danger">*</span>
                                        </label>
                                        <select name="status" 
                                                id="status" 
                                                required
                                                class="form-select">
                                            <option value="planning" {{ old('status', $vocationalTraining->status) == 'planning' ? 'selected' : '' }}>Planning</option>
                                            <option value="active" {{ old('status', $vocationalTraining->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="completed" {{ old('status', $vocationalTraining->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="suspended" {{ old('status', $vocationalTraining->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            <option value="cancelled" {{ old('status', $vocationalTraining->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3 d-flex align-items-center">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   name="certification_provided" 
                                                   id="certification_provided" 
                                                   value="1"
                                                   {{ old('certification_provided', $vocationalTraining->certification_provided) ? 'checked' : '' }}
                                                   class="form-check-input">
                                            <label for="certification_provided" class="form-check-label fw-medium text-muted">
                                                <i class="bi bi-award me-1"></i>Certification Provided
                                            </label>
                                        </div>
                                        @error('certification_provided')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Additional Information
                                </h5>
                                <div class="mb-3">
                                    <label for="learning_objectives" class="form-label fw-medium text-muted">
                                        <i class="bi bi-target me-1"></i>Learning Objectives
                                    </label>
                                    <textarea name="learning_objectives" 
                                              id="learning_objectives" 
                                              rows="4"
                                              class="form-control"
                                              placeholder="List the key learning objectives and outcomes for this training program...">{{ old('learning_objectives', $vocationalTraining->learning_objectives) }}</textarea>
                                    @error('learning_objectives')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label fw-medium text-muted">
                                        <i class="bi bi-sticky me-1"></i>Notes & Comments
                                    </label>
                                    <textarea name="notes" 
                                              id="notes" 
                                              rows="4"
                                              class="form-control"
                                              placeholder="Any additional notes or comments about this training program...">{{ old('notes', $vocationalTraining->notes) }}</textarea>
                                    @error('notes')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Record Information -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title text-dark mb-3">
                                    <i class="bi bi-clock-history me-2"></i>Record Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium text-muted">Created At</label>
                                        <p class="text-dark mb-1">{{ $vocationalTraining->created_at->format('F j, Y g:i A') }}</p>
                                        <p class="text-muted small">{{ $vocationalTraining->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium text-muted">Last Updated</label>
                                        <p class="text-dark mb-1">{{ $vocationalTraining->updated_at->format('F j, Y g:i A') }}</p>
                                        <p class="text-muted small">{{ $vocationalTraining->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                            <a href="{{ route('vocational-training.show', $vocationalTraining) }}" 
                               class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Back to Details
                            </a>

                            <div class="d-flex gap-3">
                                <a href="{{ route('vocational-training.index') }}" 
                                   class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Update Training Program
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-calculate end date based on start date and duration
        document.getElementById('start_date').addEventListener('change', calculateEndDate);
        document.getElementById('duration_weeks').addEventListener('input', calculateEndDate);

        function calculateEndDate() {
            const startDate = document.getElementById('start_date').value;
            const durationWeeks = document.getElementById('duration_weeks').value;
            
            if (startDate && durationWeeks) {
                const start = new Date(startDate);
                const end = new Date(start.getTime() + (durationWeeks * 7 * 24 * 60 * 60 * 1000));
                document.getElementById('end_date').value = end.toISOString().split('T')[0];
            }
        }

        // Validate current participants doesn't exceed max participants
        document.getElementById('current_participants').addEventListener('input', function() {
            const current = parseInt(this.value) || 0;
            const max = parseInt(document.getElementById('max_participants').value) || 0;
            
            if (max > 0 && current > max) {
                this.setCustomValidity('Current participants cannot exceed maximum participants');
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('max_participants').addEventListener('input', function() {
            const max = parseInt(this.value) || 0;
            const current = parseInt(document.getElementById('current_participants').value) || 0;
            
            if (max > 0 && current > max) {
                document.getElementById('current_participants').setCustomValidity('Current participants cannot exceed maximum participants');
            } else {
                document.getElementById('current_participants').setCustomValidity('');
            }
        });
    </script>
@endsection