@extends('layouts.app')

@section('title', 'Announcement')

@section('content')
@php
    $normalizedMessage = trim(preg_replace('/(?:\r\n|\r|\n){3,}/', "\n\n", $announcement->message));
    $paragraphs = preg_split('/(?:\r\n|\r|\n){2,}/', $normalizedMessage) ?: [];
    $sender = $announcement->user?->center_id
        ?: $announcement->user?->email
        ?: 'CYDC Activities Database';
@endphp

<style>
    .announcement-page {
        max-width: 1080px;
        margin: 0 auto;
    }

    .announcement-card {
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .announcement-card__header {
        padding: 2rem 2.25rem;
        color: #ffffff;
        background: linear-gradient(135deg, #0f5132, #198754);
    }

    .announcement-card__icon {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.16);
        font-size: 1.45rem;
    }

    .announcement-card__body {
        padding: 2.25rem;
    }

    .announcement-message {
        max-width: 880px;
        color: #1f2937;
        font-size: 1rem;
        line-height: 1.8;
        overflow-wrap: anywhere;
    }

    .announcement-message p {
        margin: 0 0 1.1rem;
    }

    .announcement-message p:last-child {
        margin-bottom: 0;
    }

    .announcement-card__footer {
        padding: 1rem 2.25rem;
        color: #64748b;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 767px) {
        .announcement-card__header,
        .announcement-card__body,
        .announcement-card__footer {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="announcement-page">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
            </a>
            <span class="badge bg-success-subtle text-success px-3 py-2">
                <i class="bi bi-check2-circle me-1"></i>Announcement opened
            </span>
        </div>

        <article class="announcement-card">
            <header class="announcement-card__header">
                <div class="d-flex align-items-start gap-3">
                    <div class="announcement-card__icon flex-shrink-0">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    <div>
                        <div class="small text-uppercase fw-semibold opacity-75 mb-2">System Announcement</div>
                        <h2 class="fw-bold mb-2" style="word-break: break-word;">{{ $announcement->title }}</h2>
                        <div class="d-flex flex-wrap gap-3 small text-white-50">
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $announcement->created_at->format('d M Y') }}</span>
                            <span><i class="bi bi-clock me-1"></i>{{ $announcement->created_at->format('H:i') }}</span>
                            <span><i class="bi bi-person-circle me-1"></i>{{ $sender }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="announcement-card__body">
                <div class="announcement-message">
                    @foreach($paragraphs as $paragraph)
                        <p>{!! nl2br(e(trim($paragraph))) !!}</p>
                    @endforeach
                </div>
            </div>

            <footer class="announcement-card__footer d-flex flex-wrap justify-content-between align-items-center gap-2">
                <span><i class="bi bi-shield-check me-1"></i>Official communication</span>
                <strong>CYDC Activities Database</strong>
            </footer>
        </article>
    </div>
</div>
@endsection
