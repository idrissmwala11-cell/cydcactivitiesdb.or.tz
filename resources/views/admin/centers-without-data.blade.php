@extends('layouts.app')

@section('title', 'Centers Without Data')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #7f1d1d, #dc2626); color: #fff;">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-4">
                <div>
                    <span class="badge bg-light text-danger fw-semibold mb-3 px-3 py-2">Admin Insight</span>
                    <h2 class="fw-bold mb-2">Centers Without Any Data</h2>
                    <p class="mb-0 text-white-50">Hapa unaona center IDs ambazo zimesajiliwa lakini hazijawahi kujaza data yoyote kwenye system.</p>
                </div>
                <div class="text-end">
                    <div class="fs-1 fw-bold">{{ number_format($totalCentersWithoutData) }}</div>
                    <div class="text-white-50">Center IDs</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1">Centers Without Submitted Records</h4>
                <p class="mb-0 text-muted">List ya vituo ambavyo bado havijawahi ku-submit data kwenye modules zozote.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Center ID</th>
                            <th>Total Users</th>
                            <th>First Registered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($centersWithoutData as $index => $center)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="fw-semibold">{{ strtoupper($center->center_id) }}</span></td>
                                <td><span class="badge bg-light text-dark">{{ $center->total_users }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($center->first_registered_at)->format('d M Y') }}</td>
                                <td><span class="badge bg-danger-subtle text-danger">No data submitted</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">There are no center IDs remaining without data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
