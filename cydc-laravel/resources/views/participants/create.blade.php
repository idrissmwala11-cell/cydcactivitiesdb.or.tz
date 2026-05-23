@extends('layouts.app')

@section('title', 'Add Participant')

@section('content')
<div class="container py-4">
    <h1 class="h4 mb-3">Add Participant</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('participants.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2"></i> Save
                    </button>
                    <a href="{{ route('participants.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection