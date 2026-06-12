@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @php($isPrimary = $educationLevel === 'primary')
    @include('form-two-results._nav')
    @include('form-two-results._scope')
    @include('form-two-results._alerts')
    <div class="f2-sheet mb-4">
        <div class="f2-title"><h5>{{ $isPrimary ? 'MITIHANI - MUHULA WA KWANZA' : 'ASSESSMENT PERIODS - TERM I' }}</h5></div>
        <form method="POST" action="{{ route('form-two-results.assessments.store') }}" class="p-3">
            @csrf
            <input type="hidden" name="education_level" value="{{ $educationLevel }}">
            <input type="hidden" name="class_level" value="{{ $classLevel }}">
            <div class="row g-2 align-items-end">
                <div class="col-lg-4"><label class="form-label">{{ $isPrimary ? 'Jina la Mtihani' : 'Assessment Name' }}</label><input class="form-control" name="name" required></div>
                <div class="col-lg-2"><label class="form-label">{{ $isPrimary ? 'Muhula' : 'Term' }}</label><input class="form-control" name="term" value="{{ $isPrimary ? 'MUHULA I' : 'TERM I' }}" required></div>
                <div class="col-lg-2"><label class="form-label">{{ $isPrimary ? 'Tarehe' : 'Date' }}</label><input type="date" class="form-control" name="assessment_date"></div>
                <div class="col-lg-2"><label class="form-label">{{ $isPrimary ? 'Alama za Juu' : 'Max Marks' }}</label><input type="number" class="form-control" name="max_marks" value="{{ $isPrimary ? 50 : 100 }}" readonly required></div>
                <div class="col-lg-1"><label class="form-label">{{ $isPrimary ? 'Mpangilio' : 'Order' }}</label><input type="number" class="form-control" name="display_order" value="{{ $assessments->max('display_order') + 1 }}" min="0" required></div>
                <div class="col-lg-1"><button class="btn btn-success w-100"><i class="bi bi-plus-lg"></i></button></div>
            </div>
        </form>
    </div>
    <div class="f2-sheet">
        <div class="table-responsive"><table class="table table-bordered f2-table mb-0"><thead><tr><th>{{ $isPrimary ? 'Mpangilio' : 'Order' }}</th><th>{{ $isPrimary ? 'Mtihani' : 'Assessment' }}</th><th>{{ $isPrimary ? 'Muhula' : 'Term' }}</th><th>{{ $isPrimary ? 'Tarehe' : 'Date' }}</th><th>{{ $isPrimary ? 'Alama' : 'Max' }}</th><th>{{ $isPrimary ? 'Imechapishwa' : 'Published' }}</th><th>{{ $isPrimary ? 'Vitendo' : 'Actions' }}</th></tr></thead><tbody>
        @foreach($assessments as $assessment)
            <tr>
                <td><input form="assessment-{{ $assessment->id }}" type="number" class="form-control" name="display_order" value="{{ $assessment->display_order }}" min="0"></td>
                <td><input form="assessment-{{ $assessment->id }}" class="form-control" name="name" value="{{ $assessment->name }}" required></td>
                <td><input form="assessment-{{ $assessment->id }}" class="form-control" name="term" value="{{ $assessment->term }}" required></td>
                <td><input form="assessment-{{ $assessment->id }}" type="date" class="form-control" name="assessment_date" value="{{ $assessment->assessment_date?->format('Y-m-d') }}"></td>
                <td><input form="assessment-{{ $assessment->id }}" type="number" class="form-control" name="max_marks" value="{{ $isPrimary ? 50 : 100 }}" readonly></td>
                <td class="text-center"><input form="assessment-{{ $assessment->id }}" type="hidden" name="is_published" value="0"><input form="assessment-{{ $assessment->id }}" type="checkbox" class="form-check-input" name="is_published" value="1" @checked($assessment->is_published)></td>
                <td class="text-nowrap"><button form="assessment-{{ $assessment->id }}" class="btn btn-sm btn-success"><i class="bi bi-check"></i></button> <form class="d-inline" method="POST" action="{{ route('form-two-results.assessments.destroy', $assessment) }}" onsubmit="return confirm('Futa assessment na alama zake?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button></form></td>
            </tr>
        @endforeach
        </tbody></table></div>
        @foreach($assessments as $assessment)<form id="assessment-{{ $assessment->id }}" method="POST" action="{{ route('form-two-results.assessments.update', $assessment) }}">@csrf @method('PUT')<input type="hidden" name="education_level" value="{{ $educationLevel }}"><input type="hidden" name="class_level" value="{{ $classLevel }}"></form>@endforeach
    </div>
</div>
@endsection
