@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-graph-up-arrow me-2"></i>
                        {{ $section['title'] }}
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('reports.run', ['module' => $section['report_module'], 'center_id' => strtoupper(auth()->user()->center_id ?? ''), 'period' => 'all']) }}" class="btn btn-success">
                            <i class="bi bi-bar-chart-line me-1"></i>
                            Run Report
                        </a>
                        <a href="{{ route($section['route'] . '.create') }}" class="btn btn-primary">
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
                                    <th>Student Name</th>
                                    <th>School / Institution</th>
                                    <th>Class / Level</th>
                                    <th>Exam</th>
                                    <th>Result</th>
                                    @if(Auth::user()->role === 'admin')
                                        <th>Submitted By</th>
                                    @endif
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($examResults as $examResult)
                                    <tr>
                                        <td>{{ $examResult->id }}</td>
                                        <td>{{ $examResult->student_name }}</td>
                                        <td>{{ $examResult->school_name }}</td>
                                        <td>{{ $examResult->class_level }}</td>
                                        <td>
                                            {{ $examResult->exam_type }}
                                            <div class="small text-muted">{{ $examResult->exam_year }}</div>
                                        </td>
                                        <td>
                                            {{ $section['uses_gpa'] ? ($examResult->gpa ?: 'N/A') : ($examResult->performance ?: 'N/A') }}
                                        </td>
                                        @if(Auth::user()->role === 'admin')
                                            <td><x-user-identity :user="$examResult->user" /></td>
                                        @endif
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route($section['route'] . '.show', $examResult) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if(Auth::user()->role === 'admin' || Auth::id() === (int) $examResult->user_id)
                                                    <a href="{{ route($section['route'] . '.edit', $examResult) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route($section['route'] . '.destroy', $examResult) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
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
                                            <i class="bi bi-clipboard-data text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 mb-0">There are currently no {{ strtolower($section['title']) }} records.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($examResults->hasPages())
                        <div class="mt-4">
                            {{ $examResults->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
