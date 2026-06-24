@props(['user' => null, 'size' => 36])

@php
    $size = max(20, (int) $size);
    $initials = $user?->initials ?? 'U';
    $avatarUrl = $user?->avatar_url;
@endphp

<span
    {{ $attributes->merge(['class' => 'user-avatar d-inline-flex align-items-center justify-content-center rounded-circle overflow-hidden flex-shrink-0']) }}
    style="width: {{ $size }}px; height: {{ $size }}px; background: linear-gradient(135deg, #0f766e, #2563eb); color: #fff; font-size: {{ max(10, (int) round($size * 0.34)) }}px; font-weight: 700; position: relative;"
    title="{{ $user?->center_id ?: $user?->email ?: 'User' }}"
>
    <span aria-hidden="true">{{ $initials }}</span>
    @if($avatarUrl)
        <img
            src="{{ $avatarUrl }}"
            alt="Picha ya {{ $user?->center_id ?: $user?->email ?: 'user' }}"
            style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;"
            onerror="this.style.display='none'"
        >
    @endif

    @if($user?->is_online)
        <span
            aria-label="Online"
            title="Online"
            style="position:absolute;right:0;bottom:0;width:{{ max(8, (int) round($size * 0.28)) }}px;height:{{ max(8, (int) round($size * 0.28)) }}px;border-radius:999px;background:#22c55e;border:2px solid #fff;box-shadow:0 0 0 2px rgba(34,197,94,.18);z-index:2;"
        ></span>
    @endif
</span>
