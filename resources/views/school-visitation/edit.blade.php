@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        EDIT SCHOOL VISITATION
                    </h5>
                    <a href="{{ route('school-visitation.show', $schoolVisitation) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('school-visitation.update', $schoolVisitation) }}" method="POST">
                        @method('PUT')
                        @include('school-visitation._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
