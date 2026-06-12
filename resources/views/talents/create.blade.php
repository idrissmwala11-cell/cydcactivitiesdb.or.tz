@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Add New Talent') }}</h4>
                    <a href="{{ route('talents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('talents.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="student_name" class="form-label">{{ __('Student Name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('student_name') is-invalid @enderror" 
                                       id="student_name" name="student_name" value="{{ old('student_name') }}" required>
                                @error('student_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="participant_number" class="form-label">{{ __('Participant Number') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('participant_number') is-invalid @enderror" 
                                       id="participant_number" name="participant_number" value="{{ old('participant_number') }}" required>
                                @error('participant_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="age" class="form-label">{{ __('Age') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                       id="age" name="age" value="{{ old('age') }}" min="1" max="100" required>
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">{{ __('Gender') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">{{ __('Select Gender') }}</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="mentor" class="form-label">{{ __('Mentor') }}</label>
                                <input type="text" class="form-control @error('mentor') is-invalid @enderror" 
                                       id="mentor" name="mentor" value="{{ old('mentor') }}">
                                @error('mentor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="talent_type" class="form-label">{{ __('Talent Type') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('talent_type') is-invalid @enderror" 
                                       id="talent_type" name="talent_type" value="{{ old('talent_type') }}" 
                                       placeholder="e.g., Music, Dance, Sports, Art" required>
                                @error('talent_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="talent_duration" class="form-label">{{ __('Talent Duration') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('talent_duration') is-invalid @enderror" 
                                       id="talent_duration" name="talent_duration" value="{{ old('talent_duration') }}" 
                                       placeholder="e.g., 2 years, 6 months" required>
                                @error('talent_duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="talent_description" class="form-label">{{ __('Talent Description') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('talent_description') is-invalid @enderror" 
                                      id="talent_description" name="talent_description" rows="3" required>{{ old('talent_description') }}</textarea>
                            @error('talent_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="has_competed" name="has_competed" 
                                           {{ old('has_competed') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_competed">
                                        {{ __('Has Competed') }}
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="needs_training" name="needs_training" 
                                           {{ old('needs_training') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="needs_training">
                                        {{ __('Needs Training') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3" id="competition_details_section" style="display: none;">
                            <label for="competition_details" class="form-label">{{ __('Competition Details') }}</label>
                            <textarea class="form-control @error('competition_details') is-invalid @enderror" 
                                      id="competition_details" name="competition_details" rows="2">{{ old('competition_details') }}</textarea>
                            @error('competition_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="achievements" class="form-label">{{ __('Achievements') }}</label>
                            <textarea class="form-control @error('achievements') is-invalid @enderror" 
                                      id="achievements" name="achievements" rows="2">{{ old('achievements') }}</textarea>
                            @error('achievements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="training_details_section" style="display: none;">
                            <label for="training_details" class="form-label">{{ __('Training Details') }}</label>
                            <textarea class="form-control @error('training_details') is-invalid @enderror" 
                                      id="training_details" name="training_details" rows="2">{{ old('training_details') }}</textarea>
                            @error('training_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">{{ __('Comments') }}</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                      id="comments" name="comments" rows="2">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('talents.index') }}" class="btn btn-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Talent') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hasCompetedCheckbox = document.getElementById('has_competed');
    const needsTrainingCheckbox = document.getElementById('needs_training');
    const competitionDetailsSection = document.getElementById('competition_details_section');
    const trainingDetailsSection = document.getElementById('training_details_section');
    const form = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');

    function toggleSections() {
        competitionDetailsSection.style.display = hasCompetedCheckbox.checked ? 'block' : 'none';
        trainingDetailsSection.style.display = needsTrainingCheckbox.checked ? 'block' : 'none';
    }

    hasCompetedCheckbox.addEventListener('change', toggleSections);
    needsTrainingCheckbox.addEventListener('change', toggleSections);

    // Initialize on page load
    toggleSections();

    // Add form submission debugging
    form.addEventListener('submit', function(e) {
        console.log('Form submission started');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    });

    // Add error handling for form validation
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    inputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            console.log('Validation error on:', e.target.name, e.target.validationMessage);
        });
    });
});
</script>
@endsection