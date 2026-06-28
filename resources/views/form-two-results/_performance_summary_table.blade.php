<div class="f2-sheet performance-summary-report mb-4">
    <div class="f2-ribbon">
        {{ $isPrimary ? 'Msingi' : 'Secondary' }} / {{ $classLevel }} - {{ $assessment?->name ?? ($isPrimary ? 'Hakuna mtihani uliowekwa' : 'No assessment configured') }}
    </div>
    <div class="table-responsive">
        <table class="table table-bordered f2-table mb-0 performance-summary-table">
            <thead>
                <tr>
                    <th>{{ $isPrimary ? 'Kundi' : 'Group' }}</th>
                    <th>{{ $isPrimary ? 'Waliosajiliwa' : 'REG' }}</th>
                    <th>{{ $isPrimary ? 'Waliofanya' : 'SAT' }}</th>
                    <th>{{ $isPrimary ? 'Wasiokuwepo' : 'ABS' }}</th>
                    @if($isPrimary)
                        @foreach(['A','B','C','D','E'] as $grade)
                            <th>DARAJA {{ $grade }}</th>
                        @endforeach
                    @else
                        @foreach(['I','II','III','IV','0','INC'] as $division)
                            <th>DIV {{ $division }}</th>
                        @endforeach
                    @endif
                    <th>{{ $isPrimary ? 'Waliofaulu' : 'PASS' }}</th>
                    <th>{{ $isPrimary ? 'Ufaulu %' : 'PASS %' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach(['F' => ($isPrimary ? 'Wasichana' : 'Girls'), 'M' => ($isPrimary ? 'Wavulana' : 'Boys'), 'ALL' => ($isPrimary ? 'Jumla' : 'Total')] as $key => $label)
                    @php($group = $groups[$key])
                    <tr>
                        <td class="fw-bold">{{ $label }}</td>
                        <td>{{ $group['registered'] }}</td>
                        <td>{{ $group['sat'] }}</td>
                        <td>{{ $group['absent'] }}</td>
                        @if($isPrimary)
                            @foreach(['A','B','C','D','E'] as $grade)
                                <td>{{ $group['grades'][$grade] }}</td>
                            @endforeach
                        @else
                            @foreach(['I','II','III','IV','0','INC'] as $division)
                                <td>{{ $group['divisions'][$division] }}</td>
                            @endforeach
                        @endif
                        <td>{{ $group['passed'] }}</td>
                        <td class="fw-bold">{{ number_format($group['pass_rate'], 1) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
