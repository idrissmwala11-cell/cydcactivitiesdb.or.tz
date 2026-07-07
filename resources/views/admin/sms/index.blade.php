@extends('layouts.app')

@section('title', 'SMS Gateway')

@section('content')
<div class="fade-in">
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-danger text-dark rounded-4 p-4 shadow">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h1 class="h3 mb-2">
                            <i class="bi bi-chat-dots me-2"></i>
                            SMS Gateway
                        </h1>
                        <p class="mb-0 opacity-75">Tuma test SMS na fuatilia logs kabla ya kuwasha reminders automatic.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary bg-white fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-phone me-2 text-primary"></i>Gateway Status</h5>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>SMS Gateway</span>
                        <span class="badge {{ $gatewayEnabled ? 'bg-success' : 'bg-secondary' }}">{{ $gatewayEnabled ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Auto Reminders</span>
                        <span class="badge {{ $remindersEnabled ? 'bg-success' : 'bg-secondary' }}">{{ $remindersEnabled ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span>Users wenye phone</span>
                        <strong>{{ number_format($usersWithPhones) }}</strong>
                    </div>
                    <p class="text-muted small mt-3 mb-0">
                        Reminders zitatumwa kwa approved users wenye phone number pekee.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-send me-2 text-success"></i>Send Test SMS</h5>
                    <form method="POST" action="{{ route('admin.sms-gateway.test') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" for="phone">Phone Number</label>
                                <input id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="0673746031" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold" for="message">Message</label>
                                <textarea id="message" name="message" rows="3" maxlength="480" class="form-control @error('message') is-invalid @enderror" required>{{ old('message', 'Hii ni test SMS kutoka CYDC Activities Database.') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">System itaongeza title, salamu ya Shalom!, na signature automatically.</div>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button class="btn btn-success px-4" type="submit">
                                <i class="bi bi-send-fill me-2"></i>Tuma Test SMS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-android2 me-2 text-success"></i>App ya Kudownload</h5>
                    <p class="mb-2">Tumia Android app hii:</p>
                    <div class="p-3 bg-light rounded-3 border">
                        <strong>SMS Gateway for Android™</strong><br>
                        <span class="text-muted">Developer: capcom6</span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a href="https://github.com/capcom6/android-sms-gateway" target="_blank" rel="noopener" class="btn btn-outline-primary">
                            <i class="bi bi-github me-1"></i>Official GitHub
                        </a>
                        <a href="https://docs.sms-gate.app/" target="_blank" rel="noopener" class="btn btn-outline-secondary">
                            <i class="bi bi-book me-1"></i>Documentation
                        </a>
                    </div>
                    <p class="text-muted small mt-3 mb-0">
                        Kwenye simu washa Cloud Server mode, kisha copy username/password uziweke kwenye .env ya server.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="bi bi-gear me-2 text-primary"></i>.env Settings</h5>
                    <pre class="bg-dark text-white rounded-3 p-3 mb-0" style="white-space: pre-wrap;"><code>SMS_GATEWAY_ENABLED=true
SMS_GATEWAY_BASE_URL=https://api.sms-gate.app/3rdparty/v1
SMS_GATEWAY_USERNAME=weka_username_ya_app
SMS_GATEWAY_PASSWORD=weka_password_ya_app
SMS_REMINDERS_ENABLED=false
SMS_REMINDERS_BATCH_SIZE=30
SMS_REMINDERS_SLEEP_SECONDS=2</code></pre>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0">
            <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Latest SMS Logs</h5>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Error</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestLogs as $log)
                        <tr>
                            <td>{{ $log->created_at?->format('M d, Y H:i') }}</td>
                            <td>{{ str_replace('_', ' ', $log->type) }}</td>
                            <td>{{ $log->phone }}</td>
                            <td>{{ $log->user?->display_name ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $log->status === 'sent' ? 'bg-success' : ($log->status === 'failed' ? 'bg-danger' : 'bg-secondary') }}">
                                    {{ strtoupper($log->status) }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $log->error_message ? \Illuminate\Support\Str::limit($log->error_message, 80) : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Hakuna SMS logs bado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
