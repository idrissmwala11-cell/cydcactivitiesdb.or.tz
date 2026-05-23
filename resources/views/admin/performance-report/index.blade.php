@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

                <div>
                    <h1 class="fw-bold mb-1" style="font-size: 2.3rem; letter-spacing: -0.5px;">
                        📊 Center Performance Report
                    </h1>
                    <p class="text-muted mb-2 fw-semibold" style="font-size: 1.15rem;">
                        All modules grouped by center ID
                    </p>

                    <small class="text-secondary fw-semibold" style="font-size: 1rem;">
                        Period: <strong class="text-primary fw-bold">{{ $periodLabel }}</strong> |
                        From: <strong class="fw-bold">{{ $startDate->format('d M Y') }}</strong> |
                        To: <strong class="fw-bold">{{ $endDate->format('d M Y') }}</strong>
                    </small>

                    <div class="mt-3 d-flex flex-wrap gap-2">
                        <button type="button" onclick="downloadSection('page1','summary-page.jpg')" class="btn btn-success fw-bold px-4">
                            📸 Save Summary
                        </button>

                        <button type="button" onclick="downloadSection('page2','table-page.jpg')" class="btn btn-dark fw-bold px-4">
                            📸 Save Table
                        </button>
                    </div>
                </div>

                <!-- FILTER -->
                <form action="{{ route('admin.performance-report.generate') }}" method="POST" class="d-flex gap-2 flex-wrap">
                    @csrf
                    <select name="period" class="form-select shadow-sm rounded-3 fw-semibold" style="min-width: 220px; font-size: 1.05rem;">
                        <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>📅 Weekly</option>
                        <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>📆 Monthly</option>
                        <option value="bimonthly" {{ $period === 'bimonthly' ? 'selected' : '' }}>🔥 Last 2 Months</option>
                    </select>

                    <button type="submit" class="btn btn-primary shadow-sm rounded-3 px-4 fw-bold">
                        Run Report
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- PAGE 1 : SUMMARY ONLY -->
    <div id="page1" class="capture-section bg-white rounded-4 p-4">

        <!-- EXPORT TITLE -->
        <div class="mb-4">
            <h1 class="fw-bold mb-1" style="font-size: 2.4rem; letter-spacing: -0.5px;">
                Center Performance Report
            </h1>
            <p class="text-muted mb-2 fw-semibold" style="font-size: 1.15rem;">
                All modules grouped by center ID
            </p>
            <small class="text-secondary fw-semibold" style="font-size: 1rem;">
                Period: <strong class="text-primary fw-bold">{{ $periodLabel }}</strong> |
                From: <strong class="fw-bold">{{ $startDate->format('d M Y') }}</strong> |
                To: <strong class="fw-bold">{{ $endDate->format('d M Y') }}</strong>
            </small>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-4">
                        <div class="text-muted fw-semibold mb-2" style="font-size: 1.05rem;">Total Centers</div>
                        <div class="fw-bold text-dark" style="font-size: 3rem; line-height: 1;">{{ $summary['total_centers'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-4">
                        <div class="text-muted fw-semibold mb-2" style="font-size: 1.05rem;">Active Centers</div>
                        <div class="fw-bold text-success" style="font-size: 3rem; line-height: 1;">{{ $summary['active_centers'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-4">
                        <div class="text-muted fw-semibold mb-2" style="font-size: 1.05rem;">Inactive Centers</div>
                        <div class="fw-bold text-danger" style="font-size: 3rem; line-height: 1;">{{ $summary['inactive_centers'] }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body py-4">
                        <div class="text-muted fw-semibold mb-2" style="font-size: 1.05rem;">Top Center</div>
                        <div class="fw-bold text-primary mb-1" style="font-size: 2.4rem; line-height: 1.1;">{{ $summary['top_center_id'] }}</div>
                        <div class="fw-semibold text-dark" style="font-size: 1.1rem;">{{ $summary['top_center_records'] }} records</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRAPH -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h3 class="fw-bold mb-1" style="font-size: 2rem;">📈 Performance Graph</h3>
                <p class="text-muted mb-0 fw-semibold" style="font-size: 1.1rem;">
                    Center ranking by percentage performance
                </p>
            </div>

            <div class="card-body p-4">
                @if($reportData->count() > 0)
                    <div id="performanceChart"></div>
                @else
                    <div class="text-center text-muted py-5 fw-semibold">No data found.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- PAGE 2 : TABLE ONLY -->
    <div id="page2" class="capture-section bg-white rounded-4 p-4 mt-4">

        <div class="mb-4">
            <h1 class="fw-bold mb-1" style="font-size: 2.2rem;">Center Ranking Table</h1>
            <p class="text-muted mb-2 fw-semibold" style="font-size: 1.1rem;">Detailed table export</p>
            <small class="text-secondary fw-semibold" style="font-size: 1rem;">
                Period: <strong class="text-primary fw-bold">{{ $periodLabel }}</strong> |
                From: <strong class="fw-bold">{{ $startDate->format('d M Y') }}</strong> |
                To: <strong class="fw-bold">{{ $endDate->format('d M Y') }}</strong>
            </small>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h4 class="fw-bold mb-1">🏆 Center Ranking Table</h4>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="px-4 py-3 fw-bold">Rank</th>
                            <th class="px-4 py-3 fw-bold">Center ID</th>
                            <th class="px-4 py-3 fw-bold">Users</th>
                            <th class="px-4 py-3 fw-bold">Records</th>
                            <th class="px-4 py-3 fw-bold">Performance %</th>
                            <th class="px-4 py-3 fw-bold">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($reportData as $item)
                            <tr>
                                <td class="px-4 py-3 fw-bold text-primary">#{{ $item['rank'] }}</td>
                                <td class="px-4 py-3 fw-bold">{{ $item['center_id'] }}</td>
                                <td class="px-4 py-3 fw-semibold">{{ $item['total_users'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-primary fs-6 px-3 py-2">{{ $item['total_records'] }}</span>
                                </td>
                                <td class="px-4 py-3 fw-bold">{{ number_format($item['percentage'], 2) }}%</td>
                                <td class="px-4 py-3">
                                    @if($item['status'] === 'Active')
                                        <span class="badge bg-success fs-6 px-3 py-2">Active</span>
                                    @else
                                        <span class="badge bg-danger fs-6 px-3 py-2">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted fw-semibold">No data available.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@if($reportData->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartLabels = @json($reportData->pluck('center_id')->values());
    const chartSeries = @json($reportData->pluck('percentage')->values());
    const chartRecords = @json($reportData->pluck('total_records')->values());

    const options = {
        chart: {
            type: 'bar',
            height: Math.max(500, chartLabels.length * 60),
            toolbar: { show: true }
        },
        series: [{
            name: 'Performance %',
            data: chartSeries
        }],
        xaxis: {
            categories: chartLabels,
            min: 0,
            max: 100,
            labels: {
                style: {
                    fontSize: '14px',
                    fontWeight: 700
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    fontSize: '15px',
                    fontWeight: 700
                }
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                borderRadius: 8,
                barHeight: '68%',
                dataLabels: {
                    position: 'center'
                }
            }
        },
        colors: ['#635BFF'],
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '15px',
                fontWeight: 'bold',
                colors: ['#ffffff']
            },
            formatter: function (val, opts) {
                const records = chartRecords[opts.dataPointIndex] ?? 0;
                return val + '% (' + records + ')';
            }
        },
        grid: {
            borderColor: '#e5e7eb'
        }
    };

    new ApexCharts(document.querySelector("#performanceChart"), options).render();
});
</script>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
async function downloadSection(id, filename) {
    const element = document.getElementById(id);

    const canvas = await html2canvas(element, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff',
        scrollX: 0,
        scrollY: 0,
        width: element.scrollWidth,
        height: element.scrollHeight,
        windowWidth: element.scrollWidth,
        windowHeight: element.scrollHeight
    });

    const link = document.createElement('a');
    link.download = filename;
    link.href = canvas.toDataURL('image/jpeg', 1.0);
    link.click();
}
</script>

@endsection