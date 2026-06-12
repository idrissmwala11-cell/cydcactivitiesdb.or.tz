@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
@include('form-two-results._report_styles')
<div class="container-fluid f2-shell">
    @php($isPrimary = $educationLevel === 'primary')
    @include('form-two-results._nav')
    @include('form-two-results._alerts')

    <div class="f2-sheet f2-no-print mb-4">
        <div class="f2-title"><h5>{{ $isPrimary ? 'RUN RIPOTI ZA WANAFUNZI' : 'RUN STUDENT REPORTS' }}</h5></div>
        <form method="GET" class="p-3 row g-3 align-items-end">
            <input type="hidden" name="run" value="1">
            <div class="col-md-3"><label class="form-label">{{ $isPrimary ? 'Ngazi' : 'Level' }}</label><select class="form-select" name="education_level" onchange="this.form.querySelector('[name=class_level]').value=''; this.form.querySelector('[name=assessment_id]').value=''; this.form.run.value='0'; this.form.submit()"><option value="primary" @selected($educationLevel === 'primary')>Msingi</option><option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option></select></div>
            <div class="col-md-3"><label class="form-label">{{ $isPrimary ? 'Darasa' : 'Class' }}</label><select class="form-select" name="class_level" onchange="this.form.querySelector('[name=assessment_id]').value=''; this.form.run.value='0'; this.form.submit()">@foreach($classOptions[$educationLevel] as $option)<option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">{{ $isPrimary ? 'Mtihani' : 'Assessment' }}</label><select class="form-select" name="assessment_id">@foreach($assessments as $item)<option value="{{ $item->id }}" @selected($assessment?->is($item))>{{ $item->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">FCP</label><select class="form-select" name="fcp_name"><option value="">{{ $isPrimary ? 'FCP zote / Wanafunzi wote' : 'All FCPs / All students' }}</option>@foreach($fcpNames as $fcpName)<option value="{{ $fcpName }}" @selected($selectedFcp === $fcpName)>{{ $fcpName }}</option>@endforeach</select></div>
            <div class="col-12 d-flex justify-content-end gap-2"><button class="btn btn-success"><i class="bi bi-play-fill me-1"></i>{{ $isPrimary ? 'Run Ripoti' : 'Run Reports' }}</button>@if($hasRun && $rows->isNotEmpty())<button type="button" class="btn btn-dark" onclick="window.print()"><i class="bi bi-printer me-1"></i>{{ $isPrimary ? 'Chapisha Zote' : 'Print All' }}</button>@endif</div>
        </form>
    </div>

    @if($hasRun)
        @forelse($rows as $summary)
            @include('form-two-results._report_card', ['summary' => $summary, 'assessment' => $assessment])
        @empty
            <div class="f2-sheet"><div class="f2-empty">{{ $isPrimary ? 'Hakuna ripoti zinazopatikana kwa uchaguzi huu.' : 'No reports are available for this selection.' }}</div></div>
        @endforelse
    @endif
</div>
@endsection
