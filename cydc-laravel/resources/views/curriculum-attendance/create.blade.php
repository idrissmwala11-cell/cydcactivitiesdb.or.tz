@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Add New Curriculum Attendance') }}</h4>
                    <a href="{{ route('curriculum-attendance.index') }}" class="btn btn-secondary">
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

                    <form action="{{ route('curriculum-attendance.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tarehe" class="form-label">{{ __('Date') }} (Tarehe) <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tarehe') is-invalid @enderror" 
                                       id="tarehe" name="tarehe" value="{{ old('tarehe', date('Y-m-d')) }}" required>
                                @error('tarehe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jina_la_mwalimu" class="form-label">{{ __('Teacher Name') }} (Jina la Mwalimu) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jina_la_mwalimu') is-invalid @enderror" 
                                       id="jina_la_mwalimu" name="jina_la_mwalimu" value="{{ old('jina_la_mwalimu') }}" required>
                                @error('jina_la_mwalimu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="somo" class="form-label">{{ __('Subject') }} (Somo) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('somo') is-invalid @enderror" 
                                       id="somo" name="somo" value="{{ old('somo') }}" 
                                       placeholder="e.g., Mathematics, English, Science" required>
                                @error('somo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="wahudhuria" class="form-label">{{ __('Attendance Count') }} (Wahudhuria) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('wahudhuria') is-invalid @enderror" 
                                       id="wahudhuria" name="wahudhuria" value="{{ old('wahudhuria') }}" 
                                       min="0" required>
                                @error('wahudhuria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mada" class="form-label">{{ __('Topic/Lesson Details') }} (Mada) <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('mada') is-invalid @enderror" 
                                      id="mada" name="mada" rows="3" required 
                                      placeholder="Describe the lesson topic and details">{{ old('mada') }}</textarea>
                            @error('mada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="maoni_ya_mwalimu" class="form-label">{{ __('Teacher Comments') }} (Maoni ya Mwalimu)</label>
                            <textarea class="form-control @error('maoni_ya_mwalimu') is-invalid @enderror" 
                                      id="maoni_ya_mwalimu" name="maoni_ya_mwalimu" rows="3" 
                                      placeholder="Teacher's comments about the lesson">{{ old('maoni_ya_mwalimu') }}</textarea>
                            @error('maoni_ya_mwalimu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="maoni_ya_msimamizi" class="form-label">{{ __('Supervisor Comments') }} (Maoni ya Msimamizi)</label>
                            <textarea class="form-control @error('maoni_ya_msimamizi') is-invalid @enderror" 
                                      id="maoni_ya_msimamizi" name="maoni_ya_msimamizi" rows="3" 
                                      placeholder="Supervisor's comments and observations">{{ old('maoni_ya_msimamizi') }}</textarea>
                            @error('maoni_ya_msimamizi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Absent Participants Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">{{ __('Absent Participants') }} (Washiriki Wasio Hapa)</h5>
                                <small class="text-muted">{{ __('Add details of students who were absent') }}</small>
                            </div>
                            <div class="card-body">
                                <div id="absent-participants-container">
                                    <!-- Dynamic absent participants will be added here -->
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-absent-participant">
                                    <i class="fas fa-plus"></i> {{ __('Add Absent Participant') }}
                                </button>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('curriculum-attendance.index') }}" class="btn btn-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ __('Save Curriculum Attendance') }}
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
    let participantIndex = 0;
    const container = document.getElementById('absent-participants-container');
    const addButton = document.getElementById('add-absent-participant');

    addButton.addEventListener('click', function() {
        const participantHtml = `
            <div class="row mb-3 absent-participant-row" data-index="${participantIndex}">
                <div class="col-md-5">
                    <label for="absent_participants_${participantIndex}_name" class="form-label">{{ __('Student Name') }}</label>
                    <input type="text" class="form-control" 
                           id="absent_participants_${participantIndex}_name" 
                           name="absent_participants[${participantIndex}][name]" 
                           placeholder="Enter student name">
                </div>
                <div class="col-md-5">
                    <label for="absent_participants_${participantIndex}_reason" class="form-label">{{ __('Reason for Absence') }}</label>
                    <input type="text" class="form-control" 
                           id="absent_participants_${participantIndex}_reason" 
                           name="absent_participants[${participantIndex}][reason]" 
                           placeholder="Reason for absence (optional)">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-participant">
                        <i class="fas fa-trash"></i> {{ __('Remove') }}
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', participantHtml);
        participantIndex++;
    });

    // Handle remove participant
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-participant') || e.target.closest('.remove-participant')) {
            const row = e.target.closest('.absent-participant-row');
            if (row) {
                row.remove();
            }
        }
    });
});
</script>
@endsection
