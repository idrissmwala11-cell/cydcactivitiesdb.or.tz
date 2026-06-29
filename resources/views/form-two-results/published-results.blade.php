@extends('layouts.app')

@section('title', 'Published Results')

@section('content')
@include('form-two-results._styles')
@include('form-two-results._report_styles')
<div class="container-fluid f2-shell">
    @php
        $isPrimary = $educationLevel === 'primary';
        $currentQuery = [
            'education_level' => $educationLevel,
            'class_level' => $classLevel,
            'assessment_id' => $assessment?->id,
        ];
        $downloadQuery = array_filter($currentQuery + ['fcp_name' => $selectedFcp], fn ($value) => $value !== null && $value !== '');
    @endphp

    <div class="f2-sheet f2-no-print mb-4">
        <div class="f2-title d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5>{{ $isPrimary ? 'MATOKEO YALIYOPUBLISH' : 'PUBLISHED RESULTS' }}</h5>
                <div class="small opacity-75">{{ $isPrimary ? 'Chagua darasa na mtihani kuona orodha ya matokeo.' : 'Select a class and assessment to view the read-only results list.' }}</div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-light"><i class="bi bi-arrow-left me-1"></i>{{ $isPrimary ? 'Dashboard' : 'Back to Dashboard' }}</a>
        </div>

        <form method="GET" class="p-3 row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">{{ $isPrimary ? 'Ngazi' : 'Level' }}</label>
                <select class="form-select" name="education_level" onchange="this.form.querySelector('[name=class_level]').value=''; this.form.querySelector('[name=assessment_id]').value=''; this.form.querySelector('[name=fcp_name]').value=''; this.form.submit()">
                    <option value="primary" @selected($educationLevel === 'primary')>Msingi</option>
                    <option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">{{ $isPrimary ? 'Darasa' : 'Class' }}</label>
                <select class="form-select" name="class_level" onchange="this.form.querySelector('[name=assessment_id]').value=''; this.form.querySelector('[name=fcp_name]').value=''; this.form.submit()">
                    @foreach($classOptions[$educationLevel] as $option)
                        <option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">{{ $isPrimary ? 'Mtihani Uliopublish' : 'Published Assessment' }}</label>
                <select class="form-select" name="assessment_id" onchange="this.form.querySelector('[name=fcp_name]').value=''; this.form.submit()" @disabled($assessments->isEmpty())>
                    @forelse($assessments as $item)
                        <option value="{{ $item->id }}" @selected($assessment?->is($item))>{{ $item->name }}</option>
                    @empty
                        <option>{{ $isPrimary ? 'Hakuna matokeo yaliyopublish' : 'No published results' }}</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">FCP</label>
                <select class="form-select" name="fcp_name" onchange="this.form.querySelector('[name=view_mode]').value='results'; this.form.submit()" @disabled($fcpNames->isEmpty())>
                    <option value="">{{ $isPrimary ? 'FCP zote' : 'All FCPs' }}</option>
                    @foreach($fcpNames as $fcpName)
                        <option value="{{ $fcpName }}" @selected($selectedFcp === $fcpName)>{{ $fcpName }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="view_mode" value="{{ $viewMode }}">
            </div>
            <div class="col-md-3">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-dark flex-fill" onclick="window.print()" @disabled(! $assessment || $rows->isEmpty())><i class="bi bi-printer me-1"></i>{{ $isPrimary ? 'Chapisha' : 'Print List' }}</button>
                    <a class="btn btn-success flex-fill {{ ! $assessment || $rows->isEmpty() ? 'disabled' : '' }}"
                       href="{{ route('published-results.download', $downloadQuery) }}"
                       @if(! $assessment || $rows->isEmpty()) aria-disabled="true" tabindex="-1" @endif>
                        <i class="bi bi-download me-1"></i>{{ $isPrimary ? 'Pakua' : 'Download' }}
                    </a>
                </div>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <a class="btn {{ $viewMode === 'results' ? 'btn-success' : 'btn-outline-success' }}"
                   href="{{ route('published-results.index', array_filter($currentQuery + ['fcp_name' => $selectedFcp], fn ($value) => $value !== null && $value !== '')) }}">
                    <i class="bi bi-table me-1"></i>{{ $isPrimary ? 'View Orodha ya Matokeo' : 'View Results List' }}
                </a>
                <a class="btn {{ $viewMode === 'fcp_ranking' ? 'btn-warning' : 'btn-outline-warning' }}"
                   href="{{ route('published-results.index', array_filter($currentQuery + ['view_mode' => 'fcp_ranking'], fn ($value) => $value !== null && $value !== '')) }}">
                    <i class="bi bi-trophy me-1"></i>{{ $isPrimary ? 'View Best FCPs' : 'View Best FCPs' }}
                </a>
                @if($selectedFcp !== '')
                    <span class="badge bg-info text-dark d-flex align-items-center px-3">{{ $isPrimary ? 'Unaangalia FCP:' : 'Viewing FCP:' }} {{ $selectedFcp }}</span>
                @endif
            </div>
        </form>
    </div>

    @if($assessment && $viewMode === 'fcp_ranking')
        @include('form-two-results._fcp_ranking_table')
    @elseif($assessment && $rows->isNotEmpty())
        @include('form-two-results._results_list_report')
    @elseif($assessment)
        <div class="f2-sheet"><div class="f2-empty">{{ $isPrimary ? 'Hakuna wanafunzi kwenye matokeo haya.' : 'No students are available in these results.' }}</div></div>
    @else
        <div class="f2-sheet"><div class="f2-empty"><i class="bi bi-megaphone fs-1 d-block mb-2"></i>{{ $isPrimary ? 'Hakuna matokeo yaliyopublish kwa darasa hili.' : 'No results have been published for this class.' }}</div></div>
    @endif
</div>
@endsection
