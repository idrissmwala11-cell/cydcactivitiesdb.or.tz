@extends('layouts.app')

@section('title', 'Parent Details')

@section('content')
<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Parent Information</strong>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Parent / Guardian Name</small>
                            <span class="h6">{{ $parentsInformation->parent_name }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Parent Of</small>
                            <span class="h6">{{ $parentsInformation->parent_of }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Occupation / Activity</small>
                            <span class="h6">{{ $parentsInformation->activity }}</span>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Support Type</small>
                            <span class="badge bg-primary">{{ $parentsInformation->support_type }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Residential Address</small>
                        <div>{{ $parentsInformation->address }}</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Comments</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Parent Comments About the Service</small>
                        <div>{{ $parentsInformation->parent_comments ?: '—' }}</div>
                    </div>
                    <div>
                        <small class="text-muted d-block">Supervisor Comments</small>
                        <div>{{ $parentsInformation->supervisor_comments ?: '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong>Record Information</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Submission Date</small>
                            <div>{{ optional($parentsInformation->submission_date)->format('M d, Y') }}</div>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Submitted By</small>
                            <x-user-identity :user="$parentsInformation->user" :show-email="true" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Status</span>
                        @php($status = $parentsInformation->status ?? 'pending')
                        <span class="badge bg-{{ $status === 'approved' ? 'success' : ($status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                    @if($parentsInformation->admin_comments)
                        <div class="mb-2">
                            <small class="text-muted d-block">Admin Comments</small>
                            <div>{{ $parentsInformation->admin_comments }}</div>
                        </div>
                    @endif
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('parents-information.index') }}" class="btn btn-outline-secondary">Back</a>
                        <a href="{{ route('parents-information.edit', $parentsInformation) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('parents-information.destroy', $parentsInformation) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Delete</button>
                        </form>
                    </div>
                </div>
            </div>

            @can('admin')
            <div class="card">
                <div class="card-header bg-light"><strong>Admin Actions</strong></div>
                <div class="card-body">
                    <form action="{{ route('parents-information.approve', $parentsInformation) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PATCH')
                        <div class="mb-2">
                            <textarea name="admin_comments" class="form-control" placeholder="Optional admin comments"></textarea>
                        </div>
                        <button class="btn btn-success w-100">Approve</button>
                    </form>
                    @if(Auth::user()->role === 'admin')
<form action="{{ route('parents-information.destroy', $parentsInformation) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger w-100">Delete</button>
</form>
@endif
                        <div class="mb-2">
                            <textarea name="admin_comments" class="form-control" placeholder="Reason for rejection (required)"></textarea>
                        </div>
                        <button class="btn btn-outline-danger w-100">Reject</button>
                    </form>
                </div>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
