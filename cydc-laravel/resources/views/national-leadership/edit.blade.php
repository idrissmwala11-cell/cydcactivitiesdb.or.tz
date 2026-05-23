@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit National Leadership Information</h5>
                    <a href="{{ route('national-leadership.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('national-leadership.update', $nationalLeadership) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leader_name" class="form-label">Leader Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('leader_name') is-invalid @enderror" 
                                           id="leader_name" name="leader_name" value="{{ old('leader_name', $nationalLeadership->leader_name) }}" required>
                                    @error('leader_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                           id="position" name="position" value="{{ old('position', $nationalLeadership->position) }}" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="term_end" class="form-label">Term End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('term_end') is-invalid @enderror" 
                                           id="term_end" name="term_end" value="{{ old('term_end', $nationalLeadership->term_end?->format('Y-m-d')) }}" required>
                                    @error('term_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <h6 class="mb-3">National Leader Details</h6>
                        
                        <div id="leaders-container">
                            @foreach($nationalLeadership->nationalLeaderDetails as $index => $detail)
                                <div class="leader-entry border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Leader Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="leaders[{{ $index }}][leader_name]" 
                                                       value="{{ old('leaders.'.$index.'.leader_name', $detail->leader_name) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Participant Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="leaders[{{ $index }}][participant_number]" 
                                                       value="{{ old('leaders.'.$index.'.participant_number', $detail->participant_number) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="leaders[{{ $index }}][position]" 
                                                       value="{{ old('leaders.'.$index.'.position', $detail->position) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    @if($index > 0)
                                        <div class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-leader">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="add-leader">
                                <i class="bi bi-plus-circle me-1"></i>Add Another Leader
                            </button>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('national-leadership.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let leaderIndex = {{ $nationalLeadership->nationalLeaderDetails->count() }};

document.getElementById('add-leader').addEventListener('click', function() {
    const container = document.getElementById('leaders-container');
    const newLeader = document.createElement('div');
    newLeader.className = 'leader-entry border rounded p-3 mb-3';
    newLeader.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Leader Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="leaders[${leaderIndex}][leader_name]" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Participant Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="leaders[${leaderIndex}][participant_number]" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Position <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="leaders[${leaderIndex}][position]" required>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn-sm btn-outline-danger remove-leader">
                <i class="bi bi-trash"></i> Remove
            </button>
        </div>
    `;
    
    container.appendChild(newLeader);
    leaderIndex++;
    
    // Add remove functionality
    newLeader.querySelector('.remove-leader').addEventListener('click', function() {
        newLeader.remove();
    });
});

// Add remove functionality to existing remove buttons
document.querySelectorAll('.remove-leader').forEach(button => {
    button.addEventListener('click', function() {
        button.closest('.leader-entry').remove();
    });
});
</script>
@endsection