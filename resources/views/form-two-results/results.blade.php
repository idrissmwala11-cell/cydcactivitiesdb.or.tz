@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @php
        $isPrimary = $educationLevel === 'primary';
        $classCode = config('form_two_results.class_codes.'.$classLevel, preg_replace('/\D/', '', $classLevel));
        $studentNumberPrefix = ($isPrimary ? 'P' : 'F').$classCode;
    @endphp
    @include('form-two-results._nav')
    @include('form-two-results._alerts')
    <div class="f2-sheet">
        <div class="f2-title d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div><h5>{{ $isPrimary ? 'MUHTASARI WA UFAULU' : 'PERFORMANCE SUMMARY' }}</h5><div class="small opacity-75">{{ $isPrimary ? 'Uchambuzi wa madaraja kwa alama 50 na jinsi kutoka kwenye matokeo yaliyochaguliwa.' : 'Division and gender analysis from the selected result sheet.' }}</div></div>
            <form method="GET" class="f2-no-print d-flex flex-wrap gap-2">
                <select class="form-select" name="education_level" onchange="this.form.querySelector('[name=class_level]').value=''; this.form.querySelector('[name=assessment_id]').value=''; this.form.submit()"><option value="primary" @selected($educationLevel === 'primary')>Msingi</option><option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option></select>
                <select class="form-select" name="class_level" onchange="this.form.querySelector('[name=assessment_id]').value=''; this.form.submit()">@foreach($classOptions[$educationLevel] as $option)<option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>@endforeach</select>
                <select class="form-select" name="assessment_id" onchange="this.form.submit()">@foreach($assessments as $item)<option value="{{ $item->id }}" @selected($assessment?->is($item))>{{ $item->name }}</option>@endforeach</select>
            </form>
        </div>
        <div class="f2-ribbon">{{ $isPrimary ? 'Msingi' : 'Secondary' }} / {{ $classLevel }} - {{ $assessment?->name ?? ($isPrimary ? 'Hakuna mtihani uliowekwa' : 'No assessment configured') }}</div>
        <div class="table-responsive">
            <table class="table table-bordered f2-table mb-0">
                <thead><tr><th>{{ $isPrimary ? 'Kundi' : 'Group' }}</th><th>{{ $isPrimary ? 'Waliosajiliwa' : 'REG' }}</th><th>{{ $isPrimary ? 'Waliofanya' : 'SAT' }}</th><th>{{ $isPrimary ? 'Wasiokuwepo' : 'ABS' }}</th>@if($isPrimary)@foreach(['A','B','C','D','E'] as $grade)<th>DARAJA {{ $grade }}</th>@endforeach @else @foreach(['I','II','III','IV','0','INC'] as $division)<th>DIV {{ $division }}</th>@endforeach @endif<th>{{ $isPrimary ? 'Waliofaulu' : 'PASS' }}</th><th>{{ $isPrimary ? 'Ufaulu %' : 'PASS %' }}</th></tr></thead>
                <tbody>
                    @foreach(['F' => ($isPrimary ? 'Wasichana' : 'Girls'), 'M' => ($isPrimary ? 'Wavulana' : 'Boys'), 'ALL' => ($isPrimary ? 'Jumla' : 'Total')] as $key => $label)
                        @php($group = $groups[$key])
                        <tr><td class="fw-bold">{{ $label }}</td><td>{{ $group['registered'] }}</td><td>{{ $group['sat'] }}</td><td>{{ $group['absent'] }}</td>@if($isPrimary)@foreach(['A','B','C','D','E'] as $grade)<td>{{ $group['grades'][$grade] }}</td>@endforeach @else @foreach(['I','II','III','IV','0','INC'] as $division)<td>{{ $group['divisions'][$division] }}</td>@endforeach @endif<td>{{ $group['passed'] }}</td><td class="fw-bold">{{ number_format($group['pass_rate'], 1) }}%</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="f2-sheet mt-4">
        <div class="f2-title d-flex flex-wrap justify-content-between align-items-center gap-2"><h5>{{ $isPrimary ? 'ORODHA YA MATOKEO' : 'RESULTS LIST' }}</h5>@if($assessment)<a class="btn btn-light f2-no-print" href="{{ route('form-two-results.reports.index', ['education_level' => $educationLevel, 'class_level' => $classLevel, 'assessment_id' => $assessment->id]) }}"><i class="bi bi-printer me-1"></i>{{ $isPrimary ? 'Run Ripoti' : 'Run Reports' }}</a>@endif</div>
        <div class="f2-ribbon">{{ $isPrimary ? 'MATOKEO YA MSINGI' : strtoupper($educationLevel).' / '.strtoupper($classLevel).' RESULTS' }} - {{ strtoupper($classLevel) }}, {{ $assessment?->assessment_date?->format('F Y') ?? '2026' }}</div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover f2-table mb-0">
                <thead><tr><th>Na.</th><th class="sticky-col">{{ $isPrimary ? 'Jina la Mwanafunzi' : "Candidate's Name" }}</th><th>FCP Name</th><th>{{ $isPrimary ? 'Jinsi' : 'Sex' }}</th><th style="min-width:420px">{{ $isPrimary ? 'Maelezo ya Masomo' : 'Subject Details' }}</th><th>{{ $isPrimary ? 'Jumla' : 'Total' }}</th><th>{{ $isPrimary ? 'Wastani' : 'Average' }}</th>@if($isPrimary)<th>Daraja</th>@else<th>Points</th><th>Division</th>@endif<th>{{ $isPrimary ? 'Nafasi' : 'Position' }}</th><th>{{ $isPrimary ? 'Ripoti' : 'Report' }}</th></tr></thead>
                <tbody>
                @forelse($rows as $row)
                    <tr>
                        <td class="text-center text-nowrap">{{ $studentNumberPrefix }}-{{ str_pad((string) $loop->iteration, 3, '0', STR_PAD_LEFT) }}</td><td class="sticky-col fw-bold">{{ $row['student']->candidate_name }}</td><td class="text-nowrap">{{ $row['student']->fcp_name ?: '-' }}</td><td class="text-center">{{ $row['student']->sex }}</td>
                        <td class="small lh-lg">
                            @forelse(collect($row['subjects'])->filter(fn ($item) => $item['mark'] !== null || $item['isAbsent']) as $subjectResult)
                                @php($markText = $subjectResult['isAbsent'] ? 'ABS' : rtrim(rtrim(number_format($subjectResult['mark'], 2, '.', ''), '0'), '.'))
                                <span class="d-inline-block text-nowrap me-2"><strong>{{ $subjectResult['subject']->abbreviation }}</strong> {{ $markText }}-{{ $subjectResult['grade'] }}</span>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                        <td class="text-end">{{ number_format($row['total'], 2) }}</td><td class="text-center">{{ $row['average'] !== null ? number_format($row['average'], 2) : 'ABS' }}</td>
                        @if($isPrimary)<td class="text-center f2-grade-{{ $row['overall_grade'] }}">{{ $row['overall_grade'] ?? 'ABS' }}</td>@else<td class="text-center">{{ $row['points'] ?? '-' }}</td><td class="text-center fw-bold">{{ $row['division'] }}</td>@endif<td class="text-center">{{ $row['rank'] ?? '-' }}</td>
                        <td class="text-center"><a class="btn btn-sm btn-outline-success" href="{{ route('form-two-results.reports.show', [$row['student'], 'assessment_id' => $assessment?->id]) }}"><i class="bi bi-file-earmark-person"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="{{ $isPrimary ? 10 : 11 }}" class="f2-empty">{{ $isPrimary ? 'Hakuna wanafunzi katika jedwali hili la matokeo.' : 'No students are available for this result sheet.' }}</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
