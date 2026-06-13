@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Talent Details') }}</h4>
                    <div>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $talent->user_id)
                            <a href="{{ route('talents.edit', $talent->id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                            </a>
                        @endif

                        <a href="{{ route('talents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">{{ __('Personal Information') }}</h5>

                            <div class="mb-3">
                                <strong>{{ __('Student Name') }}:</strong>
                                <p class="mb-1">{{ $talent->student_name }}</p>
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('Participant Number') }}:</strong>
                                <p class="mb-1">{{ $talent->participant_number }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Age') }}:</strong>
                                    <p class="mb-1">{{ $talent->age }} {{ __('years old') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Gender') }}:</strong>
                                    <p class="mb-1">
                                        <span class="badge bg-{{ $talent->gender === 'Male' ? 'primary' : 'secondary' }}">
                                            {{ $talent->gender }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            @if($talent->mentor)
                                <div class="mb-3">
                                    <strong>{{ __('Mentor') }}:</strong>
                                    <p class="mb-1">{{ $talent->mentor }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-success mb-3">{{ __('Talent Information') }}</h5>

                            <div class="mb-3">
                                <strong>{{ __('Talent Type') }}:</strong>
                                <p class="mb-1">
                                    <span class="badge bg-info fs-6">{{ $talent->talent_type }}</span>
                                </p>
                            </div>

                            <div class="mb-3">
                                <strong>{{ __('Duration') }}:</strong>
                                <p class="mb-1">{{ $talent->talent_duration }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Has Competed') }}:</strong>
                                    <p class="mb-1">
                                        <span class="badge bg-{{ $talent->has_competed ? 'success' : 'secondary' }}">
                                            {{ $talent->has_competed ? __('Yes') : __('No') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('Needs Training') }}:</strong>
                                    <p class="mb-1">
                                        <span class="badge bg-{{ $talent->needs_training ? 'warning' : 'secondary' }}">
                                            {{ $talent->needs_training ? __('Yes') : __('No') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-info mb-3">{{ __('Detailed Information') }}</h5>

                            <div class="mb-3">
                                <strong>{{ __('Talent Description') }}:</strong>
                                <div class="bg-light p-3 rounded mt-2">
                                    {{ $talent->talent_description }}
                                </div>
                            </div>

                            @if($talent->has_competed && $talent->competition_details)
                                <div class="mb-3">
                                    <strong>{{ __('Competition Details') }}:</strong>
                                    <div class="bg-light p-3 rounded mt-2">
                                        {{ $talent->competition_details }}
                                    </div>
                                </div>
                            @endif

                            @if($talent->achievements)
                                <div class="mb-3">
                                    <strong>{{ __('Achievements') }}:</strong>
                                    <div class="bg-light p-3 rounded mt-2">
                                        {{ $talent->achievements }}
                                    </div>
                                </div>
                            @endif

                            @if($talent->needs_training && $talent->training_details)
                                <div class="mb-3">
                                    <strong>{{ __('Training Details') }}:</strong>
                                    <div class="bg-light p-3 rounded mt-2">
                                        {{ $talent->training_details }}
                                    </div>
                                </div>
                            @endif

                            @if($talent->comments)
                                <div class="mb-3">
                                    <strong>{{ __('Comments') }}:</strong>
                                    <div class="bg-light p-3 rounded mt-2">
                                        {{ $talent->comments }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">{{ __('Record Information') }}</h6>
                            <small class="text-muted">
                                {{ __('Created') }}: {{ $talent->created_at->format('M d, Y \\a\\t H:i') }}
                                @if($talent->updated_at != $talent->created_at)
                                    | {{ __('Last Updated') }}: {{ $talent->updated_at->format('M d, Y \\a\\t H:i') }}
                                @endif
                                @if($talent->user)
                                    | {{ __('By') }}: <x-user-identity :user="$talent->user" :size="28" />
                                @endif
                            </small>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $talent->user_id)
                            <a href="{{ route('talents.edit', $talent->id) }}" class="btn btn-warning me-md-2">
                                <i class="fas fa-edit"></i> {{ __('Edit Talent') }}
                            </a>

                            <form action="{{ route('talents.destroy', $talent->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('{{ __('Are you sure you want to delete this talent record?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger me-md-2">
                                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('talents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> {{ __('Back to List') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
