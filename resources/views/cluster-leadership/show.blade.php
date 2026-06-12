@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cluster Leadership Details</h5>
                    <div>
                        @if(auth()->user()->role === 'admin' || $clusterLeadership->user_id === auth()->id())
                            <a href="{{ route('cluster-leadership.edit', $clusterLeadership) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                        @endif
                        <a href="{{ route('cluster-leadership.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Basic Information</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Cluster Name:</strong></td>
                                    <td>{{ $clusterLeadership->cluster_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Location / Area:</strong></td>
                                    <td>{{ $clusterLeadership->yds_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Term End:</strong></td>
                                    <td>{{ $clusterLeadership->leadership_term ? \Carbon\Carbon::parse($clusterLeadership->leadership_term)->format('F Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Submitted By:</strong></td>
                                    <td>{{ $clusterLeadership->user->center_id ?? $clusterLeadership->user->email ?? $clusterLeadership->user->name ?? 'Legacy record' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Submission Date:</strong></td>
                                    <td>{{ $clusterLeadership->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="text-muted mb-3">Leaders List</h6>
                    @if($clusterLeadership->clusterLeaderDetails->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Leader Name</th>
                                        <th>Leader Number</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clusterLeadership->clusterLeaderDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->leader_name }}</td>
                                            <td>{{ $detail->leader_id }}</td>
                                            <td>{{ $detail->leader_position }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>No leader details available.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
