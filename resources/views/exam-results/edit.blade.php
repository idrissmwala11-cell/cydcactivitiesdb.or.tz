@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        EDIT {{ strtoupper($section['title']) }}
                    </h5>
                    <a href="{{ route($section['route'] . '.show', $examResult) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route($section['route'] . '.update', $examResult) }}" method="POST">
                        @method('PUT')
                        @include('exam-results._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
