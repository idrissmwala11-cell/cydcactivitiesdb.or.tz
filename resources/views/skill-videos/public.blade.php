@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Skills To Learn - Video Clips</h3>

    <div class="row">
        @forelse($videos as $video)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5>{{ $video->title }}</h5>
                        <p>{{ $video->description }}</p>

                        <video class="w-100 rounded" controls>
                            <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        @empty
            <p>No videos available right now.</p>
        @endforelse
    </div>
</div>
@endsection
