@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Cluster Leadership Information</h5>
                    <a href="{{ route('cluster-leadership.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add New
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($clusterLeaders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cluster Name</th>
                                        <th>Location</th>
                                        <th>Term End</th>
                                        <th>Submitted By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clusterLeaders as $clusterLeader)
                                        <tr>
                                            <td>{{ $clusterLeader->cluster_name }}</td>
                                            <td>{{ $clusterLeader->yds_name }}</td>
                                            <td>{{ $clusterLeader->leadership_term ? \Carbon\Carbon::parse($clusterLeader->leadership_term)->format('M Y') : 'N/A' }}</td>
                                            <td><x-user-identity :user="$clusterLeader->user" /></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('cluster-leadership.show', $clusterLeader) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->role === 'admin' || $clusterLeader->user_id === auth()->id())
                                                        <a href="{{ route('cluster-leadership.edit', $clusterLeader) }}" class="btn btn-sm btn-outline-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('cluster-leadership.destroy', $clusterLeader) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $clusterLeaders->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No cluster leadership information found</h4>
                            <p class="text-muted">Start by adding your first cluster leadership record.</p>
                            <a href="{{ route('cluster-leadership.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Add New Record
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
