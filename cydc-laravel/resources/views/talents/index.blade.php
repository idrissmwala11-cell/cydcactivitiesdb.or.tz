@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Talents Management') }}</h4>
                    <a href="{{ route('talents.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Add New Talent') }}
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($talents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('Student Name') }}</th>
                                        <th>{{ __('Participant #') }}</th>
                                        <th>{{ __('Age') }}</th>
                                        <th>{{ __('Gender') }}</th>
                                        <th>{{ __('Talent Type') }}</th>
                                        <th>{{ __('Duration') }}</th>
                                        <th>{{ __('Competed') }}</th>
                                        <th>{{ __('Needs Training') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($talents as $talent)
                                        <tr>
                                            <td>{{ $talent->student_name }}</td>
                                            <td>{{ $talent->participant_number }}</td>
                                            <td>{{ $talent->age }}</td>
                                            <td>
                                                <span class="badge bg-{{ $talent->gender === 'Male' ? 'primary' : 'pink' }}">
                                                    {{ $talent->gender }}
                                                </span>
                                            </td>
                                            <td>{{ $talent->talent_type }}</td>
                                            <td>{{ $talent->talent_duration }}</td>
                                            <td>
                                                <span class="badge bg-{{ $talent->has_competed ? 'success' : 'secondary' }}">
                                                    {{ $talent->has_competed ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $talent->needs_training ? 'warning' : 'secondary' }}">
                                                    {{ $talent->needs_training ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('talents.show', $talent) }}" class="btn btn-sm btn-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('talents.edit', $talent) }}" class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('talents.destroy', $talent) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this talent record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $talents->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('No talent records found') }}</h5>
                            <p class="text-muted">{{ __('Start by adding your first talent record.') }}</p>
                            <a href="{{ route('talents.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Add New Talent') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection