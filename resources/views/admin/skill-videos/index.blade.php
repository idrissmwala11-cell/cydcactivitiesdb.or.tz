@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Skill Videos</h3>
        <a href="{{ route('admin.skill-videos.create') }}" class="btn btn-primary">Upload New Video</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @forelse($videos as $video)
                <div class="border rounded p-3 mb-3">
                    <h5>{{ $video->title }}</h5>
                    <p>{{ $video->description }}</p>

                    <video width="320" height="200" controls>
                        <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <form action="{{ route('admin.skill-videos.destroy', $video->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this video?')">Delete</button>
                    </form>
                </div>
            @empty
                <p>No videos uploaded yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
