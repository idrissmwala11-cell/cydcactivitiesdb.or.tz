@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-book me-2"></i>
                        {{ $section['title'] }} Details
                    </h5>
                    <div>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $schoolInformationRecord->user_id)
                            <a href="{{ route($section['route'] . '.edit', $schoolInformationRecord) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route($section['route'] . '.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">RECORD INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach(($schoolInformationRecord->form_data ?? []) as $key => $value)
                                    <div class="col-md-6 mb-3">
                                        <strong>{{ ucwords(str_replace(['_', '-'], ' ', $key)) }}:</strong>
                                        @if(is_array($value))
                                            <pre class="mb-0 mt-1">{{ json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                        @else
                                            <p class="mb-0">{{ $value ?: 'No information provided' }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">SUBMISSION INFORMATION</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Submitted by:</strong>
                                    <p class="mb-0">{{ $schoolInformationRecord->user->center_id ?? $schoolInformationRecord->user->email ?? $schoolInformationRecord->user->name ?? 'Legacy record' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Submission date:</strong>
                                    <p class="mb-0">{{ $schoolInformationRecord->created_at?->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
