@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-building-check me-2"></i>
                        School Visitation Records
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('reports.run', ['module' => 'school_visitation', 'center_id' => strtoupper(auth()->user()->center_id ?? ''), 'period' => 'all']) }}" class="btn btn-success">
                            <i class="bi bi-bar-chart-line me-1"></i>
                            Run Report
                        </a>
                        <a href="{{ route('school-visitation.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>
                            Add New Record
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Participant Name</th>
                                    <th>Registration Number</th>
                                    <th>School</th>
                                    <th>Class</th>
                                    <th>Presence</th>
                                    @if(Auth::user()->role === 'admin')
                                        <th>Submitted By</th>
                                    @endif
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schoolVisitations as $visitation)
                                    <tr>
                                        <td>{{ $visitation->id }}</td>
                                        <td>{{ $visitation->participant_name }}</td>
                                        <td>{{ $visitation->registration_number }}</td>
                                        <td>{{ $visitation->school_name }}</td>
                                        <td>{{ $visitation->class_level }}</td>
                                        <td>
                                            <span class="badge bg-{{ $visitation->participant_presence === 'Present' ? 'success' : 'danger' }}">
                                                {{ $visitation->participant_presence }}
                                            </span>
                                        </td>
                                        @if(Auth::user()->role === 'admin')
                                            <td><x-user-identity :user="$visitation->user" /></td>
                                        @endif
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('school-visitation.show', $visitation) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if(Auth::user()->role === 'admin' || Auth::id() === (int) $visitation->user_id)
                                                    <a href="{{ route('school-visitation.edit', $visitation) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('school-visitation.destroy', $visitation) }}" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
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
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role === 'admin' ? 8 : 7 }}" class="text-center py-4">
                                            <i class="bi bi-building-check text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No school visitation records available at the moment.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($schoolVisitations->hasPages())
                        <div class="mt-4">
                            {{ $schoolVisitations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
