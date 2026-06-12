@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Announcements</h4>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
            + New Message
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            @forelse($announcements as $announcement)
                <div class="border rounded-3 p-3 mb-3 bg-white" style="max-width: 100%; overflow: hidden;">
                    <h5 class="mb-3 fw-bold" style="word-break: break-word; overflow-wrap: break-word;">
                        {{ $announcement->title }}
                    </h5>

                    <div style="
                        max-width: 100%;
                        white-space: pre-wrap;
                        word-wrap: break-word;
                        overflow-wrap: anywhere;
                        word-break: break-word;
                        overflow: hidden;
                        line-height: 1.8;
                        color: #111827;
                        font-size: 15px;
                    ">
                        {!! nl2br(e($announcement->message)) !!}
                    </div>

                    <div class="mt-3">
                        <small class="text-muted">
                            {{ $announcement->created_at->format('d M Y H:i') }}
                        </small>
                    </div>
                </div>
            @empty
                <p class="text-muted mb-0">No announcements yet.</p>
            @endforelse

            <div class="mt-3">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
