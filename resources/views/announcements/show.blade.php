@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-3" style="word-break: break-word;">
                {{ $announcement->title }}
            </h3>

            <div class="text-muted mb-3">
                {{ $announcement->created_at->format('d M Y H:i') }}
            </div>

            <hr>

            <div style="
                white-space: pre-wrap;
                word-break: break-word;
                overflow-wrap: anywhere;
                line-height: 1.9;
                font-size: 16px;
                color: #111827;
            ">
                {!! nl2br(e($announcement->message)) !!}
            </div>
        </div>
    </div>
</div>
@endsection
