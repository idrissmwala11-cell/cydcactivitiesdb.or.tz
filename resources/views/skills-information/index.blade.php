@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Skills Information Records') }}</h4>
                    <x-module-report-actions module="skills_information">
                        <a href="{{ route('skills-information.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> {{ __('Add New Record') }}
                        </a>
                    </x-module-report-actions>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($skillsInformation->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('Student Name') }}</th>
                                        <th>{{ __('Gender') }}</th>
                                        <th>{{ __('Skill Category') }}</th>
                                        <th>{{ __('Skill Level') }}</th>
                                        <th>{{ __('Submitted By') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($skillsInformation as $skill)
                                        <tr>
                                            <td>{{ $skill->student_name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $skill->gender === 'Male' ? 'primary' : 'secondary' }}">
                                                    {{ $skill->gender }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $skill->skill_category }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $skill->skill_level }}
                                                </span>
                                            </td>

                                            <td><x-user-identity :user="$skill->user" :show-email="true" /></td>

                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('skills-information.show', $skill->id) }}" class="btn btn-sm btn-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                    @if(auth()->user()->role === 'admin' || auth()->id() === (int) $skill->user_id)
                                                        <a href="{{ route('skills-information.edit', $skill->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <form action="{{ route('skills-information.destroy', $skill->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $skillsInformation->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-tools display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('No skills information records found') }}</h5>
                            <p class="text-muted">{{ __('Start by adding your first skills information record.') }}</p>
                            <a href="{{ route('skills-information.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> {{ __('Add New Record') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
