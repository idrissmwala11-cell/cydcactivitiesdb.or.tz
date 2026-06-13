@php($isPrimary = $summary['student']->education_level === 'primary')
<div class="report-page">
    <div class="f2-sheet report-card-sheet">
        <div class="report-head">
            <h5 class="fw-bold mb-1">{{ config('form_two_results.school_name') }}</h5>
            <div class="fw-bold">{{ config('form_two_results.school_subtitle') }}</div>
            <div class="mt-1">TAARIFA YA MAENDELEO YA MWANAFUNZI KWA MZAZI/MLEZI</div>
        </div>
        <div class="f2-ribbon">{{ strtoupper($assessment->name) }}</div>
        <div class="report-meta">
            <div><strong>Jina la Mwanafunzi:</strong> {{ $summary['student']->candidate_name }}</div><div><strong>Namba:</strong> {{ $summary['student']->student_number }}</div>
            <div><strong>Jinsi:</strong> {{ $summary['student']->sex === 'F' ? 'Msichana' : 'Mvulana' }}</div><div><strong>Darasa:</strong> {{ $summary['student']->class_level }}</div>
            <div><strong>FCP:</strong> {{ $summary['student']->fcp_name ?: '-' }}</div><div><strong>Muhula:</strong> {{ $assessment->term }}</div>
        </div>
        <div class="table-responsive"><table class="table table-bordered mb-0"><thead class="table-success"><tr><th>{{ $isPrimary ? 'Msimbo' : 'Code' }}</th><th>Somo</th><th>Alama</th><th>{{ $isPrimary ? 'Daraja' : 'Grade' }}</th><th>Maoni</th></tr></thead><tbody>
            @foreach(collect($summary['subjects'])->filter(fn ($row) => $row['mark'] !== null || $row['isAbsent']) as $row)
                <tr><td>{{ $row['subject']->code }}</td><td>{{ $row['subject']->name }}</td><td class="text-center">{{ $row['isAbsent'] ? 'ABS' : rtrim(rtrim(number_format($row['mark'], 2, '.', ''), '0'), '.') }}</td><td class="text-center f2-grade-{{ $row['grade'] }}">{{ $row['grade'] ?? '-' }}</td><td>{{ match($row['grade']) {'A' => 'Vizuri sana', 'B' => 'Vizuri', 'C' => 'Wastani', 'D' => 'Dhaifu', 'E', 'F' => 'Dhaifu sana', 'ABS' => 'Hakufanya mtihani', default => '-'} }}</td></tr>
            @endforeach
        </tbody></table></div>
        <div class="report-footer">
            <div><strong>Wastani:</strong><div class="fs-4 fw-bold">{{ $summary['average'] !== null ? number_format($summary['average'], 2) : 'ABS' }}</div></div>
            <div><strong>{{ $isPrimary ? 'Daraja la Jumla' : 'Division / Points' }}:</strong><div class="fs-4 fw-bold">{{ $isPrimary ? ($summary['overall_grade'] ?? 'ABS') : $summary['division'].' / '.($summary['points'] ?? '-') }}</div></div>
            <div><strong>Nafasi:</strong><div class="fs-4 fw-bold">{{ $summary['rank'] ? $summary['rank'].' kati ya '.$summary['ranked_count'] : '-' }}</div></div>
        </div>
        <div class="px-3 pb-3"><strong>Maoni:</strong> {{ in_array($summary['overall_grade'], ['A', 'B', 'C', 'D'], true) ? 'Wastani wake unakubalika.' : 'Anatakiwa kuhudhuria darasa rekebishi.' }}</div>
    </div>
</div>
