@props([
    'module',
    'period' => 'all',
    'classLevel' => null,
])

@php
    $user = auth()->user();
    $centerId = strtoupper((string) ($user?->center_id ?? ''));
    $query = array_filter([
        'module' => $module,
        'center_id' => $centerId,
        'period' => $period,
        'class_level' => $classLevel,
    ], fn ($value) => $value !== null && $value !== '');
    $canRunDirectly = $centerId !== '';
@endphp

<div {{ $attributes->merge(['class' => 'd-flex flex-wrap gap-2']) }}>
    @if($canRunDirectly)
        <a href="{{ route('reports.run', $query) }}" class="btn btn-success">
            <i class="bi bi-bar-chart-line me-1"></i>Run Report
        </a>
        <a href="{{ route('reports.print', $query) }}" target="_blank" class="btn btn-outline-dark">
            <i class="bi bi-printer me-1"></i>Print Report
        </a>
    @else
        <a href="{{ route('reports.index') }}" class="btn btn-success">
            <i class="bi bi-bar-chart-line me-1"></i>Open Reports
        </a>
    @endif

    {{ $slot }}
</div>
