@extends('layouts.app')

@section('title', 'View Local Sponsorship')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1">{{ $localSponsorship->child_name }}</h2>
            <p class="text-muted mb-0">Local sponsorship record details.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('local-sponsorship.edit', $localSponsorship) }}" class="btn btn-outline-primary">Edit</a>
            <a href="{{ route('local-sponsorship.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <strong>Child's Name</strong>
                    <div class="text-muted">{{ $localSponsorship->child_name }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Child's Age</strong>
                    <div class="text-muted">{{ $localSponsorship->child_age }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Location</strong>
                    <div class="text-muted">{{ $localSponsorship->child_location }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Child's Local Number</strong>
                    <div class="text-muted">{{ $localSponsorship->local_number }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Sponsor Type</strong>
                    <div class="text-muted">{{ $localSponsorship->sponsor_type }}</div>
                </div>
                <div class="col-md-6">
                    <strong>Local Sponsor Name</strong>
                    <div class="text-muted">{{ $localSponsorship->sponsor_name }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
