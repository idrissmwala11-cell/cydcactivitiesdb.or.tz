@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">National Leadership Details</h5>
                    <div>
                        @if(auth()->user()->role === 'admin' || $nationalLeadership->user_id === auth()->id())
                            <a href="{{ route('national-leadership.edit', $nationalLeadership) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                        @endif
                        <a href="{{ route('national-leadership.index') }}" class="btn btn-secondary">
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
                                    <td><strong>Leader Name:</strong></td>
                                    <td>{{ $nationalLeadership->leader_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Position:</strong></td>
                                    <td>{{ $nationalLeadership->position }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Term End:</strong></td>
                                    <td>{{ $nationalLeadership->term_end ? $nationalLeadership->term_end->format('F Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Submitted By:</strong></td>
                                    <td>{{ $nationalLeadership->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Submitted On:</strong></td>
                                    <td>{{ $nationalLeadership->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="text-muted mb-3">National Leader Details</h6>
                    @if($nationalLeadership->nationalLeaderDetails->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Leader Name</th>
                                        <th>Participant Number</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nationalLeadership->nationalLeaderDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->leader_name }}</td>
                                            <td>{{ $detail->participant_number }}</td>
                                            <td>{{ $detail->position }}</td>
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