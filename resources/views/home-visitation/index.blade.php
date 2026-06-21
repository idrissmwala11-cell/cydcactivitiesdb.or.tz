@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">
                        <i class="bi bi-house-door me-2 text-primary"></i>
                        Home Visitation Records
                    </h4>
                    <p class="text-muted mb-0">Manage home visitation records in a clean and easy-to-read layout.</p>
                </div>

                <a href="{{ route('home-visitation.create') }}" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-1"></i>Add New Record
                </a>
            </div>
        </div>

        <div class="card-body px-4 pb-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-3">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Total Records</div>
                            <div class="h4 mb-0 fw-bold">{{ number_format($homeVisitations->total()) }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Visible On This Page</div>
                            <div class="h4 mb-0 fw-bold">{{ number_format($homeVisitations->count()) }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-info bg-opacity-10 h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted mb-1">Recent Visit Date</div>
                            <div class="h6 mb-0 fw-bold">
                                {{ optional($homeVisitations->first()?->visit_date)->format('M d, Y') ?? 'No visits yet' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Participant Name</th>
                            <th>Visit Date</th>
                            <th>School</th>
                            <th>Visitor</th>
                            <th>Submitted By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($homeVisitations as $visitation)
                            @php
                                $submittedBy = $visitation->user->center_id
                                    ?? $visitation->user->email
                                    ?? $visitation->user->name
                                    ?? null;
                            @endphp
                            <tr>
                                <td>
                                    <span class="badge bg-dark-subtle text-dark px-3 py-2">{{ $visitation->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $visitation->jina ?? 'N/A' }}</div>
                                </td>
                                <td>{{ $visitation->visit_date?->format('M d, Y') ?? 'N/A' }}</td>
                                <td>{{ $visitation->shule ?? 'N/A' }}</td>
                                <td>{{ $visitation->mtembelezaji ?? 'N/A' }}</td>

                                <td>
                                    @if($submittedBy)
                                        <x-user-identity :user="$visitation->user" :show-email="true" />
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Legacy record</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('home-visitation.show', $visitation->id) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>

                                        @if(Auth::user()->role === 'admin' || Auth::id() === (int) $visitation->user_id)
                                            <a href="{{ route('home-visitation.edit', $visitation->id) }}" class="btn btn-sm btn-outline-warning">
                                                Edit
                                            </a>

                                            <form action="{{ route('home-visitation.destroy', $visitation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-house-door text-muted" style="font-size: 2.5rem;"></i>
                                    <p class="text-muted mt-3 mb-2">No home visitation records found.</p>
                                    <a href="{{ route('home-visitation.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Add First Record
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($homeVisitations->hasPages())
                <div class="mt-4">
                    {{ $homeVisitations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
