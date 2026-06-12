@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @php($isPrimary = $educationLevel === 'primary')
    @include('form-two-results._nav')
    @include('form-two-results._scope')
    @include('form-two-results._alerts')
    <div class="f2-sheet">
        <div class="f2-title"><h5>{{ $isPrimary ? 'MSINGI - MASOMO NA MISIMBO' : strtoupper($educationLevel).' - SUBJECTS AND CODES' }}</h5></div>
        <div class="f2-ribbon">{{ $isPrimary ? 'Masomo ya '.$classLevel : 'Structure imported from the workbook, without student data' }}</div>
        <form method="POST" action="{{ route('form-two-results.subjects.update') }}" class="p-3">
            @csrf @method('PUT')
            <div class="table-responsive">
                <table class="table table-bordered f2-table mb-0">
                    <thead><tr><th>Na.</th><th>{{ $isPrimary ? 'Msimbo' : 'Code' }}</th><th>{{ $isPrimary ? 'Jina la Somo' : 'Subject Name' }}</th><th>{{ $isPrimary ? 'Kifupisho' : 'Initials' }}</th><th>{{ $isPrimary ? 'Mpangilio' : 'Order' }}</th><th>{{ $isPrimary ? 'Linatumiwa' : 'Active' }}</th></tr></thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td class="text-center fw-bold">{{ $loop->iteration }}</td>
                            <td><input class="form-control" name="subjects[{{ $subject->id }}][code]" value="{{ old("subjects.{$subject->id}.code", $subject->code) }}" required></td>
                            <td><input class="form-control" name="subjects[{{ $subject->id }}][name]" value="{{ old("subjects.{$subject->id}.name", $subject->name) }}" required></td>
                            <td><input class="form-control" name="subjects[{{ $subject->id }}][abbreviation]" value="{{ old("subjects.{$subject->id}.abbreviation", $subject->abbreviation) }}" required></td>
                            <td><input type="number" class="form-control" name="subjects[{{ $subject->id }}][display_order]" value="{{ old("subjects.{$subject->id}.display_order", $subject->display_order) }}" min="0" required></td>
                            <td class="text-center"><input type="hidden" name="subjects[{{ $subject->id }}][is_active]" value="0"><input class="form-check-input" type="checkbox" name="subjects[{{ $subject->id }}][is_active]" value="1" @checked($subject->is_active)></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-3"><button class="btn btn-success"><i class="bi bi-check-circle me-1"></i>{{ $isPrimary ? 'Hifadhi Masomo' : 'Save Subjects' }}</button></div>
        </form>
    </div>
</div>
@endsection
