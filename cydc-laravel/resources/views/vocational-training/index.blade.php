@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Vocational Training Programs</h4>
                </div>
                <div class="card-body">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="text-dark mb-1">Vocational Training Programs</h5>
                            <p class="text-muted mb-0">
                                Manage vocational training programs and track participant progress.
                            </p>
                        </div>
                        <a href="{{ route('vocational-training.create') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add New Training Program
                        </a>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="card mb-4">
                        <div class="card-body bg-light">
                            <form method="GET" action="{{ route('vocational-training.index') }}">
                                <div class="row g-3">
                                    <!-- Search -->
                                    <div class="col-md-3">
                                        <label for="search" class="form-label">Search</label>
                                        <input type="text" 
                                               name="search" 
                                               id="search"
                                               value="{{ request('search') }}"
                                               placeholder="Search by program name, instructor..."
                                               class="form-control">
                                    </div>

                                    <!-- Training Type Filter -->
                                    <div class="col-md-3">
                                        <label for="training_type" class="form-label">Training Type</label>
                                        <select name="training_type" 
                                                id="training_type"
                                                class="form-select">
                                            <option value="">All Types</option>
                                            <option value="technical" {{ request('training_type') == 'technical' ? 'selected' : '' }}>Technical</option>
                                            <option value="business" {{ request('training_type') == 'business' ? 'selected' : '' }}>Business</option>
                                            <option value="agriculture" {{ request('training_type') == 'agriculture' ? 'selected' : '' }}>Agriculture</option>
                                            <option value="handicraft" {{ request('training_type') == 'handicraft' ? 'selected' : '' }}>Handicraft</option>
                                            <option value="computer" {{ request('training_type') == 'computer' ? 'selected' : '' }}>Computer</option>
                                            <option value="other" {{ request('training_type') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" 
                                                id="status"
                                                class="form-select">
                                            <option value="">All Status</option>
                                            <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Planning</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>

                                    <!-- Location Filter -->
                                    <div class="col-md-3">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" 
                                               name="location" 
                                               id="location"
                                               value="{{ request('location') }}"
                                               placeholder="Filter by location..."
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-filter me-1"></i>Apply Filters
                                        </button>
                                        <a href="{{ route('vocational-training.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-1"></i>Clear Filters
                                        </a>
                                    </div>
                                    <div class="text-muted small">
                                        Showing {{ $vocationalTrainings->count() }} of {{ $vocationalTrainings->total() }} programs
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="card-text mb-1">Total Programs</p>
                                            <h4 class="card-title mb-0">{{ $vocationalTrainings->total() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="card-text mb-1">Active Programs</p>
                                            <h4 class="card-title mb-0">{{ $vocationalTrainings->where('status', 'active')->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-users fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="card-text mb-1">Total Participants</p>
                                            <h4 class="card-title mb-0">{{ $vocationalTrainings->sum('current_participants') }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-graduation-cap fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="card-text mb-1">Completed</p>
                                            <h4 class="card-title mb-0">{{ $vocationalTrainings->where('status', 'completed')->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Training Programs Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">
                                        <i class="fas fa-info-circle me-1"></i>Program Details
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-clock me-1"></i>Type & Duration
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-user-tie me-1"></i>Instructor
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-users me-1"></i>Participants
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-map-marker-alt me-1"></i>Location
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-flag me-1"></i>Status
                                    </th>
                                    <th scope="col">
                                        <i class="fas fa-cogs me-1"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vocationalTrainings as $training)
                                    <tr>
                                        <td>
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $training->program_name }}
                                                </div>
                                                @if($training->start_date)
                                                    <div class="text-muted small">
                                                        Started: {{ $training->start_date->format('M j, Y') }}
                                                    </div>
                                                @endif
                                                @if($training->certification_provided)
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-trophy me-1"></i>Certification
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($training->training_type) }}
                                                </span>
                                            </div>
                                            @if($training->duration_weeks)
                                                <div class="text-muted small">
                                                    {{ $training->duration_weeks }} weeks
                                                </div>
                                            @endif
                                            @if($training->hours_per_week)
                                                <div class="text-muted small">
                                                    {{ $training->hours_per_week }}h/week
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($training->instructor_name)
                                                <div class="fw-bold text-dark">
                                                    {{ $training->instructor_name }}
                                                </div>
                                                @if($training->instructor_phone)
                                                    <div class="text-muted small">
                                                        <i class="fas fa-phone me-1"></i>{{ $training->instructor_phone }}
                                                    </div>
                                                @endif
                                                @if($training->instructor_qualification)
                                                    <div class="text-muted small">
                                                        {{ $training->instructor_qualification }}
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">
                                                {{ $training->current_participants ?? 0 }}/{{ $training->max_participants ?? 'N/A' }}
                                            </div>
                                            @if($training->max_participants && $training->current_participants)
                                                <div class="progress mt-1" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" 
                                                         style="width: {{ min(100, ($training->current_participants / $training->max_participants) * 100) }}%"></div>
                                                </div>
                                                <div class="text-muted small mt-1">
                                                    {{ number_format(($training->current_participants / $training->max_participants) * 100, 1) }}% full
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-dark">{{ $training->location }}</div>
                                            @if($training->district)
                                                <div class="text-muted small">{{ $training->district }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($training->status == 'active') bg-success
                                                @elseif($training->status == 'completed') bg-primary
                                                @elseif($training->status == 'suspended') bg-warning
                                                @elseif($training->status == 'planning') bg-info
                                                @else bg-danger
                                                @endif">
                                                {{ ucfirst($training->status) }}
                                            </span>
                                            @if($training->end_date)
                                                <div class="text-muted small mt-1">
                                                    Ends: {{ $training->end_date->format('M j, Y') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('vocational-training.show', $training) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('vocational-training.edit', $training) }}" 
                                                   class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('vocational-training.destroy', $training) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this training program?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <div class="text-6xl mb-4">📚</div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No training programs found</h3>
                                                <p class="text-gray-500 mb-4">Get started by creating your first vocational training program.</p>
                                                <a href="{{ route('vocational-training.create') }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                    Add New Training Program
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($vocationalTrainings->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $vocationalTrainings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection