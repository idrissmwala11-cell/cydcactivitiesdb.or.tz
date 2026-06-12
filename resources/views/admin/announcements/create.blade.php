@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Tuma Ujumbe kwa Users Wote</h4>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="6" required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Tuma Ujumbe
                </button>

                <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
