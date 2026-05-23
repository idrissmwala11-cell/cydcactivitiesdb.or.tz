@extends('layouts.app')

@section('title', 'Edit Local Sponsorship')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Local Sponsorship</h2>
            <p class="text-muted mb-0">Update this local sponsorship record.</p>
        </div>
    </div>

    <form action="{{ route('local-sponsorship.update', $localSponsorship) }}" method="POST">
        @method('PUT')
        @include('local-sponsorship._form')
    </form>
</div>
@endsection
