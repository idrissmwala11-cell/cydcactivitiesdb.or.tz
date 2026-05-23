@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-journal-text me-2"></i>
                        {{ $section['title'] }}
                    </h5>
                    <a href="{{ route($section['route'] . '.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Add New Record
                    </a>
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
                                    <th>Student / Name</th>
                                    <th>School / Institution</th>
                                    @if(Auth::user()->role === 'admin')
                                        <th>Submitted By</th>
                                    @endif
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $record)
                                    @php
                                        $data = is_array($record->form_data) ? $record->form_data : (json_decode($record->form_data, true) ?: []);
                                        $studentName = $data['student_name'] ?? $data['institution_name'] ?? $data['contact_person'] ?? 'N/A';
                                        $schoolName = $data['school_name'] ?? $data['university_name'] ?? $data['college_name'] ?? $data['institution_name'] ?? 'N/A';
                                    @endphp
                                    <tr>
                                        <td>{{ $record->id }}</td>
                                        <td>{{ $studentName }}</td>
                                        <td>{{ $schoolName }}</td>
                                        @if(Auth::user()->role === 'admin')
                                            <td>{{ $record->user->center_id ?? $record->user->email ?? $record->user->name ?? 'Legacy record' }}</td>
                                        @endif
                                        <td>{{ $record->created_at?->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route($section['route'] . '.show', $record) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if(Auth::user()->role === 'admin' || Auth::id() === (int) $record->user_id)
                                                    <a href="{{ route($section['route'] . '.edit', $record) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route($section['route'] . '.destroy', $record) }}" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
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
                                        <td colspan="{{ Auth::user()->role === 'admin' ? 6 : 5 }}" class="text-center py-4">
                                            <i class="bi bi-journal-text text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 mb-0">No {{ strtolower($section['title']) }} records available at the moment.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($records->hasPages())
                        <div class="mt-4">
                            {{ $records->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
