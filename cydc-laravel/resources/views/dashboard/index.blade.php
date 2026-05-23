@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-primary text-dark rounded-4 p-4 shadow">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2">Welcome back, {{ auth()->user()->center_id ?? 'No Center ID' }}! 👋</h1>
                        <p class="mb-0 opacity-75">Here's what's happening at CYDC today</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="bi bi-speedometer2" style="font-size: 4rem; opacity: 0.3;"></i>
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
                                       id="userSearchInput" 
                                       placeholder="Search your submissions (topics, activities, names, etc.)..."
                                       autocomplete="off">
                                <button class="btn btn-primary" type="button" id="userSearchBtn" data-search-url="{{ route('user.search.ajax') }}">
                                    <i class="bi bi-search me-1"></i>Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">Search only your submissions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row mb-4" id="userSearchResults" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-search me-2"></i>
                        Your Search Results
                        <span class="badge bg-primary ms-2" id="userResultsCount">0</span>
                    </h5>
                </div>
                <div class="card-body" id="userSearchResultsContent">
                    <!-- Results will be loaded here via Ajax -->
                </div>
            </div>
        </div>
    </div>

   

    <!-- Personal Analytics & Progress Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up text-primary me-2"></i>
                        Your Progress & Analytics
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Personal Progress Chart -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-trophy me-2"></i>
                                        Your Activity Progress
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="userProgressChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Achievement Badges -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-award me-2"></i>
                                        Achievements
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-check-circle text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">First Submission</h6>
                                                <small class="text-muted">Completed</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-star text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Active Participant</h6>
                                                <small class="text-muted">5+ submissions</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-lightning text-warning"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Quick Responder</h6>
                                                <small class="text-muted">In progress</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-4 mt-2">
                        <!-- Activity Timeline -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-clock-history me-2"></i>
                                        Recent Activity
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="activityTimelineChart" height="120"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Completion Status -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bi bi-pie-chart me-2"></i>
                                        Completion Status
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="completionStatusChart" height="120"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning-charge text-primary me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('talent-attendance.create') }}" class="btn btn-gradient w-100 py-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Add Attendance
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('participants.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-person-plus me-2"></i>
                                New Participant
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('sessions.create') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-calendar-plus me-2"></i>
                                Schedule Session
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('reports.index') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                View Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row g-4">
        <!-- Recent Attendance -->
        <div class="col-lg-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check text-success me-2"></i>
                        Recent Attendance
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentAttendance->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentAttendance as $attendance)
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            {{ $attendance->lesson_topic ?? $attendance->talent_taught ?? 'Attendance Record' }}
                                        </h6>
                                        <p class="text-muted mb-0 small">
                                            Instructor: {{ $attendance->instructor_name ?? 'N/A' }} •
                                            {{ $attendance->date ? $attendance->date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    <span class="badge bg-success">Present</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('talent-attendance.index') }}" class="btn btn-sm btn-outline-primary">
                                View All Attendance
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No recent attendance records</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Sessions -->
        <div class="col-lg-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-event text-info me-2"></i>
                        Recent Sessions
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentSessions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentSessions as $session)
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="bi bi-calendar-event text-info"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $session->program->name ?? 'N/A' }}</h6>
                                        <p class="text-muted mb-0 small">
                                            Venue: {{ $session->venue->name ?? 'N/A' }} • 
                                            {{ $session->date ? $session->date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                    <span class="badge bg-info">{{ $session->time ?? 'N/A' }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('sessions.index') }}" class="btn btn-sm btn-outline-primary">
                                View All Sessions
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No recent sessions</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// User Search Functionality
$(document).ready(function() {
    let searchTimeout;
    
    // Search button click
    $('#userSearchBtn').click(function() {
        performUserSearch();
    });
    
    // Search on Enter key
    $('#userSearchInput').keypress(function(e) {
        if (e.which === 13) {
            performUserSearch();
        }
    });
    
    // Real-time search with debounce
    $('#userSearchInput').on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();
        
        if (query.length === 0) {
            $('#userSearchResults').hide();
            return;
        }
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(function() {
                performUserSearch();
            }, 500);
        }
    });
    
    function performUserSearch() {
        const query = $('#userSearchInput').val().trim();
        
        if (query.length === 0) {
            $('#userSearchResults').hide();
            return;
        }
        
        // Show loading state
        $('#userSearchResults').show();
        $('#userSearchResultsContent').html('<div class="text-center py-4"><i class="bi bi-hourglass-split"></i> Searching your submissions...</div>');
        $('#userResultsCount').text('...');
        
        // Perform Ajax search
        $.ajax({
            url: '{{ route("user.search.ajax") }}',
            method: 'POST',
            data: {
                q: query,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    displayUserSearchResults(response.results, response.count);
                } else {
                    $('#userSearchResultsContent').html('<div class="alert alert-warning">Search failed. Please try again.</div>');
                }
            },
            error: function() {
                $('#userSearchResultsContent').html('<div class="alert alert-danger">An error occurred while searching. Please try again.</div>');
            }
        });
    }
    
    function displayUserSearchResults(results, count) {
        $('#userResultsCount').text(count);
        
        if (count === 0) {
            $('#userSearchResultsContent').html('<div class="text-center py-4 text-muted"><i class="bi bi-search"></i><br>No results found in your submissions.</div>');
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
        $('#userSearchResultsContent').html(html);
    }});
    
    // Initialize User Charts
    initializeUserCharts();
});

// User Chart Initialization Function
function initializeUserCharts() {
    // User Progress Chart
    const userProgressCtx = document.getElementById('userProgressChart').getContext('2d');
    new Chart(userProgressCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
            datasets: [{
                label: 'Your Submissions',
                data: [2, 5, 3, 8, 6, 10],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
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
    
    // Activity Timeline Chart
    const activityTimelineCtx = document.getElementById('activityTimelineChart').getContext('2d');
    new Chart(activityTimelineCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Activities',
                data: [3, 2, 4, 1, 5, 2, 1],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(245, 101, 101, 0.8)'
                ],
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
    
    // Completion Status Doughnut Chart
    const completionStatusCtx = document.getElementById('completionStatusChart').getContext('2d');
    new Chart(completionStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Pending'],
            datasets: [{
                data: [70, 20, 10],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(251, 191, 36)'
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
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}
</script>
@endsection