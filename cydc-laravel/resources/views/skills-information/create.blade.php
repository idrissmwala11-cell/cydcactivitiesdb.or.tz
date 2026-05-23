@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Add New Skills Information') }}</h4>
                    <a href="{{ route('skills-information.index') }}" class="btn btn-secondary">
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

                    <form action="{{ route('skills-information.store') }}" method="POST">
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

                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">{{ __('Gender') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">{{ __('Select Gender') }}</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="student_id" class="form-label">{{ __('Student ID') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('student_id') is-invalid @enderror" 
                                       id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="skill_category" class="form-label">{{ __('Skill Category') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('skill_category') is-invalid @enderror" 
                                       id="skill_category" name="skill_category" value="{{ old('skill_category') }}" 
                                       placeholder="e.g., Technical, Creative, Sports" required>
                                @error('skill_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="skills_type" class="form-label">{{ __('Skills Type') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('skills_type') is-invalid @enderror" 
                                       id="skills_type" name="skills_type" value="{{ old('skills_type') }}" 
                                       placeholder="e.g., Individual, Group" required>
                                @error('skills_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="skill_level" class="form-label">{{ __('Skill Level') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('skill_level') is-invalid @enderror" id="skill_level" name="skill_level" required>
                                    <option value="">{{ __('Select Level') }}</option>
                                    <option value="Beginner" {{ old('skill_level') == 'Beginner' ? 'selected' : '' }}>{{ __('Beginner') }}</option>
                                    <option value="Intermediate" {{ old('skill_level') == 'Intermediate' ? 'selected' : '' }}>{{ __('Intermediate') }}</option>
                                    <option value="Advanced" {{ old('skill_level') == 'Advanced' ? 'selected' : '' }}>{{ __('Advanced') }}</option>
                                    <option value="Expert" {{ old('skill_level') == 'Expert' ? 'selected' : '' }}>{{ __('Expert') }}</option>
                                </select>
                                @error('skill_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="has_certification" class="form-label">{{ __('Has Certification') }}</label>
                                <input type="text" class="form-control @error('has_certification') is-invalid @enderror" 
                                       id="has_certification" name="has_certification" value="{{ old('has_certification') }}" 
                                       placeholder="Yes/No or certification name">
                                @error('has_certification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="specific_skills" class="form-label">{{ __('Specific Skills') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('specific_skills') is-invalid @enderror" 
                                      id="specific_skills" name="specific_skills" rows="3" required 
                                      placeholder="Describe the specific skills in detail">{{ old('specific_skills') }}</textarea>
                            @error('specific_skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="group_skills_details" class="form-label">{{ __('Group Skills Details') }}</label>
                            <textarea class="form-control @error('group_skills_details') is-invalid @enderror" 
                                      id="group_skills_details" name="group_skills_details" rows="3" 
                                      placeholder="Details about group skills (if applicable)">{{ old('group_skills_details') }}</textarea>
                            @error('group_skills_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="certification_details" class="form-label">{{ __('Certification Details') }}</label>
                            <textarea class="form-control @error('certification_details') is-invalid @enderror" 
                                      id="certification_details" name="certification_details" rows="2" 
                                      placeholder="Details about certifications obtained">{{ old('certification_details') }}</textarea>
                            @error('certification_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mentor" class="form-label">{{ __('Mentor') }}</label>
                                <input type="text" class="form-control @error('mentor') is-invalid @enderror" 
                                       id="mentor" name="mentor" value="{{ old('mentor') }}" 
                                       placeholder="Name of mentor or instructor">
                                @error('mentor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="challenges" class="form-label">{{ __('Challenges') }}</label>
                            <textarea class="form-control @error('challenges') is-invalid @enderror" 
                                      id="challenges" name="challenges" rows="3" 
                                      placeholder="Describe any challenges faced">{{ old('challenges') }}</textarea>
                            @error('challenges')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="support_received" class="form-label">{{ __('Support Received') }}</label>
                            <textarea class="form-control @error('support_received') is-invalid @enderror" 
                                      id="support_received" name="support_received" rows="3" 
                                      placeholder="Describe support received for skill development">{{ old('support_received') }}</textarea>
                            @error('support_received')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comments" class="form-label">{{ __('Comments') }}</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" 
                                      id="comments" name="comments" rows="3" 
                                      placeholder="Additional comments or notes">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('skills-information.index') }}" class="btn btn-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Skills Information') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
