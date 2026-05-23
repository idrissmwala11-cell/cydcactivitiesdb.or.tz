@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="fade-in">
    <!-- User Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-primary text-dark rounded-4 p-4 shadow">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h3 mb-2">
                            <i class="bi bi-person-circle me-2"></i>
                            Welcome, {{ auth()->user()->center_id ?? 'No Center ID' }}
                        </h1>
                        <p class="mb-0 opacity-75">Your personal dashboard and activities</p>
                    </div>
                    <div class="col-md-4 text-end d-none d-md-block">
                        <i class="bi bi-house-heart" style="font-size: 4rem; opacity: 0.3;"></i>
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

    <!-- User Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="h4 mb-1">{{ number_format($stats['my_attendance']) }}</h3>
                            <p class="text-muted mb-0">My Attendance Records</p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-calendar-check text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="h4 mb-1">{{ number_format($stats['total_programs']) }}</h3>
                            <p class="text-muted mb-0">Available Programs</p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-collection text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card dashboard-card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="h4 mb-1">{{ number_format($stats['available_skills']) }}</h3>
                            <p class="text-muted mb-0">Skills to Learn</p>
                        </div>
                        <div class="col-auto">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-lightbulb text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Entry Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Data Entry Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('talent-attendance.create') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-calendar-plus d-block mb-1"></i>
                                <small>Talent Attendance</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('skills-attendance.create') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-calendar2-plus d-block mb-1"></i>
                                <small>Skills Attendance</small>
                            </a>
                        </div>
                        
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('talents.create') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-star-fill d-block mb-1"></i>
                                <small>Talent Info</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('skills-information.create') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-tools d-block mb-1"></i>
                                <small>Skills Info</small>
                            </a>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('parents-information.create') }}" class="btn btn-outline-dark w-100 py-3">
                                <i class="bi bi-people-fill d-block mb-1"></i>
                                <small>Parents Info</small>
                            </a>
                        </div>
                    </div>
                   
                      
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning w-100 py-3">
                                <i class="bi bi-person-gear d-block mb-1"></i>
                                <small>My Profile</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Recent Activities -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history text-info me-2"></i>
                        My Recent Activities
                    </h5>
                </div>
                <div class="card-body">
                    @if($myRecentAttendance->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Activity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myRecentAttendance as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date }}</td>
                                        <td>{{ $attendance->activity ?? 'Talent Session' }}</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No recent activities found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    let searchTimeout;
    const searchInput = $('#userSearchInput');
    const searchBtn = $('#userSearchBtn');
    const searchResults = $('#userSearchResults');
    const searchResultsContent = $('#userSearchResultsContent');
    const resultsCount = $('#userResultsCount');
    const searchUrl = searchBtn.data('search-url');

    // Search button click handler
    searchBtn.on('click', function() {
        performSearch();
    });

    // Enter key handler
    searchInput.on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            performSearch();
        }
    });

    // Real-time search with debounce
    searchInput.on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val().trim();
        
        if (query.length === 0) {
            searchResults.hide();
            return;
        }
        
        searchTimeout = setTimeout(function() {
            performSearch();
        }, 500);
    });

    function performSearch() {
        const query = searchInput.val().trim();
        
        if (query.length === 0) {
            searchResults.hide();
            return;
        }

        // Show loading state
        searchBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Searching...');
        
        $.ajax({
            url: searchUrl,
            method: 'POST',
            data: {
                q: query,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                displayResults(response);
            },
            error: function(xhr, status, error) {
                console.error('Search error:', error);
                searchResultsContent.html('<div class="alert alert-danger">An error occurred while searching. Please try again.</div>');
                searchResults.show();
            },
            complete: function() {
                searchBtn.prop('disabled', false).html('<i class="bi bi-search me-1"></i>Search');
            }
        });
    }

    function displayResults(response) {
        if (response.results && response.results.length > 0) {
            let html = '';
            response.results.forEach(function(result) {
                html += `
                    <div class="border-bottom pb-3 mb-3">
                        <h6 class="mb-1">
                            <span class="badge bg-secondary me-2">${result.type}</span>
                            ${result.title}
                        </h6>
                        <p class="text-muted mb-1">${result.description}</p>
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>${result.date}
                        </small>
                    </div>
                `;
            });
            searchResultsContent.html(html);
            resultsCount.text(response.results.length);
        } else {
            searchResultsContent.html('<div class="text-center py-4"><i class="bi bi-search text-muted" style="font-size: 3rem;"></i><p class="text-muted mt-2">No results found for your search.</p></div>');
            resultsCount.text('0');
        }
        searchResults.show();
    }
});
</script>
@endsection

@endsection