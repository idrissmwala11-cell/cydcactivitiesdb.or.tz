@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">National Leadership Information</h5>
                    <x-module-report-actions module="national_leader">
                        <a href="{{ route('national-leadership.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add New
                        </a>
                    </x-module-report-actions>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($nationalLeaders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Center</th>
                                        <th>Number of Leaders</th>
                                        <th>Term End</th>
                                        <th>Submitted By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($nationalLeaders as $nationalLeader)
                                        @php $leadCount = $nationalLeader->nationalLeaderDetails->count(); @endphp
                                        <tr>
                                            <td>{{ $nationalLeader->center }}</td>
                                            <td>{{ $leadCount }}</td>
                                            <td>{{ $nationalLeader->term_end ? $nationalLeader->term_end->format('M Y') : 'N/A' }}</td>
                                            <td><x-user-identity :user="$nationalLeader->user" /></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('national-leadership.show', $nationalLeader) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->role === 'admin' || $nationalLeader->user_id === auth()->id())
                                                        <a href="{{ route('national-leadership.edit', $nationalLeader) }}" class="btn btn-sm btn-outline-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('national-leadership.destroy', $nationalLeader) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
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
                        
                        {{ $nationalLeaders->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No national leadership information found</h4>
                            <p class="text-muted">Start by adding your first national leadership record.</p>
                            <a href="{{ route('national-leadership.create') }}" class="btn btn-primary">
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
