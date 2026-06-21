@props(['user' => null, 'size' => 36])

@php
    $size = max(20, (int) $size);
    $initials = $user?->initials ?? 'U';
    $avatarUrl = $user?->avatar_url ?: asset('images/cydc-activities-logo.png');
@endphp

<span
    {{ $attributes->merge(['class' => 'user-avatar d-inline-flex align-items-center justify-content-center rounded-circle overflow-hidden flex-shrink-0']) }}
    style="width: {{ $size }}px; height: {{ $size }}px; background: #ffffff; color: #fff; font-size: {{ max(10, (int) round($size * 0.34)) }}px; font-weight: 700; position: relative;"
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
</span>
