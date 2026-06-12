@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cluster Leadership Information</h5>
                    <a href="{{ route('cluster-leadership.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('cluster-leadership.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cluster_name" class="form-label">Cluster Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('cluster_name') is-invalid @enderror" 
                                           id="cluster_name" name="cluster_name" value="{{ old('cluster_name') }}" required>
                                    @error('cluster_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location / Area <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location') }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="term_end" class="form-label">Leadership Term End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('term_end') is-invalid @enderror" 
                                           id="term_end" name="term_end" value="{{ old('term_end') }}" required>
                                    @error('term_end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        <h6 class="mb-3">Leaders List</h6>
                        
                        <div id="leaders-container">
                            <div class="leader-entry border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Leader Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="leaders[0][leader_name]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Leader Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="leaders[0][leader_id]" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Position <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="leaders[0][leader_position]" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="add-leader">
                                <i class="bi bi-plus-circle me-1"></i>Add Leader
                            </button>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cluster-leadership.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let leaderIndex = 1;

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
                    <label class="form-label">Leader Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="leaders[${leaderIndex}][leader_id]" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Position <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="leaders[${leaderIndex}][leader_position]" required>
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
</script>
@endsection
