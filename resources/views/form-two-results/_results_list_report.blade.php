<style>
    @media print {
        @page { size: A4 landscape; margin: 8mm; }
    }
</style>
<div class="f2-sheet full-results-report">
    <div class="report-head">
        <h5 class="fw-bold mb-1">{{ config('form_two_results.school_name') }}</h5>
        <div class="fw-bold">{{ config('form_two_results.school_subtitle') }}</div>
        <div class="mt-1">{{ $isPrimary ? 'ORODHA KAMILI YA MATOKEO' : 'FULL RESULTS LIST' }}</div>
    </div>
    @isset($groups)
        @include('form-two-results._performance_summary_table')
    @endisset
    <div class="f2-ribbon">
        {{ strtoupper($assessment->name) }} / {{ strtoupper($classLevel) }}
        @if($selectedFcp !== '') - {{ strtoupper($selectedFcp) }} @endif
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0 full-results-table">
            <thead>
                <tr>
                    <th>Na.</th>
                    <th>{{ $isPrimary ? 'Jina la Mwanafunzi' : "Candidate's Name" }}</th>
                    <th>FCP</th>
                    <th>{{ $isPrimary ? 'Jinsi' : 'Sex' }}</th>
                    <th>{{ $isPrimary ? 'Masomo na Alama' : 'Subject Marks' }}</th>
                    <th>{{ $isPrimary ? 'Jumla' : 'Total' }}</th>
                    <th>{{ $isPrimary ? 'Wastani' : 'Average' }}</th>
                    @if($isPrimary)
                        <th>Daraja</th>
                    @else
                        <th>Points</th>
                        <th>Division</th>
                    @endif
                    <th>{{ $isPrimary ? 'Nafasi' : 'Position' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td class="text-nowrap">{{ $row['display_number'] }}</td>
                        <td class="fw-bold">{{ $row['student']->candidate_name }}</td>
                        <td class="text-nowrap">{{ $row['student']->fcp_name ?: '-' }}</td>
                        <td class="text-center">{{ $row['student']->sex }}</td>
                        <td class="subject-marks-cell">
                            @forelse(collect($row['subjects'])->filter(fn ($item) => $item['mark'] !== null || $item['isAbsent']) as $subjectResult)
                                @php($markText = $subjectResult['isAbsent'] ? 'ABS' : rtrim(rtrim(number_format($subjectResult['mark'], 2, '.', ''), '0'), '.'))
                                <span class="d-inline-block text-nowrap me-2"><strong>{{ $subjectResult['subject']->abbreviation }}</strong> {{ $markText }}-{{ $subjectResult['grade'] }}</span>
                            @empty
                                <span>-</span>
                            @endforelse
                        </td>
                        <td class="text-end">{{ number_format($row['total'], 2) }}</td>
                        <td class="text-center">{{ $row['average'] !== null ? number_format($row['average'], 2) : 'ABS' }}</td>
                        @if($isPrimary)
                            <td class="text-center fw-bold f2-grade-{{ $row['overall_grade'] }}">{{ $row['overall_grade'] ?? 'ABS' }}</td>
                        @else
                            <td class="text-center">{{ $row['points'] ?? '-' }}</td>
                            <td class="text-center fw-bold">{{ $row['division'] }}</td>
                        @endif
                        <td class="text-center fw-bold">{{ $row['rank'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
