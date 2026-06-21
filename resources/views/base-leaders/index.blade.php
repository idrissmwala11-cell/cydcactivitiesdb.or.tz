@extends('layouts.app')
@section('title', 'Base Leaders')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="mb-1"><i class="bi bi-people-fill me-2 text-primary"></i>Base Leadership</h4>
                <p class="text-muted mb-0">List of base leadership records.</p>
            </div>
            <x-module-report-actions module="base_leader">
                <a href="{{ route('base-leaders.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add New Record
                </a>
            </x-module-report-actions>
        </div>

        <div class="card-body">
            @if($baseLeaders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Base</th>
                                <th>Number of Leaders</th>
                                <th>Chairperson / First Leader</th>
                                <th>Term End Date</th>
                                <th>Submitted By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($baseLeaders as $baseLeader)
                                @php $firstLeader = $baseLeader->baseLeaderDetails->first(); @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $baseLeader->base_name }}</td>
                                    <td>{{ $baseLeader->leaders_count }}</td>
                                    <td>{{ $firstLeader?->leader_name ?? 'N/A' }}</td>
                                    <td>{{ $baseLeader->term_end?->format('d M Y') ?? 'N/A' }}</td>
                                    <td><x-user-identity :user="$baseLeader->user" /></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('base-leaders.show', $baseLeader) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                            @if(auth()->user()->role === 'admin' || $baseLeader->user_id === auth()->id())
                                                <a href="{{ route('base-leaders.edit', $baseLeader) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                                <form action="{{ route('base-leaders.destroy', $baseLeader) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $baseLeaders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-5 text-muted"></i>
                    <h5 class="mt-3">No base leadership records yet</h5>
                    <p class="text-muted">Start by adding the first record.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
