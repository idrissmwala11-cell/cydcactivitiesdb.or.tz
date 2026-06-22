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
            <div class="col-md-2"><label class="form-label">{{ $isPrimary ? 'Ngazi' : 'Level' }}</label><select class="form-select" name="education_level" onchange="this.form.querySelector('[name=class_level]').value=''; this.form.querySelector('[name=assessment_id]').value=''; this.form.run.value='0'; this.form.submit()"><option value="primary" @selected($educationLevel === 'primary')>Msingi</option><option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option></select></div>
            <div class="col-md-2"><label class="form-label">{{ $isPrimary ? 'Darasa' : 'Class' }}</label><select class="form-select" name="class_level" onchange="this.form.querySelector('[name=assessment_id]').value=''; this.form.run.value='0'; this.form.submit()">@foreach($classOptions[$educationLevel] as $option)<option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">{{ $isPrimary ? 'Mtihani' : 'Assessment' }}</label><select class="form-select" name="assessment_id">@foreach($assessments as $item)<option value="{{ $item->id }}" @selected($assessment?->is($item))>{{ $item->name }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">FCP</label><select class="form-select" name="fcp_name"><option value="">{{ $isPrimary ? 'FCP zote / Wanafunzi wote' : 'All FCPs / All students' }}</option>@foreach($fcpNames as $fcpName)<option value="{{ $fcpName }}" @selected($selectedFcp === $fcpName)>{{ $fcpName }}</option>@endforeach</select></div>
            <div class="col-md-2"><label class="form-label">{{ $isPrimary ? 'Aina ya Ripoti' : 'Report Type' }}</label><select class="form-select" name="report_type"><option value="cards" @selected($reportType === 'cards')>{{ $isPrimary ? 'Ripoti moja moja' : 'Individual cards' }}</option><option value="list" @selected($reportType === 'list')>{{ $isPrimary ? 'Orodha kamili' : 'Full results list' }}</option></select></div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <button class="btn btn-success"><i class="bi bi-play-fill me-1"></i>{{ $isPrimary ? 'Run Ripoti' : 'Run Report' }}</button>
                @if($hasRun && $rows->isNotEmpty())
                    <button type="button" class="btn btn-dark" onclick="window.print()"><i class="bi bi-printer me-1"></i>{{ $reportType === 'list' ? ($isPrimary ? 'Chapisha Orodha' : 'Print List') : ($isPrimary ? 'Chapisha Zote' : 'Print All') }}</button>
                @endif
            </div>
        </form>

        @if($assessment)
            <div class="px-3 pb-3 d-flex flex-wrap justify-content-end align-items-center gap-2">
                @if($assessment->is_published)
                    <span class="badge bg-success fs-6 px-3 py-2"><i class="bi bi-check-circle me-1"></i>{{ $isPrimary ? 'Matokeo Yamepublish' : 'Results Published' }}</span>
                    @if(auth()->user()->canPublishFormTwoResults())
                        <form method="POST" action="{{ route('form-two-results.reports.unpublish', $assessment) }}" onsubmit="return confirm('{{ $isPrimary ? 'Ondoa matokeo haya kwa users wote? Marks hazitafutwa.' : 'Remove these published results for all users? Marks will not be deleted.' }}')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><i class="bi bi-eye-slash me-1"></i>{{ $isPrimary ? 'Ondoa Matokeo Yaliyopublish' : 'Remove Published Results' }}</button>
                        </form>
                    @endif
                @elseif(auth()->user()->canPublishFormTwoResults())
                    <form method="POST" action="{{ route('form-two-results.reports.publish', $assessment) }}" onsubmit="return confirm('{{ $isPrimary ? 'Unataka kupublish matokeo haya kwa users wote?' : 'Publish these results for all users?' }}')">
                        @csrf
                        <button class="btn btn-primary"><i class="bi bi-megaphone me-1"></i>{{ $isPrimary ? 'Publish Matokeo' : 'Publish Results' }}</button>
                    </form>
                @endif
            </div>
        @endif
    </div>

    @if($hasRun)
        @if($reportType === 'list' && $rows->isNotEmpty())
            @include('form-two-results._results_list_report')
        @else
            @forelse($rows as $summary)
                @include('form-two-results._report_card', ['summary' => $summary, 'assessment' => $assessment])
            @empty
                <div class="f2-sheet"><div class="f2-empty">{{ $isPrimary ? 'Hakuna ripoti zinazopatikana kwa uchaguzi huu.' : 'No reports are available for this selection.' }}</div></div>
            @endforelse
        @endif
    @endif
</div>
@endsection
