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
    @include('form-two-results._scope')
    @include('form-two-results._alerts')
    <div class="f2-sheet mb-4">
        <div class="f2-title"><h5>{{ $isPrimary ? 'USAJILI WA WANAFUNZI - MSINGI' : 'NAME ENTRY - '.strtoupper($educationLevel) }} / {{ strtoupper($classLevel) }}</h5></div>
        <div class="f2-ribbon">{{ $isPrimary ? 'Sajili wanafunzi wa '.$classLevel : 'Add structure records manually; Excel student names are not imported' }}</div>
        <form method="POST" action="{{ route('form-two-results.students.store') }}" class="p-3">
            @include('form-two-results.students._form')
            <div class="text-end mt-3"><button class="btn btn-success"><i class="bi bi-person-plus me-1"></i>{{ $isPrimary ? 'Sajili Mwanafunzi' : 'Add Student' }}</button></div>
        </form>
    </div>

    <div class="f2-sheet">
        <div class="p-3 f2-no-print border-bottom bg-light">
            <label for="students-name-search" class="form-label fw-bold mb-1">
                <i class="bi bi-search me-1"></i>{{ $isPrimary ? 'Tafuta jina la mwanafunzi' : 'Search candidate name' }}
            </label>
            <input type="search" id="students-name-search" class="form-control" placeholder="{{ $isPrimary ? 'Andika jina la mwanafunzi, namba au FCP...' : 'Type candidate name, number or FCP...' }}" autocomplete="off">
            <div id="students-name-search-count" class="small text-muted mt-1"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover f2-table mb-0">
                <thead><tr><th>Na.</th><th>{{ $isPrimary ? 'Jina la Mwanafunzi' : "Candidate's Name" }}</th><th>Jina la FCP</th><th>{{ $isPrimary ? 'Jinsi' : 'Sex' }}</th><th>{{ $isPrimary ? 'Masomo' : 'REG Subjects' }}</th><th>{{ $isPrimary ? 'Vitendo' : 'Actions' }}</th></tr></thead>
                <tbody>
                @forelse($students as $student)
                    <tr data-student-search="{{ strtolower($studentNumberPrefix.'-'.str_pad((string) $loop->iteration, 3, '0', STR_PAD_LEFT).' '.$student->student_number.' '.$student->candidate_name.' '.$student->fcp_name) }}">
                        <td class="text-center text-nowrap">{{ $studentNumberPrefix }}-{{ str_pad((string) $loop->iteration, 3, '0', STR_PAD_LEFT) }}</td><td class="fw-bold">{{ $student->candidate_name }}</td><td>{{ $student->fcp_name ?: '-' }}</td><td class="text-center">{{ $student->sex }}</td>
                        <td>{{ $student->subjects->where('pivot.registered', true)->pluck('abbreviation')->join(', ') }}</td>
                        <td class="text-nowrap"><a class="btn btn-sm btn-warning" href="{{ route('form-two-results.students.edit', $student) }}"><i class="bi bi-pencil"></i></a> <form class="d-inline" method="POST" action="{{ route('form-two-results.students.destroy', $student) }}" onsubmit="return confirm('Futa mwanafunzi na alama zake?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="f2-empty"><i class="bi bi-person-x fs-1 d-block mb-2"></i>Hakuna data ya wanafunzi. Hii ndiyo blank structure iliyoombwa.</td></tr>
                @endforelse
                    <tr id="students-name-search-empty" class="d-none">
                        <td colspan="6" class="f2-empty">{{ $isPrimary ? 'Hakuna mwanafunzi aliyepatikana kwa jina hilo.' : 'No candidate found for that search.' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('students-name-search');
    const searchCount = document.getElementById('students-name-search-count');
    const emptyRow = document.getElementById('students-name-search-empty');
    const searchableRows = Array.from(document.querySelectorAll('[data-student-search]'));
    const shownLabel = @json($isPrimary ? 'wanafunzi wameonekana' : 'students shown');

    if (! searchInput) {
        return;
    }

    searchInput.addEventListener('input', function () {
        const term = searchInput.value.trim().toLowerCase();
        let visible = 0;

        searchableRows.forEach(function (row) {
            const isMatch = term === '' || row.dataset.studentSearch.includes(term);
            row.classList.toggle('d-none', ! isMatch);
            if (isMatch) visible++;
        });

        if (emptyRow) {
            emptyRow.classList.toggle('d-none', visible !== 0);
        }

        if (searchCount) {
            searchCount.textContent = term === '' ? '' : `${visible} ${shownLabel}`;
        }
    });
});
</script>
@endsection
