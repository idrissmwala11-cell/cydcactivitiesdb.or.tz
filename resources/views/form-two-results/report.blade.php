@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
@include('form-two-results._report_styles')
@php($isPrimary = $summary['student']->education_level === 'primary')
<div class="container-fluid f2-shell">
    <div class="f2-no-print mb-3 d-flex justify-content-between">
        <a class="btn btn-secondary" href="{{ route('form-two-results.results.index', ['education_level' => $summary['student']->education_level, 'class_level' => $summary['student']->class_level, 'assessment_id' => $assessment->id]) }}"><i class="bi bi-arrow-left me-1"></i>{{ $isPrimary ? 'Rudi' : 'Back' }}</a>
        <button class="btn btn-success" onclick="window.print()"><i class="bi bi-printer me-1"></i>{{ $isPrimary ? 'Chapisha Ripoti' : 'Print Report' }}</button>
    </div>
    @include('form-two-results._report_card', ['summary' => $summary, 'assessment' => $assessment])
</div>
@endsection
