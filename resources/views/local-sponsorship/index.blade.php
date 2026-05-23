@extends('layouts.app')

@section('title', 'Local Sponsorship')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1">Local Sponsorship</h2>
            <p class="text-muted mb-0">Manage children registered under local sponsorship.</p>
        </div>
        <a href="{{ route('local-sponsorship.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Record
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($localSponsorships->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Child</th>
                                <th>Age</th>
                                <th>Location</th>
                                <th>Sponsor</th>
                                <th>Local Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($localSponsorships as $record)
                                <tr>
                                    <td class="fw-semibold">{{ $record->child_name }}</td>
                                    <td>{{ $record->child_age }}</td>
                                    <td>{{ $record->child_location }}</td>
                                    <td>
                                        <div>{{ $record->sponsor_name }}</div>
                                        <small class="text-muted">{{ $record->sponsor_type }}</small>
                                    </td>
                                    <td>{{ $record->local_number }}</td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <a href="{{ route('local-sponsorship.show', $record) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            <a href="{{ route('local-sponsorship.edit', $record) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-heart text-primary" style="font-size: 2.25rem;"></i>
                    <p class="text-muted mt-3 mb-0">No local sponsorship records found yet.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        {{ $localSponsorships->links() }}
    </div>
</div>
@endsection
