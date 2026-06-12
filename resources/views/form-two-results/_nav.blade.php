@php($scopeQuery = isset($educationLevel, $classLevel) ? ['education_level' => $educationLevel, 'class_level' => $classLevel] : [])
@php($primaryNav = ($educationLevel ?? 'secondary') === 'primary')
<div class="f2-no-print mb-3">
    <ul class="nav nav-pills f2-tabs">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.index') ? 'active' : '' }}" href="{{ route('form-two-results.index', $scopeQuery) }}"><i class="bi bi-house-door me-1"></i>{{ $primaryNav ? 'Mwanzo' : 'Home' }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.subjects.*') ? 'active' : '' }}" href="{{ route('form-two-results.subjects.index', $scopeQuery) }}"><i class="bi bi-journal-text me-1"></i>{{ $primaryNav ? 'Masomo na Misimbo' : 'Subjects & Codes' }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.students.*') ? 'active' : '' }}" href="{{ route('form-two-results.students.index', $scopeQuery) }}"><i class="bi bi-person-lines-fill me-1"></i>{{ $primaryNav ? 'Usajili wa Wanafunzi' : 'Name Entry' }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.assessments.*') ? 'active' : '' }}" href="{{ route('form-two-results.assessments.index', $scopeQuery) }}"><i class="bi bi-calendar3 me-1"></i>{{ $primaryNav ? 'Mitihani' : 'Assessments' }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.marks.*') ? 'active' : '' }}" href="{{ route('form-two-results.marks.index', $scopeQuery) }}"><i class="bi bi-pencil-square me-1"></i>{{ $primaryNav ? 'Uingizaji wa Alama' : 'Marks Entry' }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.results.*') ? 'active' : '' }}" href="{{ route('form-two-results.results.index', $scopeQuery) }}"><i class="bi bi-table me-1"></i>{{ $primaryNav ? 'Matokeo' : 'Results' }}</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('form-two-results.analysis.*') ? 'active' : '' }}" href="{{ route('form-two-results.analysis.index', $scopeQuery) }}"><i class="bi bi-bar-chart-line me-1"></i>{{ $primaryNav ? 'Uchambuzi' : 'Analysis' }}</a></li>
    </ul>
</div>
