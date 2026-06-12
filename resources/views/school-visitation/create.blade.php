@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-building-check me-2"></i>
                        SCHOOL VISITATION FORM
                    </h5>
                    <a href="{{ route('school-visitation.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('school-visitation.store') }}" method="POST">
                        @include('school-visitation._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
