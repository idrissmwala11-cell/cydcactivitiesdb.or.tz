@extends('layouts.app')

@section('content')
@include('form-two-results._styles')
<div class="container-fluid f2-shell">
    @include('form-two-results._nav')
    @include('form-two-results._alerts')
    <div class="f2-sheet">
        <div class="f2-title"><h5>{{ $educationLevel === 'primary' ? 'HARIRI TAARIFA ZA MWANAFUNZI' : 'EDIT NAME ENTRY' }}</h5></div>
        <form method="POST" action="{{ route('form-two-results.students.update', $student) }}" class="p-3">
            @include('form-two-results.students._form')
            <div class="d-flex justify-content-end gap-2 mt-3"><a class="btn btn-secondary" href="{{ route('form-two-results.students.index', ['education_level' => $educationLevel, 'class_level' => $classLevel]) }}">{{ $educationLevel === 'primary' ? 'Ghairi' : 'Cancel' }}</a><button class="btn btn-success">{{ $educationLevel === 'primary' ? 'Hifadhi Mabadiliko' : 'Save Changes' }}</button></div>
        </form>
    </div>
</div>
@endsection
