@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @php($isPrimary = $educationLevel === 'primary')
    @include('form-two-results._nav')
    @include('form-two-results._scope')
    @include('form-two-results._alerts')

    <div class="f2-sheet mb-4">
        <div class="f2-title d-flex align-items-center justify-content-between gap-3">
            <div>
                <div class="small text-uppercase opacity-75">{{ $isPrimary ? 'Mfumo wa Matokeo' : 'Results System' }}</div>
                <h2>{{ $isPrimary ? 'Matokeo 2026' : 'Results 2026' }}</h2>
                <div class="fw-bold text-warning">{{ $isPrimary ? 'Msingi' : 'Secondary' }} - {{ $classLevel }}</div>
                <div>{{ config('form_two_results.school_subtitle') }}</div>
            </div>
            <i class="bi bi-mortarboard-fill" style="font-size:3rem;color:#f4c430"></i>
        </div>
        <div class="f2-ribbon">{{ $isPrimary ? 'MFUMO WA UINGIZAJI NA UCHAMBUZI WA MATOKEO' : 'ALL WORK BOOK SHEETS - WEB WORKFLOW' }}</div>
        <div class="p-4">
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3"><div class="f2-stat"><div class="text-muted">{{ $isPrimary ? 'Wanafunzi Waliosajiliwa' : 'Registered Students' }}</div><div class="value">{{ $studentCount }}</div></div></div>
                <div class="col-sm-6 col-xl-3"><div class="f2-stat"><div class="text-muted">{{ $isPrimary ? 'Masomo Yanayotumika' : 'Active Subjects' }}</div><div class="value">{{ $subjectCount }}</div></div></div>
                <div class="col-sm-6 col-xl-3"><div class="f2-stat"><div class="text-muted">{{ $isPrimary ? 'Mitihani' : 'Assessments' }}</div><div class="value">{{ $assessmentCount }}</div></div></div>
                <div class="col-sm-6 col-xl-3"><div class="f2-stat"><div class="text-muted">{{ $isPrimary ? 'Alama Zilizoingizwa' : 'Marks Recorded' }}</div><div class="value">{{ $markCount }}</div></div></div>
            </div>

            <h5 class="fw-bold mb-3">{{ $isPrimary ? 'Hatua za Mfumo' : 'Workbook Workflow' }}</h5>
            <div class="row g-3">
                @foreach([
                    ['1', $isPrimary ? 'Masomo na Misimbo' : 'Subjects & Codes', 'Hakiki misimbo, majina na vifupisho vya masomo.', 'form-two-results.subjects.index'],
                    ['2', $isPrimary ? 'Usajili wa Wanafunzi' : 'Name Entry', 'Sajili mwanafunzi na masomo anayofanya.', 'form-two-results.students.index'],
                    ['3', $isPrimary ? 'Mitihani' : 'Assessments', 'Chagua mwezi au mtihani wa muhula.', 'form-two-results.assessments.index'],
                    ['4', $isPrimary ? 'Uingizaji wa Alama' : 'Marks Entry', 'Ingiza alama au weka ABS kwenye jedwali.', 'form-two-results.marks.index'],
                    ['5', $isPrimary ? 'Matokeo' : 'Results', $isPrimary ? 'Daraja, wastani na nafasi hukokotolewa.' : 'Grade, points, division na ranking hukokotolewa.', 'form-two-results.results.index'],
                    ['6', $isPrimary ? 'Uchambuzi na Ripoti' : 'Analysis & Reports', 'Angalia muhtasari wa ufaulu na ripoti za wanafunzi.', 'form-two-results.analysis.index'],
                ] as [$number, $title, $description, $route])
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route($route, ['education_level' => $educationLevel, 'class_level' => $classLevel]) }}" class="text-decoration-none text-dark">
                            <div class="f2-workflow h-100"><strong>{{ $number }}. {{ $title }}</strong><div class="small text-muted mt-1">{{ $description }}</div></div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
