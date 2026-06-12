@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @php($isPrimary = $educationLevel === 'primary')
    @include('form-two-results._nav')
    <div class="f2-sheet mb-4">
        <div class="f2-title d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div><h5>{{ $isPrimary ? 'MUHTASARI WA UFAULU' : 'PERFORMANCE SUMMARY' }}</h5><div class="small opacity-75">{{ $isPrimary ? 'Uchambuzi wa madaraja na jinsi kutoka kwenye matokeo yaliyochaguliwa.' : 'Division and gender analysis from the selected result sheet.' }}</div></div>
            <form method="GET" class="f2-no-print d-flex flex-wrap gap-2">
                <select class="form-select" name="education_level" onchange="this.form.querySelector('[name=class_level]').value=''; this.form.querySelector('[name=assessment_id]').value=''; this.form.submit()"><option value="primary" @selected($educationLevel === 'primary')>Msingi</option><option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option></select>
                <select class="form-select" name="class_level" onchange="this.form.querySelector('[name=assessment_id]').value=''; this.form.submit()">@foreach($classOptions[$educationLevel] as $option)<option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>@endforeach</select>
                <select class="form-select" name="assessment_id" onchange="this.form.submit()">@foreach($assessments as $item)<option value="{{ $item->id }}" @selected($assessment?->is($item))>{{ $item->name }}</option>@endforeach</select>
            </form>
        </div>
        <div class="f2-ribbon">{{ $isPrimary ? 'Msingi' : 'Secondary' }} / {{ $classLevel }} - {{ $assessment?->name ?? ($isPrimary ? 'Hakuna mtihani uliowekwa' : 'No assessment configured') }}</div>
        <div class="table-responsive"><table class="table table-bordered f2-table mb-0"><thead><tr><th>{{ $isPrimary ? 'Kundi' : 'Group' }}</th><th>{{ $isPrimary ? 'Waliosajiliwa' : 'REG' }}</th><th>{{ $isPrimary ? 'Waliofanya' : 'SAT' }}</th><th>{{ $isPrimary ? 'Wasiokuwepo' : 'ABS' }}</th>@if($isPrimary)@foreach(['A','B','C','D','F'] as $grade)<th>DARAJA {{ $grade }}</th>@endforeach @else @foreach(['I','II','III','IV','0','INC'] as $division)<th>DIV {{ $division }}</th>@endforeach @endif<th>{{ $isPrimary ? 'Waliofaulu' : 'PASS' }}</th><th>{{ $isPrimary ? 'Ufaulu %' : 'PASS %' }}</th></tr></thead><tbody>
            @foreach(['F' => ($isPrimary ? 'Wasichana' : 'Girls'), 'M' => ($isPrimary ? 'Wavulana' : 'Boys'), 'ALL' => ($isPrimary ? 'Jumla' : 'Total')] as $key => $label)
                @php($group = $groups[$key])
                <tr><td class="fw-bold">{{ $label }}</td><td>{{ $group['registered'] }}</td><td>{{ $group['sat'] }}</td><td>{{ $group['absent'] }}</td>@if($isPrimary)@foreach(['A','B','C','D','F'] as $grade)<td>{{ $group['grades'][$grade] }}</td>@endforeach @else @foreach(['I','II','III','IV','0','INC'] as $division)<td>{{ $group['divisions'][$division] }}</td>@endforeach @endif<td>{{ $group['passed'] }}</td><td class="fw-bold">{{ number_format($group['pass_rate'], 1) }}%</td></tr>
            @endforeach
        </tbody></table></div>
    </div>

    <div class="f2-sheet">
        <div class="f2-title"><h5>{{ $isPrimary ? 'UCHAMBUZI WA MASOMO' : 'SUBJECT ANALYSIS' }}</h5></div>
        <div class="table-responsive"><table class="table table-bordered table-striped f2-table mb-0"><thead><tr><th>{{ $isPrimary ? 'Msimbo' : 'Code' }}</th><th>{{ $isPrimary ? 'Somo' : 'Subject' }}</th><th>{{ $isPrimary ? 'Waliofanya' : 'SAT' }}</th><th>{{ $isPrimary ? 'Wastani' : 'Average' }}</th><th>{{ $isPrimary ? 'Waliofaulu' : 'Passed' }}</th><th>{{ $isPrimary ? 'Ufaulu %' : 'Pass %' }}</th></tr></thead><tbody>
            @forelse($subjectAnalysis as $item)<tr><td>{{ $item['subject']->code }}</td><td class="fw-bold">{{ $item['subject']->name }}</td><td class="text-center">{{ $item['sat'] }}</td><td class="text-center">{{ $item['average'] !== null ? number_format($item['average'], 2) : '-' }}</td><td class="text-center">{{ $item['passed'] }}</td><td class="text-center fw-bold">{{ number_format($item['pass_rate'], 1) }}%</td></tr>@empty<tr><td colspan="6" class="f2-empty">{{ $isPrimary ? 'Hakuna uchambuzi unaopatikana.' : 'No analysis is available.' }}</td></tr>@endforelse
        </tbody></table></div>
    </div>
</div>
@endsection
