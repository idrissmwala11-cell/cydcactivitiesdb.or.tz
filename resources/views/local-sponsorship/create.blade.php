@extends('layouts.app')

@section('title', 'Add Local Sponsorship')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Local Sponsorship</h2>
            <p class="text-muted mb-0">Register a child under local sponsorship.</p>
        </div>
    </div>

    <form action="{{ route('local-sponsorship.store') }}" method="POST">
        @include('local-sponsorship._form')
    </form>
</div>
@endsection
