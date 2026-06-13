@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @php($isPrimary = $educationLevel === 'primary')
    @include('form-two-results._nav')
    @include('form-two-results._alerts')

    <div class="f2-sheet">
        <div class="f2-title d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div><h5>{{ $isPrimary ? 'ALAMA ZA MUHULA WA KWANZA' : 'MARKS TERM I' }}</h5><div class="small opacity-75">{{ $isPrimary ? 'Ingiza alama kuanzia 0 hadi 50, au weka ABS.' : 'Enter marks from 0 to the assessment maximum, or tick ABS.' }}</div></div>
            <form method="GET" class="f2-no-print d-flex flex-wrap gap-2">
                <select class="form-select" name="education_level" onchange="this.form.querySelector('[name=class_level]').value=''; if(this.form.querySelector('[name=assessment_id]')) this.form.querySelector('[name=assessment_id]').value=''; this.form.submit()">
                    <option value="primary" @selected($educationLevel === 'primary')>Msingi</option>
                    <option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option>
                </select>
                <select class="form-select" name="class_level" onchange="if(this.form.querySelector('[name=assessment_id]')) this.form.querySelector('[name=assessment_id]').value=''; this.form.submit()">
                    @foreach($classOptions[$educationLevel] as $option)<option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>@endforeach
                </select>
                <select class="form-select" name="assessment_id" onchange="this.form.submit()">
                    @foreach($assessments as $item)<option value="{{ $item->id }}" @selected($assessment?->is($item))>{{ $item->name }}</option>@endforeach
                </select>
            </form>
        </div>
        <div class="f2-ribbon">{{ $isPrimary ? 'Msingi' : 'Secondary' }} / {{ $classLevel }} - {{ $assessment?->name ?? ($isPrimary ? 'Hakuna mtihani uliowekwa' : 'No assessment configured') }}</div>

        @if(! $assessment)
            <div class="f2-empty">{{ $isPrimary ? 'Ongeza mtihani kabla ya kuingiza alama.' : 'Add an assessment before entering marks.' }}</div>
        @elseif($students->isEmpty())
            <div class="f2-empty"><i class="bi bi-person-plus fs-1 d-block mb-2"></i>{{ $isPrimary ? 'Sajili wanafunzi kabla ya kuingiza alama.' : 'Add students in Name Entry before entering marks.' }}</div>
        @else
            <form id="marks-form" method="POST" action="{{ route('form-two-results.marks.store', $assessment) }}">
                @csrf @method('PUT')
                <input type="hidden" name="marks_payload" id="marks-payload">
                <div class="table-responsive" style="max-height:68vh">
                    <table class="table table-bordered f2-table mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th>Na.</th>
                                <th class="sticky-col">{{ $isPrimary ? 'Majina ya Wanafunzi' : "Candidates' Names" }}</th>
                                <th>FCP Name</th>
                                <th>{{ $isPrimary ? 'Jinsi' : 'Sex' }}</th>
                                <th style="min-width:560px">{{ $isPrimary ? 'Masomo Aliyochagua' : 'Selected Subjects' }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr data-student-row="{{ $student->id }}">
                                <td class="text-center">{{ $student->student_number }}</td>
                                <td class="sticky-col fw-bold">{{ $student->candidate_name }}</td>
                                <td class="text-nowrap fw-semibold">{{ $student->fcp_name ?: '-' }}</td>
                                <td class="text-center">{{ $student->sex }}</td>
                                <td class="p-2">
                                    @if($student->subjects->isEmpty())
                                        <span class="text-muted">{{ $isPrimary ? 'Hakuna somo lililochaguliwa.' : 'No subjects selected.' }}</span>
                                    @else
                                        <div class="f2-subject-entry-grid">
                                            @foreach($student->subjects as $subject)
                                                @php($mark = $student->marks->firstWhere('subject_id', $subject->id))
                                                <div class="f2-subject-entry">
                                                    <div class="f2-subject-entry__title">
                                                        <strong>{{ $subject->abbreviation }}</strong>
                                                        <span>{{ $subject->code }}</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm f2-mark mb-1" min="0" max="{{ (float) $assessment->max_marks }}" step="0.01" value="{{ $mark?->is_absent ? '' : $mark?->mark }}" data-student="{{ $student->id }}" data-subject="{{ $subject->id }}" aria-label="{{ $subject->name }}">
                                                    <label class="small text-danger mb-0"><input type="checkbox" class="form-check-input f2-absent" data-student="{{ $student->id }}" data-subject="{{ $subject->id }}" @checked($mark?->is_absent)> ABS</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 text-end f2-no-print"><button class="btn btn-success btn-lg"><i class="bi bi-calculator me-1"></i>{{ $isPrimary ? 'Hifadhi na Kokotoa Matokeo' : 'Save & Calculate Results' }}</button></div>
            </form>
        @endif
    </div>
</div>

@if($assessment && $students->isNotEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.f2-absent').forEach(function (checkbox) {
        const selector = `.f2-mark[data-student="${checkbox.dataset.student}"][data-subject="${checkbox.dataset.subject}"]`;
        const input = document.querySelector(selector);
        const sync = function () { input.disabled = checkbox.checked; input.classList.toggle('is-absent', checkbox.checked); if (checkbox.checked) input.value = ''; };
        checkbox.addEventListener('change', sync); sync();
    });

    document.getElementById('marks-form').addEventListener('submit', function () {
        const payload = Array.from(document.querySelectorAll('.f2-mark')).map(function (input) {
            const absent = document.querySelector(`.f2-absent[data-student="${input.dataset.student}"][data-subject="${input.dataset.subject}"]`);
            return { student_id: Number(input.dataset.student), subject_id: Number(input.dataset.subject), mark: input.value === '' ? null : Number(input.value), is_absent: absent.checked };
        });
        document.getElementById('marks-payload').value = JSON.stringify(payload);
    });
});
</script>
@endif
@endsection
