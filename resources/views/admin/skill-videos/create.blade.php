@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Upload Skill Video</h3>

    <form action="{{ route('admin.skill-videos.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Video Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Choose Video</label>
            <input type="file" name="video" class="form-control" accept="video/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload Video</button>
    </form>
</div>
@endsection
