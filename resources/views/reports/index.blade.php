@extends('layouts.app')

@section('content')
<div class="container py-4">
    @php
        $periodLabels = [
            'all' => 'All Time',
            'week' => 'Last 1 Week',
            'month' => 'Last 1 Month',
            '3months' => 'Last 3 Months',
            '6months' => 'Last 6 Months',
        ];

        $selectedPeriod = request('period', $period ?? 'all');
        $selectedClassLevel = request('class_level', $selectedClassLevel ?? '');
    @endphp

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white">
            <h4 class="mb-0">Center Reports</h4>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="GET" action="{{ route('reports.run') }}" class="row g-3 align-items-end mb-4">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Select Module</label>
                    <select name="module" id="reportModuleSelect" class="form-select" required>
                        <option value="">-- Select Module --</option>
                        @foreach($modules as $key => $type)
                            <option value="{{ $key }}" {{ request('module') == $key ? 'selected' : '' }}>
                                {{ $type['title'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-6" id="centerIdFieldWrapper">
                    <label class="form-label">Center ID</label>

                    @if($user->role === 'admin')
                        <input
                            type="text"
                            name="center_id"
                            id="reportCenterIdInput"
                            class="form-control"
                            placeholder="Example: TZ0350"
                            value="{{ request('center_id') }}"
                            {{ request('module') === 'centers_without_data' ? '' : 'required' }}
                        >
                    @else
                        <input
                            type="text"
                            class="form-control bg-light"
                            value="{{ strtoupper($user->center_id) }}"
                            disabled
                        >
                        <input type="hidden" name="center_id" value="{{ strtoupper($user->center_id) }}">
                    @endif
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Report Period</label>
                    <select name="period" class="form-select">
                        <option value="all" {{ $selectedPeriod == 'all' ? 'selected' : '' }}>All Time</option>
                        <option value="week" {{ $selectedPeriod == 'week' ? 'selected' : '' }}>Last 1 Week</option>
                        <option value="month" {{ $selectedPeriod == 'month' ? 'selected' : '' }}>Last 1 Month</option>
                        <option value="3months" {{ $selectedPeriod == '3months' ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="6months" {{ $selectedPeriod == '6months' ? 'selected' : '' }}>Last 6 Months</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6" id="classLevelFieldWrapper" style="display: none;">
                    <label class="form-label">Class Level</label>
                    <select name="class_level" id="reportClassLevelSelect" class="form-select">
                        <option value="">-- Select Class Level --</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Run Report
                    </button>

                    @if(isset($records))
                        <a
                            href="{{ route('reports.print', [
                                'module' => request('module'),
                                'center_id' => ($isCentersWithoutDataReport ?? false) ? null : ($centerId ?? request('center_id')),
                                'period' => $selectedPeriod,
                                'class_level' => $selectedClassLevel
                            ]) }}"
                            target="_blank"
                            class="btn btn-success w-100"
                        >
                            Print Report
                        </a>
                    @endif
                </div>
            </form>

            @if(isset($records))
                <div class="mb-3">
                    <h5>{{ $moduleTitle }}</h5>
                    <p class="mb-0 text-muted">
                        @if(!($isCentersWithoutDataReport ?? false))
                        Center ID: <strong>{{ $centerId }}</strong> |
                        @endif
                        @if($selectedClassLevel)
                        Class Level: <strong>{{ $selectedClassLevel }}</strong> |
                        @endif
                        Period: <strong>{{ $periodLabels[$selectedPeriod] ?? 'All Time' }}</strong> |
                        Total Records: <strong>{{ $records->count() }}</strong>
                    </p>
                </div>

                <div class="table-responsive">
                    @if($isCentersWithoutDataReport ?? false)
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Center ID</th>
                                    <th>Total Users</th>
                                    <th>First Registered</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($records as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ strtoupper($record->center_id) }}</td>
                                        <td>{{ $record->total_users }}</td>
                                        <td>{{ \Carbon\Carbon::parse($record->first_registered_at)->format('d M Y') }}</td>
                                        <td>No data submitted</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No center IDs found without data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Submitted By</th>
                                <th>Email</th>
                                <th>Center ID</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $index => $record)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $record->user->center_id ?? $record->user->email ?? $record->user->name ?? 'Legacy record' }}</td>
                                    <td>{{ $record->user->email ?? 'N/A' }}</td>
                                    <td>{{ strtoupper($record->user->center_id ?? 'N/A') }}</td>
                                    <td>{{ $record->status ?? 'N/A' }}</td>
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
                                    <td colspan="6" class="text-center text-muted">
                                        No records found for this center and selected period.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const moduleSelect = document.getElementById('reportModuleSelect');
    const centerWrapper = document.getElementById('centerIdFieldWrapper');
    const centerInput = document.getElementById('reportCenterIdInput');
    const classLevelWrapper = document.getElementById('classLevelFieldWrapper');
    const classLevelSelect = document.getElementById('reportClassLevelSelect');
    const examClassLevelOptions = @json($examClassLevelOptions ?? []);
    const selectedClassLevel = @json($selectedClassLevel);

    if (!moduleSelect || !centerWrapper) {
        return;
    }

    function toggleCenterField() {
        const isCentersWithoutData = moduleSelect.value === 'centers_without_data';

        if (isCentersWithoutData) {
            centerWrapper.style.display = 'none';
            if (centerInput) {
                centerInput.removeAttribute('required');
            }
        } else {
            centerWrapper.style.display = '';
            if (centerInput) {
                centerInput.setAttribute('required', 'required');
            }
        }

        const selectedModule = moduleSelect.value;
        const options = examClassLevelOptions[selectedModule] || null;

        if (classLevelWrapper && classLevelSelect) {
            if (options) {
                classLevelWrapper.style.display = '';
                classLevelSelect.innerHTML = '<option value="">-- Select Class Level --</option>';

                options.forEach(function (option) {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;

                    if (option === selectedClassLevel) {
                        optionElement.selected = true;
                    }

                    classLevelSelect.appendChild(optionElement);
                });
            } else {
                classLevelWrapper.style.display = 'none';
                classLevelSelect.innerHTML = '<option value="">-- Select Class Level --</option>';
            }
        }
    }

    moduleSelect.addEventListener('change', toggleCenterField);
    toggleCenterField();
});
</script>
@endsection
