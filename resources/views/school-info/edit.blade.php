@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit {{ $section['title'] }}
                    </h5>
                    <a href="{{ route($section['route'] . '.show', $schoolInformationRecord) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route($section['route'] . '.update', $schoolInformationRecord) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            @foreach(($schoolInformationRecord->form_data ?? []) as $key => $value)
                                @php
                                    $raw = old("form_data.$key", is_array($value) ? json_encode($value) : $value);
                                    $isNumeric = is_numeric($raw);
                                    $isLong = is_string($raw) && strlen($raw) > 120;
                                @endphp

                                <div class="col-md-6">
                                    <label class="form-label">{{ ucwords(str_replace(['_', '-'], ' ', $key)) }}</label>
                                    @if(is_array($value) || $isLong)
                                        <textarea name="form_data[{{ $key }}]" rows="4" class="form-control">{{ $raw }}</textarea>
                                    @elseif($isNumeric)
                                        <input type="number" step="any" name="form_data[{{ $key }}]" value="{{ $raw }}" class="form-control">
                                    @else
                                        <input type="text" name="form_data[{{ $key }}]" value="{{ $raw }}" class="form-control">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route($section['route'] . '.show', $schoolInformationRecord) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
