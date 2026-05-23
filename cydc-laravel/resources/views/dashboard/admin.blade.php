@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="fade-in">
    <!-- Admin Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-danger text-dark rounded-4 p-4 shadow">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2">
                            <i class="bi bi-shield-check me-2"></i>
                            Admin Dashboard
                        </h1>
                        <p class="mb-0 opacity-75">Advanced system management and user control</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="bi bi-gear" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       id="adminSearchInput" 
                                       placeholder="Search all submissions (center names, topics, activities, etc.)..."
                                       autocomplete="off">
                                <button class="btn btn-primary" type="button" id="adminSearchBtn" data-search-url="{{ route('admin.search.ajax') }}">
                                    <i class="bi bi-search me-1"></i>Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">Search across all user submissions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row mb-4" id="searchResults" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>
                        Search Results
                        <span class="badge bg-primary ms-2" id="resultsCount">0</span>
                    </h5>
                </div>
                <div class="card-body" id="searchResultsContent">
                    <!-- Results will be loaded here via Ajax -->
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Users Section -->
    @if($stats['pending_users'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning-subtle">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-warning-emphasis">
                            <i class="bi bi-clock-history me-2"></i>
                            Pending User Approvals
                            <span class="badge bg-warning ms-2">{{ $stats['pending_users'] }}</span>
                        </h5>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-warning">
                             <i class="bi bi-gear me-1"></i>Manage All Users
                         </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($pendingUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Center ID</th>
                                        <th>Cluster</th>
                                        <th>Registered</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingUsers as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="bi bi-person text-warning"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $user->center_id ?? 'No Center ID' }}</div>
                                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $user->center_id ?? 'Not provided' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $user->cluster_name ?? 'Not provided' }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="d-inline">
                                                     @csrf
                                                     @method('PATCH')
                                                     <button type="submit" class="btn btn-sm btn-success" 
                                                             onclick="return confirm('Are you sure you want to approve this user?')">
                                                         <i class="bi bi-check-lg"></i>
                                                     </button>
                                                 </form>
                                                 <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="d-inline">
                                                     @csrf
                                                     @method('PATCH')
                                                     <button type="submit" class="btn btn-sm btn-danger" 
                                                             onclick="return confirm('Are you sure you want to reject this user?')">
                                                         <i class="bi bi-x-lg"></i>
                                                     </button>
                                                 </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($stats['pending_users'] > 10)
                            <div class="text-center mt-3">
                                <p class="text-muted mb-2">Showing 10 of {{ $stats['pending_users'] }} pending users</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                     <i class="bi bi-eye me-1"></i>View All Pending Users
                                 </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                            <h5 class="mt-3 text-muted">No Pending Users</h5>
                            <p class="text-muted">All users have been reviewed and approved or rejected.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Data Management Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-arrow-up"></i> +12%
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['total_users']) }}</h3>
                    <p class="text-muted mb-2">Total Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                    </div>
                    <small class="text-muted mt-1">75% of target reached</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-file-earmark-text text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info-subtle text-info">
                                <i class="bi bi-arrow-up"></i> Active
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['total_submissions']) }}</h3>
                    <p class="text-muted mb-2">Total Submissions</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 85%"></div>
                    </div>
                    <small class="text-muted mt-1">All submissions visible</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-person-plus text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-arrow-up"></i> +8%
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['recent_users']) }}</h3>
                    <p class="text-muted mb-2">New Users (7 days)</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%"></div>
                    </div>
                    <small class="text-muted mt-1">Growing steadily</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-shield-check text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info-subtle text-info">
                                <i class="bi bi-shield"></i> Secure
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['admin_users']) }}</h3>
                    <p class="text-muted mb-2">Admin Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 90%"></div>
                    </div>
                    <small class="text-muted mt-1">System secured</small>
                </div>
            </div>
        </div>
    </div>

    <!-- User Approval Statistics Section -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock-history text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['pending_users']) }}</h3>
                    <p class="text-muted mb-2">Pending Approval</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $stats['pending_users'] > 0 ? min(($stats['pending_users'] / max($stats['total_users'], 1)) * 100, 100) : 0 }}%"></div>
                    </div>
                    <small class="text-muted mt-1">Awaiting review</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-check"></i> Approved
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['approved_users']) }}</h3>
                    <p class="text-muted mb-2">Approved Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $stats['approved_users'] > 0 ? min(($stats['approved_users'] / max($stats['total_users'], 1)) * 100, 100) : 0 }}%"></div>
                    </div>
                    <small class="text-muted mt-1">Active accounts</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-x-circle text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="bi bi-x"></i> Rejected
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['rejected_users']) }}</h3>
                    <p class="text-muted mb-2">Rejected Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $stats['rejected_users'] > 0 ? min(($stats['rejected_users'] / max($stats['total_users'], 1)) * 100, 100) : 0 }}%"></div>
                    </div>
                    <small class="text-muted mt-1">Denied access</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">
                                 <i class="bi bi-gear"></i> Manage
                             </a>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['total_users']) }}</h3>
                    <p class="text-muted mb-2">Total Users</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                    <small class="text-muted mt-1">All registered users</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Talent Statistics Section -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning-subtle text-warning">
                                <i class="bi bi-star"></i> Talents
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['total_talents']) }}</h3>
                    <p class="text-muted mb-2">Total Talents</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 85%"></div>
                    </div>
                    <small class="text-muted mt-1">Talent database growing</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-plus-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success">
                                <i class="bi bi-arrow-up"></i> Recent
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['recent_talents']) }}</h3>
                    <p class="text-muted mb-2">New Talents (7 days)</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 70%"></div>
                    </div>
                    <small class="text-muted mt-1">Recent submissions</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-mortarboard text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info-subtle text-info">
                                <i class="bi bi-book"></i> Training
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['talents_needing_training']) }}</h3>
                    <p class="text-muted mb-2">Need Training</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 55%"></div>
                    </div>
                    <small class="text-muted mt-1">Require development</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-trophy text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger-subtle text-danger">
                                <i class="bi bi-award"></i> Competed
                            </span>
                        </div>
                    </div>
                    <h3 class="h2 mb-1 fw-bold">{{ number_format($stats['talents_with_competitions']) }}</h3>
                    <p class="text-muted mb-2">Have Competed</p>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"></div>
                    </div>
                    <small class="text-muted mt-1">Competition experience</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Categories Overview -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-database text-info me-2"></i>
                        Data Management Categories
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('talent-attendance.index') }}" class="card text-decoration-none border-start border-primary border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-calendar-check text-primary" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Talent Attendance</h6>
                                    <small class="text-muted">View all talent sessions</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('skills-attendance.index') }}" class="card text-decoration-none border-start border-success border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-tools text-success" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Skills Attendance</h6>
                                    <small class="text-muted">View all skills sessions</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('curriculum-attendance.index') }}" class="card text-decoration-none border-start border-info border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Curriculum Data</h6>
                                    <small class="text-muted">View all curriculum records</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('parents-information.index') }}" class="card text-decoration-none border-start border-warning border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-people text-warning" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Parents Information</h6>
                                    <small class="text-muted">View all parent records</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('talents.index') }}" class="card text-decoration-none border-start border-secondary border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-star text-secondary" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Talents Information</h6>
                                    <small class="text-muted">View all talent profiles</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('skills-information.index') }}" class="card text-decoration-none border-start border-danger border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-tools text-danger" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Skills Information</h6>
                                    <small class="text-muted">View all skills data</small>
                                </div>
                            </a>
                        </div>
                      
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('base-leaders.index') }}" class="card text-decoration-none border-start border-primary border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-person-badge text-primary" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Base Leaders</h6>
                                    <small class="text-muted">View all leader records</small>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('center-leadership.index') }}" class="card text-decoration-none border-start border-success border-3 h-100">
                                <div class="card-body text-center p-3">
                                    <i class="bi bi-geo-alt text-success" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 mb-1">Center Leadership</h6>
                                    <small class="text-muted">{{ $stats['total_center_leadership'] }} records</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Submissions Review Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clipboard-check text-info me-2"></i>
                            Recent User Submissions for Review
                        </h5>
                        <span class="badge bg-info">{{ $recentSubmissions->count() }} items</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentSubmissions->count() > 0)
                        <div class="row g-3">
                            @foreach($recentSubmissions as $submission)
                            <div class="col-lg-6">
                                <div class="card border-start border-{{ $submission['color'] }} border-3 h-100">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-{{ $submission['color'] }} bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="{{ $submission['icon'] }} text-{{ $submission['color'] }}"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <span class="badge bg-{{ $submission['color'] }} bg-opacity-10 text-{{ $submission['color'] }}">{{ $submission['type'] }}</span>
                                                    <small style="color: #000000 !important;">{{ $submission['date']->diffForHumans() }}</small>
                                                </div>
                                                <h6 class="mb-1" style="color: #000000 !important;">{{ $submission['title'] }}</h6>
                                                <p class="mb-2 small" style="color: #000000 !important;">Submitted by: {{ $submission['user'] }}</p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route($submission['route'], $submission['id']) }}" class="btn btn-outline-{{ $submission['color'] }} btn-sm">
                                                        <i class="bi bi-eye me-1"></i>View Details
                                                    </a>
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Submitted
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modals removed - no approval process needed -->
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#allSubmissionsModal">
                                <i class="bi bi-list-ul me-2"></i>View All Submissions
                            </button>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard-check text-muted" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mt-3">No Recent Submissions</h5>
                            <p class="text-muted">All user submissions have been reviewed</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-people-fill text-primary me-2"></i>
                            User Management
                        </h5>
                        <div>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="bi bi-person-plus"></i> Add User
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Attendance</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $user->center_id ?? 'No Center ID' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->created_at->diffInDays() <= 7 ? 'success' : 'secondary' }}">
                                            {{ $user->created_at->diffInDays() <= 7 ? 'New' : 'Established' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $user->talent_attendance_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <!-- Replace the status toggle form with a role toggle -->
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editUserModal{{ $user->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning" 
                                                    onclick="toggleUserRole({{ $user->id }})">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-warning">
                                                    <i class="bi bi-{{ $user->status === 'active' ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Edit User Modal -->
                                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User: {{ $user->center_id ?? 'No Center ID' }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Center ID</label>
                                                        <input type="text" class="form-control" name="center_id" value="{{ $user->center_id }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Role</label>
                                                        <select class="form-select" name="role" required>
                                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-select" name="status" required>
                                                            <option value="active" {{ ($user->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="inactive" {{ ($user->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update User</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $allUsers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

   




    <!-- Advanced User Management Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-table text-primary me-2"></i>
                        User Management Dashboard
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm" id="exportBtn">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-plus-lg me-1"></i>Add User
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Advanced Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="tableSearch" placeholder="Search users...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="roleFilter">
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="moderator">Moderator</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control form-control-sm" id="dateFilter">
                        </div>
                        <div class="col-md-3">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="advancedFilters">
                                    <i class="bi bi-funnel"></i> Advanced
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Table -->
                    <div class="table-responsive-custom">
                        <table class="table table-hover align-middle" id="usersTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="center_id">
                                        Center ID <i class="bi bi-arrow-down-up ms-1"></i>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="email">
                                        Email <i class="bi bi-arrow-down-up ms-1"></i>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="role">
                                        Role <i class="bi bi-arrow-down-up ms-1"></i>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="status">
                                        Status <i class="bi bi-arrow-down-up ms-1"></i>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="last_login">
                                        Last Login <i class="bi bi-arrow-down-up ms-1"></i>
                                    </th>
                                    <th scope="col" class="sortable" data-sort="submissions">
                                        Submissions <i class="bi bi-arrow-down-up ms-1"></i>
                                    </th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            
                               
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted small">
                            Showing <strong>1-3</strong> of <strong>47</strong> users
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">...</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">16</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row g-4">
        <!-- Users Needing Attention -->
        <div class="col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                        Users Needing Attention
                    </h5>
                </div>
                <div class="card-body">
                    @if($usersNeedingAttention->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($usersNeedingAttention as $user)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-person-exclamation text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $user->center_id ?? 'No Center ID' }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($user->status === 'inactive')
                                            <span class="badge bg-secondary">Inactive</span>
                                        @elseif($user->created_at > now()->subDays(7))
                                            <span class="badge bg-info">New</span>
                                        @else
                                            <span class="badge bg-warning">No Activity</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">All users are active</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-plus text-primary me-2"></i>
                        Recent Users
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentUsers->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentUsers as $user)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $user->center_id ?? 'No Center ID' }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-person-x text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No recent users</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- System Statistics -->
        <div class="col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bar-chart text-info me-2"></i>
                        System Overview
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <h5 class="text-primary mb-1">{{ $stats['total_instructors'] }}</h5>
                                <small class="text-muted">Instructors</small>
                            </div>
                        </div>
                
                   
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <h5 class="text-info mb-1">{{ $stats['total_skills'] }}</h5>
                                <small class="text-muted">Skills</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- All Submissions Modal -->
<div class="modal fade" id="allSubmissionsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-clipboard-data me-2"></i>
                    All User Submissions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <a href="{{ route('parents-information.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Parents Information</h6>
                                <small class="text-muted">Review parent submissions</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('base-leaders.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-person-badge text-success" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Base Leaders</h6>
                                <small class="text-muted">Review leader applications</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('special-programs.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-star text-warning" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Special Programs</h6>
                                <small class="text-muted">Review program submissions</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin.masomo-ya-mtaala.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-book text-info" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Curriculum Lessons</h6>
                                <small class="text-muted">Review lesson reports</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('curriculum-attendance.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar-check text-secondary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Curriculum Attendance</h6>
                                <small class="text-muted">Review attendance records</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('skills-attendance.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-tools text-danger" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Skills Attendance</h6>
                                <small class="text-muted">Review skills sessions</small>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('skills-information.index') }}" class="card text-decoration-none h-100">
                            <div class="card-body text-center">
                                <i class="bi bi-tools text-info" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">Skills Information</h6>
                                <small class="text-muted">Review skills data</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveSubmission(type, id) {
    if (confirm('Are you sure you want to approve this ' + type + ' submission?')) {
        // Add your approval logic here
        alert('Submission approved! (This would typically update the database)');
    }
}

// Admin Search Functionality
$(document).ready(function() {
    let searchTimeout;
    
    // Search button click
    $('#adminSearchBtn').click(function() {
        performAdminSearch();
    });
    
    // Search on Enter key
    $('#adminSearchInput').keypress(function(e) {
        if (e.which === 13) {
            performAdminSearch();
        }
    });
    
    // Real-time search with debounce
    $('#adminSearchInput').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();
        
        if (query.length === 0) {
            $('#searchResults').hide();
            return;
        }
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(function() {
                performAdminSearch();
            }, 500);
        }
    });
    
    function performAdminSearch() {
        const query = $('#adminSearchInput').val().trim();
        
        if (query.length === 0) {
            $('#searchResults').hide();
            return;
        }
        
        // Show loading state
        $('#searchResults').show();
        $('#searchResultsContent').html('<div class="text-center py-4"><i class="bi bi-hourglass-split"></i> Searching...</div>');
        $('#resultsCount').text('...');
        
        // Perform Ajax search
        $.ajax({
            url: '{{ route("admin.search.ajax") }}',
            method: 'POST',
            data: {
                q: query,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    displayAdminSearchResults(response.results, response.count);
                } else {
                    $('#searchResultsContent').html('<div class="alert alert-warning">Search failed. Please try again.</div>');
                }
            },
            error: function() {
                $('#searchResultsContent').html('<div class="alert alert-danger">An error occurred while searching. Please try again.</div>');
            }
        });
    }
    
    function displayAdminSearchResults(results, count) {
        $('#resultsCount').text(count);
        
        if (count === 0) {
            $('#searchResultsContent').html('<div class="text-center py-4 text-muted"><i class="bi bi-search"></i><br>No results found for your search.</div>');
            return;
        }
        
        let html = '<div class="row g-3">';
        
        results.forEach(function(result) {
            const statusColor = result.status === 'approved' ? 'success' : (result.status === 'rejected' ? 'danger' : 'warning');
            
            html += `
                <div class="col-lg-6">
                    <div class="card border-start border-${statusColor} border-3 h-100">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-${statusColor} bg-opacity-10 text-${statusColor}">${result.type}</span>
                                <small class="text-muted">${result.date}</small>
                            </div>
                            <h6 class="mb-1">${result.title}</h6>
                            <p class="text-muted mb-2 small">Submitted by: ${result.user}</p>
                            <div class="d-flex gap-2">
                                <a href="/${result.route}/${result.id}" class="btn btn-outline-${statusColor} btn-sm">
                                    <i class="bi bi-eye me-1"></i>View
                                </a>
                                <span class="badge bg-${statusColor}">${result.status}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        $('#searchResultsContent').html(html);
    }
});
    
    // Initialize Charts
    initializeAdminCharts();
});

// Chart Initialization Function
function initializeAdminCharts() {
    // Submissions Over Time Chart
    const submissionsCtx = document.getElementById('submissionsChart').getContext('2d');
    new Chart(submissionsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Total Submissions',
                data: [65, 78, 90, 81, 95, 105, 110, 125, 140, 155, 170, 185],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Approved',
                data: [45, 55, 70, 65, 75, 85, 90, 100, 115, 125, 140, 155],
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Status Distribution Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Approved', 'Pending', 'Rejected'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(251, 191, 36)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
    
    // User Activity Bar Chart
    const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
    new Chart(userActivityCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Active Users',
                data: [45, 52, 48, 61, 55, 35, 28],
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Monthly Trends Chart
    const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    new Chart(monthlyTrendsCtx, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Parents Info',
                data: [120, 150, 180, 200],
                backgroundColor: 'rgba(168, 85, 247, 0.8)'
            }, {
                label: 'Center Leadership',
                data: [80, 95, 110, 125],
                backgroundColor: 'rgba(34, 197, 94, 0.8)'
            }, {
                label: 'Special Programs',
                data: [60, 75, 85, 95],
                backgroundColor: 'rgba(251, 191, 36, 0.8)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>
@endsection