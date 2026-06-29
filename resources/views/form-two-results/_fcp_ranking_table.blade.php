<div class="f2-sheet full-results-report">
    <div class="f2-title">
        <h5>{{ $isPrimary ? 'MPANGILIO WA FCP KWA UFAULU' : 'BEST FCP PERFORMANCE RANKING' }}</h5>
        <div class="small opacity-75">{{ $isPrimary ? 'FCP zimepangwa kuanzia iliyofanya vizuri zaidi hadi ya mwisho.' : 'FCPs are ranked from the best performing to the lowest performing.' }}</div>
    </div>
    <div class="f2-ribbon">
        {{ $isPrimary ? 'Msingi' : 'Secondary' }} / {{ $classLevel }} - {{ $assessment?->name }}
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped f2-table mb-0">
            <thead>
                <tr>
                    <th>{{ $isPrimary ? 'Nafasi' : 'Position' }}</th>
                    <th>FCP</th>
                    <th>{{ $isPrimary ? 'Waliosajiliwa' : 'REG' }}</th>
                    <th>{{ $isPrimary ? 'Waliofanya' : 'SAT' }}</th>
                    <th>{{ $isPrimary ? 'Wasiokuwepo' : 'ABS' }}</th>
                    <th>{{ $isPrimary ? 'Wastani wa FCP' : 'FCP Average' }}</th>
                    <th>{{ $isPrimary ? 'Waliofaulu' : 'PASS' }}</th>
                    <th>{{ $isPrimary ? 'Ufaulu %' : 'PASS %' }}</th>
                    <th>{{ $isPrimary ? 'Nafasi Bora ya Mwanafunzi' : 'Best Student Position' }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fcpRankings as $fcp)
                    <tr>
                        <td class="text-center fw-bold">{{ $fcp['position'] }}</td>
                        <td class="fw-bold">{{ $fcp['fcp_name'] }}</td>
                        <td>{{ $fcp['registered'] }}</td>
                        <td>{{ $fcp['sat'] }}</td>
                        <td>{{ $fcp['absent'] }}</td>
                        <td class="text-center fw-bold">{{ $fcp['average'] !== null ? number_format($fcp['average'], 2) : 'ABS' }}</td>
                        <td>{{ $fcp['passed'] }}</td>
                        <td class="fw-bold">{{ number_format($fcp['pass_rate'], 1) }}%</td>
                        <td class="text-center">{{ $fcp['best_position'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="f2-empty">{{ $isPrimary ? 'Hakuna FCP yenye matokeo.' : 'No FCP results are available.' }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
