@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
@php($isPrimary = $summary['student']->education_level === 'primary')
<style>
    .report-card-sheet { max-width: 940px; margin: 0 auto; color: #111; }
    .report-head { display:grid; grid-template-columns:100px 1fr 100px; align-items:center; padding:12px; text-align:center; border-bottom:2px solid #12372a; }
    .report-meta { display:grid; grid-template-columns:repeat(2,1fr); border-bottom:2px solid #12372a; }
    .report-meta > div { padding:8px 12px; border-right:1px solid #12372a; }
    .report-meta > div:nth-child(even) { border-right:0; }
    .report-footer { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; padding:12px; }
    @media(max-width:600px){.report-head{grid-template-columns:65px 1fr 65px}.f2-logo{width:58px;height:58px}.report-meta,.report-footer{grid-template-columns:1fr}}
</style>
<div class="container-fluid f2-shell">
    <div class="f2-no-print mb-3 d-flex justify-content-between">
        <a class="btn btn-secondary" href="{{ route('form-two-results.results.index', ['education_level' => $summary['student']->education_level, 'class_level' => $summary['student']->class_level, 'assessment_id' => $assessment->id]) }}"><i class="bi bi-arrow-left me-1"></i>{{ $isPrimary ? 'Rudi' : 'Back' }}</a>
        <button class="btn btn-success" onclick="window.print()"><i class="bi bi-printer me-1"></i>{{ $isPrimary ? 'Chapisha Ripoti' : 'Print Report' }}</button>
    </div>
    <div class="f2-sheet report-card-sheet">
        <div class="report-head">
            <img class="f2-logo" src="{{ asset('public/form-two-results/ruo-school-logo.png') }}" alt="School logo">
            <div><h5 class="fw-bold mb-1">{{ config('form_two_results.school_name') }}</h5><div class="fw-bold">{{ config('form_two_results.school_subtitle') }}</div><div class="mt-1">TAARIFA YA MAENDELEO YA MWANAFUNZI KWA MZAZI/MLEZI</div></div>
            <img class="f2-logo" src="{{ asset('public/form-two-results/fpct-logo.png') }}" alt="FPCT logo">
        </div>
        <div class="f2-ribbon">{{ strtoupper($assessment->name) }}</div>
        <div class="report-meta">
            <div><strong>Jina la Mwanafunzi:</strong> {{ $summary['student']->candidate_name }}</div><div><strong>Namba:</strong> {{ $summary['student']->student_number }}</div>
            <div><strong>Jinsi:</strong> {{ $summary['student']->sex === 'F' ? 'Msichana' : 'Mvulana' }}</div><div><strong>Darasa:</strong> {{ $summary['student']->class_level }}</div>
            <div><strong>FCP:</strong> {{ $summary['student']->fcp_name ?: '-' }}</div><div><strong>Muhula:</strong> {{ $assessment->term }}</div>
        </div>
        <div class="table-responsive"><table class="table table-bordered mb-0"><thead class="table-success"><tr><th>{{ $isPrimary ? 'Msimbo' : 'Code' }}</th><th>Somo</th><th>Alama</th><th>{{ $isPrimary ? 'Daraja' : 'Grade' }}</th><th>Maoni</th></tr></thead><tbody>
            @foreach($summary['subjects'] as $row)
                <tr><td>{{ $row['subject']->code }}</td><td>{{ $row['subject']->name }}</td><td class="text-center">{{ $row['isAbsent'] ? 'ABS' : ($row['mark'] !== null ? number_format($row['mark'], 2) : '-') }}</td><td class="text-center f2-grade-{{ $row['grade'] }}">{{ $row['grade'] ?? '-' }}</td><td>{{ match($row['grade']) {'A' => 'Vizuri sana', 'B' => 'Vizuri', 'C' => 'Wastani', 'D' => 'Dhaifu', 'F' => 'Dhaifu sana', 'ABS' => 'Hakufanya mtihani', default => '-'} }}</td></tr>
            @endforeach
        </tbody></table></div>
        <div class="report-footer">
            <div><strong>Wastani:</strong><div class="fs-4 fw-bold">{{ $summary['average'] !== null ? number_format($summary['average'], 2) : 'ABS' }}</div></div>
            <div><strong>{{ $isPrimary ? 'Daraja la Jumla' : 'Division / Points' }}:</strong><div class="fs-4 fw-bold">{{ $isPrimary ? ($summary['overall_grade'] ?? 'ABS') : $summary['division'].' / '.($summary['points'] ?? '-') }}</div></div>
            <div><strong>Nafasi:</strong><div class="fs-4 fw-bold">{{ $summary['rank'] ?? '-' }}</div></div>
        </div>
        <div class="px-3 pb-3"><strong>Maoni:</strong> {{ in_array($summary['overall_grade'], ['A', 'B', 'C', 'D'], true) ? 'Wastani wake unakubalika.' : 'Anatakiwa kuhudhuria darasa rekebishi.' }}</div>
    </div>
</div>
@endsection
