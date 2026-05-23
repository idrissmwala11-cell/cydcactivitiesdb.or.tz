@extends('layouts.app')

@section('title', 'Participants')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Participants</h1>
        <a href="{{ route('participants.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> New Participant
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-0">This is a placeholder page. Implement listing once models are ready.</p>
        </div>
    </div>
</div>
@endsection