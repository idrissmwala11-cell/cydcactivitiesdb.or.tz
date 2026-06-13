@props(['user' => null, 'size' => 34, 'showEmail' => false, 'label' => null])

@php
    $displayName = $label ?: ($user?->center_id ?: $user?->name ?: $user?->email ?: 'Legacy record');
@endphp

<span {{ $attributes->merge(['class' => 'd-inline-flex align-items-center gap-2']) }}>
    <x-user-avatar :user="$user" :size="$size" />
    <span class="d-inline-flex flex-column text-start lh-sm">
        <span class="fw-semibold">{{ $displayName }}</span>
        @if($showEmail && $user?->email && $user->email !== $displayName)
            <small class="text-muted">{{ $user->email }}</small>
        @endif
    </span>
</span>
