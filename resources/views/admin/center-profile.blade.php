@extends('layouts.app')

@section('title', 'Center Profile')

@section('content')
@php
    $summaryFields = $selectedModuleConfig['fields'] ?? [];

    $extractRecordData = function ($record) {
        if (isset($record->form_data) && !empty($record->form_data)) {
            return is_array($record->form_data) ? $record->form_data : (json_decode($record->form_data, true) ?: []);
        }

        return collect($record->getAttributes())
            ->except(['id', 'user_id', 'created_at', 'updated_at'])
            ->toArray();
    };

    $previewKeys = collect(array_keys($summaryFields))->take(4)->all();
@endphp

<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #0f172a, #2563eb); color: #fff;">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-4">
                <div>
                    <span class="badge bg-light text-primary fw-semibold mb-3 px-3 py-2">Center Profile</span>
                    <h2 class="fw-bold mb-2">{{ $centerId }}</h2>
                    <p class="mb-1 text-white-50">Profile ya kituo ikitumia records za users wote wenye Center ID hii.</p>
                    <p class="mb-0 text-white-50">Imefunguliwa kupitia user: {{ $selectedUser->email }}</p>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <a href="{{ route('reports.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i>Open Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">Users in this center</p>
                    <h3 class="fw-bold mb-3">{{ $centerUsers->count() }}</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($centerUsers as $centerUser)
                            <span class="badge rounded-pill text-bg-light border">
                                {{ $centerUser->center_id ?: $centerUser->email }} | {{ ucfirst($centerUser->role) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">Total records</p>
                    <h3 class="fw-bold mb-2">{{ number_format($totalCenterRecords) }}</h3>
                    <p class="mb-0 text-muted">Records zote za category zilizo chini ya center hii kwa kipindi ulichochagua.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <p class="text-muted small text-uppercase fw-semibold mb-2">Selected category</p>
                    <h3 class="fw-bold mb-2">{{ $selectedModuleConfig['title'] }}</h3>
                    <p class="mb-0 text-muted">
                        Count:
                        <strong>{{ number_format($moduleCounts[$selectedModule] ?? 0) }}</strong>
                        | Period:
                        <strong>{{ $periodLabels[$period] ?? 'All Time' }}</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.users.center-profile', $selectedUser) }}" class="row g-3 align-items-end">
                <div class="col-lg-5">
                    <label class="form-label fw-semibold">Choose Data Category</label>
                    <select name="module" class="form-select">
                        @foreach($modules as $moduleKey => $module)
                            <option value="{{ $moduleKey }}" {{ $selectedModule === $moduleKey ? 'selected' : '' }}>
                                {{ $module['title'] }} ({{ $moduleCounts[$moduleKey] ?? 0 }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3">
                    <label class="form-label fw-semibold">Period</label>
                    <select name="period" class="form-select">
                        @foreach($periodLabels as $periodKey => $periodLabel)
                            <option value="{{ $periodKey }}" {{ $period === $periodKey ? 'selected' : '' }}>
                                {{ $periodLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-funnel-fill me-2"></i>Load Center Data
                    </button>
                    <a href="{{ route('reports.run', ['module' => $selectedModule, 'center_id' => $centerId, 'period' => $period]) }}" class="btn btn-success flex-grow-1">
                        <i class="bi bi-play-fill me-2"></i>Run Report
                    </a>
                    <a href="{{ route('reports.print', ['module' => $selectedModule, 'center_id' => $centerId, 'period' => $period]) }}" target="_blank" class="btn btn-outline-dark flex-grow-1">
                        <i class="bi bi-printer me-2"></i>Print
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach($modules as $moduleKey => $module)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('admin.users.center-profile', ['user' => $selectedUser->id, 'module' => $moduleKey, 'period' => $period]) }}"
                   class="card border-0 shadow-sm rounded-4 h-100 text-decoration-none {{ $selectedModule === $moduleKey ? 'border border-primary border-2' : '' }}">
                    <div class="card-body">
                        <p class="small text-uppercase fw-semibold text-muted mb-2">Category</p>
                        <h6 class="text-dark fw-bold mb-3">{{ $module['title'] }}</h6>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-muted">Total</span>
                            <span class="badge rounded-pill {{ $selectedModule === $moduleKey ? 'text-bg-primary' : 'text-bg-light' }}">
                                {{ number_format($moduleCounts[$moduleKey] ?? 0) }}
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h4 class="mb-1">{{ $selectedModuleConfig['title'] }}</h4>
                <p class="mb-0 text-muted">Data za kituo hiki katika category uliyochagua.</p>
            </div>
            <span class="badge text-bg-primary px-3 py-2">{{ $records->total() }} records</span>
        </div>

        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Submitted By</th>
                            @foreach($previewKeys as $previewKey)
                                <th>{{ $summaryFields[$previewKey] ?? \Illuminate\Support\Str::headline(str_replace('_', ' ', $previewKey)) }}</th>
                            @endforeach
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records as $index => $record)
                            @php
                                $recordData = $extractRecordData($record);
                            @endphp
                            <tr>
                                <td>{{ $records->firstItem() + $index }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $record->user->center_id ?? $record->user->email ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $record->user->email ?? 'No email' }}</small>
                                </td>
                                @foreach($previewKeys as $previewKey)
                                    <td>{{ $recordData[$previewKey] ?? 'N/A' }}</td>
                                @endforeach
                                <td>
                                    @if(!empty($record->date))
                                        {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                                    @elseif(!empty($record->submitted_at))
                                        {{ \Carbon\Carbon::parse($record->submitted_at)->format('d M Y H:i') }}
                                    @elseif(!empty($record->created_at))
                                        {{ $record->created_at->format('d M Y H:i') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 4 + count($previewKeys) }}" class="text-center py-5 text-muted">
                                    No {{ strtolower($selectedModuleConfig['title']) }} records were found for this center in the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <div class="pt-3">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
