@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots me-2"></i>
                        Chat
                    </h5>
                    @if($selectedContact)
                        <span class="badge bg-light text-dark border">
                            {{ auth()->user()->role === 'admin' ? 'Chat with user' : 'Chat with admin' }}
                        </span>
                    @endif
                </div>

                <div class="card-body p-0">
                    <div class="row g-0" style="min-height: 68vh;">
                        <div class="col-lg-4 border-end bg-light">
                            <div class="p-3 border-bottom">
                                <h6 class="mb-0">{{ auth()->user()->role === 'admin' ? 'Select User' : 'Admin Contact' }}</h6>
                            </div>

                            <div class="list-group list-group-flush">
                                @forelse($contacts as $contact)
                                    @php
                                        $unread = \App\Models\ChatMessage::where('sender_id', $contact->id)
                                            ->where('recipient_id', auth()->id())
                                            ->whereNull('read_at')
                                            ->count();
                                    @endphp
                                    <a href="{{ route('chat.index', ['user' => $contact->id]) }}"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-start {{ optional($selectedContact)->id === $contact->id ? 'active' : '' }}">
                                        <div>
                                            <div class="fw-semibold">{{ $contact->center_id ?: $contact->email }}</div>
                                            <div class="small {{ optional($selectedContact)->id === $contact->id ? 'text-white-50' : 'text-muted' }}">
                                                {{ $contact->email }}
                                            </div>
                                        </div>
                                        @if($unread > 0)
                                            <span class="badge bg-danger rounded-pill">{{ $unread > 99 ? '99+' : $unread }}</span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="p-4 text-muted">
                                        No contacts available to chat with right now.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-lg-8 d-flex flex-column">
                            @if($selectedContact)
                                <div class="p-3 border-bottom bg-white">
                                    <div class="fw-semibold">{{ $selectedContact->center_id ?: $selectedContact->email }}</div>
                                    <div class="small text-muted">{{ $selectedContact->email }}</div>
                                </div>

                                <div id="chatMessages" class="flex-grow-1 p-3" style="background: #f8fafc; overflow-y: auto; max-height: 52vh;">
                                    @forelse($messages as $message)
                                        @php $mine = $message->sender_id === auth()->id(); @endphp
                                        <div class="d-flex mb-3 {{ $mine ? 'justify-content-end' : 'justify-content-start' }}">
                                            <div class="px-3 py-2 rounded-4 shadow-sm {{ $mine ? 'bg-primary text-white' : 'bg-white border' }}" style="max-width: 78%;">
                                                <div class="small {{ $mine ? 'text-white-50' : 'text-muted' }} mb-1">
                                                    {{ $mine ? 'You' : ($message->sender->center_id ?: $message->sender->email) }}
                                                </div>
                                                <div style="white-space: pre-wrap;">{{ $message->message }}</div>
                                                <div class="small mt-2 {{ $mine ? 'text-white-50' : 'text-muted' }}">
                                                    {{ $message->created_at?->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                                            No messages yet. Start typing below.
                                        </div>
                                    @endforelse
                                </div>

                                <div class="p-3 border-top bg-white">
                                    <form method="POST" action="{{ route('chat.store') }}">
                                        @csrf
                                        <input type="hidden" name="recipient_id" value="{{ $selectedContact->id }}">
                                        <div class="d-flex gap-2 align-items-end">
                                            <div class="flex-grow-1">
                                                <label class="form-label small text-muted mb-1">Message</label>
                                                <textarea name="message" rows="2" class="form-control @error('message') is-invalid @enderror" placeholder="Type your message here..." required>{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary px-4 py-2">
                                                <i class="bi bi-send me-1"></i> Send
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="h-100 d-flex align-items-center justify-content-center text-muted p-4">
                                    No user or admin is available to start a chat right now.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>
@endsection
