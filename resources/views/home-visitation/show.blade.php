@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-house-door me-2"></i>
                        Home Visitation Details
                    </h5>

                    <div>
                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $homeVisitation->user_id)
                            <a href="{{ route('home-visitation.edit', $homeVisitation->id) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i>
                                Edit
                            </a>
                        @endif

                        <a href="{{ route('home-visitation.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Back
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">PARTICIPANT INFORMATION</h6>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>1. Participant Name:</strong>
                                    <p class="mb-0">{{ $homeVisitation->jina ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>2. Participant Number:</strong>
                                    <p class="mb-0">{{ $homeVisitation->namba ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>3. School Name:</strong>
                                    <p class="mb-0">{{ $homeVisitation->shule ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>4. Class Level:</strong>
                                    <p class="mb-0">{{ $homeVisitation->darasa ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>5. Last Time Attending the Program:</strong>
                                    <p class="mb-0">{{ $homeVisitation->last_program ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>6. Does the Participant Still Like the Program?</strong>
                                    <br>
                                    <span class="badge bg-{{ $homeVisitation->likes_program == 'Yes' ? 'success' : 'danger' }}">
                                        {{ $homeVisitation->likes_program ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>7. Participant Comments:</strong>
                                <p class="mb-0">{{ $homeVisitation->participant_comments ?? 'No comments' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">LIVING CONDITIONS</h6>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>8. Residence / Street:</strong>
                                    <p class="mb-0">{{ $homeVisitation->mtaa ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>9. Living Environment:</strong>
                                    <p class="mb-0">{{ $homeVisitation->mazingira ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>10. House Ownership:</strong>
                                    <br>
                                    <span class="badge bg-info">{{ $homeVisitation->nyumba ?? 'N/A' }}</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>11. Roof Type:</strong>
                                    <br>
                                    <span class="badge bg-secondary">{{ $homeVisitation->paa ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>12. Toilet Availability:</strong>
                                    <br>
                                    <span class="badge bg-{{ $homeVisitation->choo == 'Has Toilet' ? 'success' : 'warning' }}">
                                        {{ $homeVisitation->choo ?? 'N/A' }}
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>13. Number of Meals per Day:</strong>
                                    <br>
                                    <span class="badge bg-primary">{{ $homeVisitation->milo ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">FAMILY INFORMATION</h6>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>14. Number of Male Family Members:</strong>
                                    <br>
                                    <span class="badge bg-primary fs-6">{{ $homeVisitation->wanaume ?? 0 }}</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>15. Number of Female Family Members:</strong>
                                    <br>
                                    <span class="badge bg-danger fs-6">{{ $homeVisitation->wanawake ?? 0 }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>16. Participant Behavior:</strong>
                                <p class="mb-0">{{ $homeVisitation->tabia ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            <h6 class="mb-0">VISITOR INFORMATION</h6>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>17. Visit Date:</strong>
                                    <br>
                                    <span class="badge bg-dark">
                                        {{ $homeVisitation->visit_date ? $homeVisitation->visit_date->format('d/m/Y') : 'N/A' }}
                                    </span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>18. Visitor Name:</strong>
                                    <p class="mb-0">{{ $homeVisitation->mtembelezaji ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>19. Visitor Position:</strong>
                                    <br>
                                    <span class="badge bg-success">{{ $homeVisitation->nafasi ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>20. Visit Comments:</strong>
                                <p class="mb-0">{{ $homeVisitation->maoni ?? 'No comments' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">USER INFORMATION</h6>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Submitted by:</strong>
                                    <p class="mb-0"><x-user-identity :user="$homeVisitation->user" :show-email="true" /></p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <strong>Created at:</strong>
                                    <p class="mb-0">{{ $homeVisitation->created_at ? $homeVisitation->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home-visitation.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Back to List
                        </a>

                        @if(auth()->user()->role === 'admin' || auth()->id() === (int) $homeVisitation->user_id)
                            <div>
                                <a href="{{ route('home-visitation.edit', $homeVisitation->id) }}" class="btn btn-warning me-2">
                                    <i class="bi bi-pencil"></i>
                                    Edit
                                </a>

                                <form action="{{ route('home-visitation.destroy', $homeVisitation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                        <i class="bi bi-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
