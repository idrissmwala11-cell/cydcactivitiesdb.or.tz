@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Home Visitation Form
                    </h5>
                    <a href="{{ route('home-visitation.show', $homeVisitation) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('home-visitation.update', $homeVisitation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- PARTICIPANT INFORMATION --}}
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">PARTICIPANT INFORMATION</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="jina" class="form-label">1. Participant Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('jina') is-invalid @enderror" 
                                               id="jina" name="jina" value="{{ old('jina', $homeVisitation->jina) }}" required>
                                        @error('jina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="namba" class="form-label">2. Participant Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('namba') is-invalid @enderror" 
                                               id="namba" name="namba" value="{{ old('namba', $homeVisitation->namba) }}" required>
                                        @error('namba') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shule" class="form-label">3. School Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shule') is-invalid @enderror" 
                                               id="shule" name="shule" value="{{ old('shule', $homeVisitation->shule) }}" required>
                                        @error('shule') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="darasa" class="form-label">4. Class Level <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('darasa') is-invalid @enderror" 
                                               id="darasa" name="darasa" value="{{ old('darasa', $homeVisitation->darasa) }}" required>
                                        @error('darasa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_program" class="form-label">5. Last Time the Participant Attended the Program <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_program') is-invalid @enderror" 
                                               id="last_program" name="last_program" value="{{ old('last_program', $homeVisitation->last_program) }}" required>
                                        @error('last_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="likes_program" class="form-label">6. Does the Participant Still Like the Program? <span class="text-danger">*</span></label>
                                        <select class="form-select @error('likes_program') is-invalid @enderror" id="likes_program" name="likes_program" required>
                                            <option value="">-- Select --</option>
                                            <option value="Yes" {{ old('likes_program', $homeVisitation->likes_program) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ old('likes_program', $homeVisitation->likes_program) == 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('likes_program') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="participant_comments" class="form-label">7. Participant Comments</label>
                                        <textarea class="form-control @error('participant_comments') is-invalid @enderror" 
                                                  id="participant_comments" name="participant_comments" rows="3">{{ old('participant_comments', $homeVisitation->participant_comments) }}</textarea>
                                        @error('participant_comments') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LIVING CONDITIONS --}}
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">LIVING CONDITIONS</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="mtaa" class="form-label">8. Residence / Street <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mtaa') is-invalid @enderror" 
                                               id="mtaa" name="mtaa" value="{{ old('mtaa', $homeVisitation->mtaa) }}" required>
                                        @error('mtaa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mazingira" class="form-label">9. Living Environment <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mazingira') is-invalid @enderror" 
                                               id="mazingira" name="mazingira" value="{{ old('mazingira', $homeVisitation->mazingira) }}" required>
                                        @error('mazingira') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nyumba" class="form-label">10. House Ownership <span class="text-danger">*</span></label>
                                        <select class="form-select @error('nyumba') is-invalid @enderror" id="nyumba" name="nyumba" required>
                                            <option value="">-- Select --</option>
                                            <option value="Owned" {{ old('nyumba', $homeVisitation->nyumba) == 'Owned' ? 'selected' : '' }}>Owned</option>
                                            <option value="Loan" {{ old('nyumba', $homeVisitation->nyumba) == 'Loan' ? 'selected' : '' }}>Loan</option>
                                            <option value="Rented" {{ old('nyumba', $homeVisitation->nyumba) == 'Rented' ? 'selected' : '' }}>Rented</option>
                                        </select>
                                        @error('nyumba') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="paa" class="form-label">11. Roof Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('paa') is-invalid @enderror" id="paa" name="paa" required>
                                            <option value="">-- Select --</option>
                                            <option value="Iron Sheets" {{ old('paa', $homeVisitation->paa) == 'Iron Sheets' ? 'selected' : '' }}>Iron Sheets</option>
                                            <option value="Grass" {{ old('paa', $homeVisitation->paa) == 'Grass' ? 'selected' : '' }}>Grass</option>
                                            <option value="Other" {{ old('paa', $homeVisitation->paa) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('paa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="choo" class="form-label">12. Toilet Availability <span class="text-danger">*</span></label>
                                        <select class="form-select @error('choo') is-invalid @enderror" id="choo" name="choo" required>
                                            <option value="">-- Select --</option>
                                            <option value="Has Toilet" {{ old('choo', $homeVisitation->choo) == 'Has Toilet' ? 'selected' : '' }}>Has Toilet</option>
                                            <option value="No Toilet" {{ old('choo', $homeVisitation->choo) == 'No Toilet' ? 'selected' : '' }}>No Toilet</option>
                                        </select>
                                        @error('choo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="milo" class="form-label">13. Number of Meals per Day <span class="text-danger">*</span></label>
                                        <select class="form-select @error('milo') is-invalid @enderror" id="milo" name="milo" required>
                                            <option value="">-- Select --</option>
                                            <option value="1" {{ old('milo', $homeVisitation->milo) == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('milo', $homeVisitation->milo) == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('milo', $homeVisitation->milo) == '3' ? 'selected' : '' }}>3</option>
                                            <option value="More than 3" {{ old('milo', $homeVisitation->milo) == 'More than 3' ? 'selected' : '' }}>More than 3</option>
                                        </select>
                                        @error('milo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FAMILY INFORMATION --}}
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">FAMILY INFORMATION</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="wanaume" class="form-label">14. Number of Male Family Members <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('wanaume') is-invalid @enderror" 
                                               id="wanaume" name="wanaume" value="{{ old('wanaume', $homeVisitation->wanaume) }}" min="0" required>
                                        @error('wanaume') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="wanawake" class="form-label">15. Number of Female Family Members <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('wanawake') is-invalid @enderror" 
                                               id="wanawake" name="wanawake" value="{{ old('wanawake', $homeVisitation->wanawake) }}" min="0" required>
                                        @error('wanawake') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="tabia" class="form-label">16. Participant Behavior</label>
                                        <textarea class="form-control @error('tabia') is-invalid @enderror" 
                                                  id="tabia" name="tabia" rows="3">{{ old('tabia', $homeVisitation->tabia) }}</textarea>
                                        @error('tabia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- VISITOR INFORMATION --}}
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">VISITOR INFORMATION</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="visit_date" class="form-label">17. Visit Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('visit_date') is-invalid @enderror" 
                                               id="visit_date" name="visit_date" value="{{ old('visit_date', $homeVisitation->visit_date ? $homeVisitation->visit_date->format('Y-m-d') : '') }}" required>
                                        @error('visit_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mtembelezaji" class="form-label">18. Visitor Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mtembelezaji') is-invalid @enderror" 
                                               id="mtembelezaji" name="mtembelezaji" value="{{ old('mtembelezaji', $homeVisitation->mtembelezaji) }}" required>
                                        @error('mtembelezaji') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nafasi" class="form-label">19. Visitor Position <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nafasi') is-invalid @enderror" 
                                               id="nafasi" name="nafasi" value="{{ old('nafasi', $homeVisitation->nafasi) }}" required>
                                        @error('nafasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="maoni" class="form-label">20. Visit Comments</label>
                                        <textarea class="form-control @error('maoni') is-invalid @enderror" 
                                                  id="maoni" name="maoni" rows="4">{{ old('maoni', $homeVisitation->maoni) }}</textarea>
                                        @error('maoni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('home-visitation.show', $homeVisitation) }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Update Form
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
