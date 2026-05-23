<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CYDC') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Chart.js for Data Visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- jQuery for Enhanced Functionality -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Search Test Script -->
    <script src="{{ asset('js/search-test.js') }}"></script>
</head>
<body>
    @auth
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <i class="bi bi-building"></i>
                <span class="ms-2">CYDC</span>
            </a>
        </div>
        
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-gear"></i>
                        <span>Admin Panel</span>
                    </a>
                </li>
                @endif
                
                <!-- Programs Available to Users -->
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Programs</span>
                    </h6>
                </li>
                
                <!-- Home Visitation -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home-visitation.*') ? 'active' : '' }}" href="{{ route('home-visitation.index') }}">
                        <i class="bi bi-house-door"></i>
                        <span>Home Visitation</span>
                    </a>
                </li>
                
                <!-- Program Day Section -->
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('submissions.*') ? 'active' : '' }}" href="#" onclick="toggleDropdown(this)">
                        <i class="bi bi-calendar-event"></i>
                        <span>Program Day</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <a class="nav-link {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}" href="{{ route('admin.submissions.index') }}">
                                    <i class="bi bi-house me-2"></i>Dashboard
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('submissions.dashboard') ? 'active' : '' }}" href="{{ route('submissions.dashboard') }}">
                                    <i class="bi bi-house me-2"></i>Dashboard
                                </a>
                            @endif
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                 <a class="nav-link {{ request()->routeIs('admin.masomo-ya-mtaala.*') ? 'active' : '' }}" href="{{ route('admin.masomo-ya-mtaala.index') }}">
                                     <i class="bi bi-book me-2"></i>Masomo ya Mtaala
                                 </a>
                             @else
                                <a class="nav-link {{ request()->routeIs('submissions.masomo-ya-mtaala') ? 'active' : '' }}" href="{{ route('submissions.masomo-ya-mtaala') }}">
                                    <i class="bi bi-book me-2"></i>Masomo ya Mtaala
                                </a>
                            @endif
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                 <a class="nav-link {{ request()->routeIs('admin.masomo-ya-fani.*') ? 'active' : '' }}" href="{{ route('admin.masomo-ya-fani.index') }}">
                                     <i class="bi bi-pencil me-2"></i>Fani
                                 </a>
                             @else
                                <a class="nav-link {{ request()->routeIs('submissions.masomo-ya-fani') ? 'active' : '' }}" href="{{ route('submissions.masomo-ya-fani') }}">
                                    <i class="bi bi-pencil me-2"></i>Fani
                                </a>
                            @endif
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <a class="nav-link {{ request()->routeIs('special-programs.index') ? 'active' : '' }}" href="{{ route('special-programs.index') }}">
                                    <i class="bi bi-star me-2"></i>Special Program
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('submissions.special-program') ? 'active' : '' }}" href="{{ route('submissions.special-program') }}">
                                    <i class="bi bi-star me-2"></i>Special Program
                                </a>
                            @endif
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('parents-information.*') ? 'active' : '' }}" href="{{ route('parents-information.index') }}">
                                <i class="bi bi-people me-2"></i>Parents
                            </a>
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <a class="nav-link {{ request()->routeIs('saving-groups.index') ? 'active' : '' }}" href="{{ route('saving-groups.index') }}">
                                    <i class="bi bi-piggy-bank me-2"></i>Vikoba
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('submissions.create') && request()->get('section') == 'vikoba' ? 'active' : '' }}" href="{{ route('submissions.create', ['section' => 'vikoba']) }}">
                                    <i class="bi bi-piggy-bank me-2"></i>Vikoba
                                </a>
                            @endif
                        </li>
                    </ul>
                </li>
                
                <!-- Attendance Section -->
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('*-attendance.*') ? 'active' : '' }}" href="#" onclick="toggleDropdown(this)">
                        <i class="bi bi-calendar-check"></i>
                        <span>Attendance</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                                <i class="bi bi-tools me-2"></i>Skills Class
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                                <i class="bi bi-journal-check me-2"></i>Curriculum Class
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                                <i class="bi bi-star me-2"></i>Talent's Class
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- School Information Section -->
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('school-info.*') ? 'active' : '' }}" href="#" onclick="toggleDropdown(this)">
                        <i class="bi bi-building"></i>
                        <span>School Information</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                 <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_primary' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_primary']) }}">
                                     <i class="bi bi-mortarboard me-2"></i>Primary
                                 </a>
                             @else
                                 <a class="nav-link {{ request()->routeIs('school-info.primary') ? 'active' : '' }}" href="{{ route('school-info.primary') }}">
                                     <i class="bi bi-mortarboard me-2"></i>Primary
                                 </a>
                             @endif
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                 <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_secondary' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_secondary']) }}">
                                     <i class="bi bi-book me-2"></i>Secondary
                                 </a>
                             @else
                                 <a class="nav-link {{ request()->routeIs('school-info.secondary') ? 'active' : '' }}" href="{{ route('school-info.secondary') }}">
                                     <i class="bi bi-book me-2"></i>Secondary
                                 </a>
                             @endif
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                 <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_a_level' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_a_level']) }}">
                                     <i class="bi bi-bank me-2"></i>A Level
                                 </a>
                             @else
                                 <a class="nav-link {{ request()->routeIs('school-info.a-level') ? 'active' : '' }}" href="{{ route('school-info.a-level') }}">
                                     <i class="bi bi-bank me-2"></i>A Level
                                 </a>
                             @endif
                        </li>
                        <li class="nav-item">
                            @if(Auth::user() && Auth::user()->isAdmin())
                                 <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_university' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_university']) }}">
                                     <i class="bi bi-mortarboard-fill me-2"></i>University
                                 </a>
                             @else
                                 <a class="nav-link {{ request()->routeIs('school-info.university') ? 'active' : '' }}" href="{{ route('school-info.university') }}">
                                     <i class="bi bi-mortarboard-fill me-2"></i>University
                                 </a>
                             @endif
                        </li>
                        <li class="nav-item">
                            @if(auth()->user() && auth()->user()->isAdmin())
                                <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_college' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_college']) }}">
                                    <i class="bi bi-award me-2"></i>College
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('school-info.college') ? 'active' : '' }}" href="{{ route('school-info.college') }}">
                                    <i class="bi bi-award me-2"></i>College
                                </a>
                            @endif
                        </li>
                        <li class="nav-item">
                            @if(auth()->user() && auth()->user()->isAdmin())
                                <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_vocational_training' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_vocational_training']) }}">
                                    <i class="bi bi-tools me-2"></i>Vocational Training
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('school-info.vocational-training') ? 'active' : '' }}" href="{{ route('school-info.vocational-training') }}">
                                    <i class="bi bi-tools me-2"></i>Vocational Training
                                </a>
                            @endif
                        </li>
                        <li class="nav-item">
                            @if(auth()->user() && auth()->user()->isAdmin())
                                <a class="nav-link {{ request()->routeIs('admin.submissions.*') && request()->get('section') == 'school_others' ? 'active' : '' }}" href="{{ route('admin.submissions.index', ['section' => 'school_others']) }}">
                                    <i class="bi bi-three-dots me-2"></i>Others
                                </a>
                            @else
                                <a class="nav-link {{ request()->routeIs('school-info.others') ? 'active' : '' }}" href="{{ route('school-info.others') }}">
                                    <i class="bi bi-three-dots me-2"></i>Others
                                </a>
                            @endif
                        </li>
                    </ul>
                </li>
                
                <!-- Leadership Information Section -->
                <li class="nav-item dropdown-nav">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('leadership.*') ? 'active' : '' }}" href="#" onclick="toggleDropdown(this)">
                        <i class="bi bi-people-fill"></i>
                        <span>Leadership Information</span>
                        <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('center-leadership.*') ? 'active' : '' }}" href="{{ route('center-leadership.index') }}">
                                <i class="bi bi-geo-alt me-2"></i>Center
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cluster-leadership.*') ? 'active' : '' }}" href="{{ route('cluster-leadership.index') }}">
                                <i class="bi bi-diagram-3 me-2"></i>Cluster
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('base-leaders.*') ? 'active' : '' }}" href="{{ route('base-leaders.index') }}">
                                <i class="bi bi-house me-2"></i>Base
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('national-leadership.*') ? 'active' : '' }}" href="{{ route('national-leadership.index') }}">
                                <i class="bi bi-flag me-2"></i>National
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('out-of-ministry-leadership.*') ? 'active' : '' }}" href="{{ route('out-of-ministry-leadership.index') }}">
                                <i class="bi bi-building me-2"></i>Out of CY Ministry
                            </a>
                        </li>
                    </ul>
                </li>
                
                
                <!-- User Data Entry Section -->
                @if(auth()->user()->role !== 'admin')
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Data Entry</span>
                    </h6>
                </li>
                
                <!-- Attendance Entry -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>Talent Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                        <i class="bi bi-calendar2-check"></i>
                        <span>Skills Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                        <i class="bi bi-journal-check"></i>
                        <span>Curriculum Attendance</span>
                    </a>
                </li>
                
                <!-- Information Entry -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('talents.*') ? 'active' : '' }}" href="{{ route('talents.index') }}">
                        <i class="bi bi-star"></i>
                        <span>Talents Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skills-information.*') ? 'active' : '' }}" href="{{ route('skills-information.index') }}">
                        <i class="bi bi-tools"></i>
                        <span>Skills Information</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('parents-information.*') ? 'active' : '' }}" href="{{ route('parents-information.index') }}">
                        <i class="bi bi-people me-2"></i>Parents
                    </a>
                </li>
               
                @endif
                
                <!-- Community Features -->
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Community</span>
                    </h6>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('saving-groups.index') ? 'active' : '' }}" href="{{ route('saving-groups.index') }}">
                        <i class="bi bi-piggy-bank"></i>
                        <span>Saving Groups</span>
                    </a>
                </li>
                
                @if(auth()->user()->role !== 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('group-members.*') ? 'active' : '' }}" href="{{ route('group-members.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Group Members</span>
                    </a>
                </li>
                @endif
                
                <!-- Admin Data Management Sections -->
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Data Management</span>
                    </h6>
                </li>
                
                <!-- View All Submitted Data -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}" href="{{ route('admin.submissions.index') }}">
                        <i class="bi bi-calendar-event"></i>
                        <span>Manage Submissions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                        <i class="bi bi-calendar-check"></i>
                        <span>All Talent Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                        <i class="bi bi-calendar2-check"></i>
                        <span>All Skills Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                        <i class="bi bi-journal-check"></i>
                        <span>All Curriculum Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('talents.*') ? 'active' : '' }}" href="{{ route('talents.index') }}">
                        <i class="bi bi-star"></i>
                        <span>All Talents Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skills-information.*') ? 'active' : '' }}" href="{{ route('skills-information.index') }}">
                        <i class="bi bi-tools"></i>
                        <span>All Skills Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('parents-information.*') ? 'active' : '' }}" href="{{ route('parents-information.index') }}">
                        <i class="bi bi-people"></i>
                        <span>All Parents Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.masomo-ya-mtaala.*') ? 'active' : '' }}" href="{{ route('admin.masomo-ya-mtaala.index') }}">
                        <i class="bi bi-book"></i>
                        <span>All Masomo Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('group-members.*') ? 'active' : '' }}" href="{{ route('group-members.index') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>All Group Members</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('base-leaders.*') ? 'active' : '' }}" href="{{ route('base-leaders.index') }}">
                        <i class="bi bi-person-badge"></i>
                        <span>All Base Leaders</span>
                    </a>
                </li>
                
                <!-- System Management -->
                <li class="nav-item">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>System Management</span>
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('programs.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#programsCollapse" role="button" aria-expanded="{{ request()->routeIs('programs.*') ? 'true' : 'false' }}" aria-controls="programsCollapse">
                        <i class="bi bi-collection"></i>
                        <span>Programs</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('programs.*') ? 'show' : '' }}" id="programsCollapse">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('programs.index') ? 'active' : '' }}" href="{{ route('programs.index') }}">
                                    <i class="bi bi-list me-2"></i>All Programs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('programs.create') ? 'active' : '' }}" href="{{ route('programs.create') }}">
                                    <i class="bi bi-plus-circle me-2"></i>Create Program
                                </a>
                            </li>
                            <!-- Note: These program management features are not yet implemented -->
                            <!--
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="alert('This feature is coming soon!')">
                                    <i class="bi bi-eye me-2"></i>View Programs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="alert('This feature is coming soon!')">
                                    <i class="bi bi-pencil me-2"></i>Manage Programs
                                </a>
                            </li>
                            -->
                            
                            <!-- Attendance Section -->
                            <li class="nav-item mt-2">
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted" style="font-size: 0.75rem;">
                                    <span>Attendance</span>
                                </h6>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('skills-attendance.*') ? 'active' : '' }}" href="{{ route('skills-attendance.index') }}">
                                    <i class="bi bi-tools me-2"></i>Skills Class
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('curriculum-attendance.*') ? 'active' : '' }}" href="{{ route('curriculum-attendance.index') }}">
                                    <i class="bi bi-journal-check me-2"></i>Curriculum Class
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('talent-attendance.*') ? 'active' : '' }}" href="{{ route('talent-attendance.index') }}">
                                    <i class="bi bi-star me-2"></i>Talent's Class
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('venues.*') ? 'active' : '' }}" href="{{ route('venues.index') }}">
                        <i class="bi bi-geo-alt"></i>
                        <span>Venues</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sessions.*') ? 'active' : '' }}" href="{{ route('sessions.index') }}">
                        <i class="bi bi-calendar-event"></i>
                        <span>Sessions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('skills.*') ? 'active' : '' }}" href="{{ route('skills.index') }}">
                        <i class="bi bi-tools"></i>
                        <span>Skills</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('evaluations.*') ? 'active' : '' }}" href="{{ route('evaluations.index') }}">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Evaluations</span>
                    </a>
                </li>
                @endif
                
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Top Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
            <div class="container-fluid">
                <button class="btn btn-link d-md-none" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <i class="bi bi-person text-white"></i>
                            </div>
                            <span>{{ auth()->user()->center_id ?? 'No Center ID' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#" onclick="alert('Settings feature is coming soon!')"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            {{-- Support both Blade sections and component slots --}}
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </div>
    @else
    <!-- Guest Layout -->
    <div class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
        {{-- Support component slots for guest views as well --}}
        {{ $slot ?? '' }}
        @yield('content')
    </div>
    @endauth
    
    <script>
        // Enhanced dropdown toggle functionality with accessibility
        function toggleDropdown(element) {
            event.preventDefault();
            
            const dropdownMenu = element.nextElementSibling;
            const isCurrentlyOpen = dropdownMenu.classList.contains('show');
            
            // Close all other dropdowns with smooth animation
            document.querySelectorAll('.sidebar .dropdown-menu.show').forEach(function(menu) {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('show');
                    // Reset animation for menu items
                    menu.querySelectorAll('.nav-item').forEach(function(item, index) {
                        item.style.animation = 'none';
                        setTimeout(() => {
                            item.style.animation = '';
                        }, 50);
                    });
                }
            });
            
            document.querySelectorAll('.sidebar .dropdown-toggle.active').forEach(function(toggle) {
                if (toggle !== element) {
                    toggle.classList.remove('active');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Toggle current dropdown with enhanced animation
            if (!isCurrentlyOpen) {
                dropdownMenu.classList.add('show');
                element.classList.add('active');
                element.setAttribute('aria-expanded', 'true');
                
                // Trigger staggered animation for menu items
                setTimeout(() => {
                    dropdownMenu.querySelectorAll('.nav-item').forEach(function(item, index) {
                        item.style.animationDelay = `${0.1 + (index * 0.05)}s`;
                    });
                }, 10);
            } else {
                dropdownMenu.classList.remove('show');
                element.classList.remove('active');
                element.setAttribute('aria-expanded', 'false');
            }
        }
        
        // Initialize dropdown accessibility attributes
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.sidebar .dropdown-toggle').forEach(function(toggle) {
                toggle.setAttribute('role', 'button');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('tabindex', '0');
                
                // Add keyboard support
                toggle.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleDropdown(this);
                    }
                });
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown-nav')) {
                    document.querySelectorAll('.sidebar .dropdown-menu.show').forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                    document.querySelectorAll('.sidebar .dropdown-toggle.active').forEach(function(toggle) {
                        toggle.classList.remove('active');
                        toggle.setAttribute('aria-expanded', 'false');
                    });
                }
            });
        });
        
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
            
            // Debug Bootstrap collapse functionality
            console.log('Bootstrap loaded:', typeof window.bootstrap !== 'undefined');
            
            // Ensure Bootstrap collapse works for accordion items
            const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
            collapseElements.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        if (window.bootstrap && window.bootstrap.Collapse) {
                            const collapse = new window.bootstrap.Collapse(target, {
                                toggle: true
                            });
                        } else {
                            // Fallback if Bootstrap JS isn't loaded
                            target.classList.toggle('show');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
