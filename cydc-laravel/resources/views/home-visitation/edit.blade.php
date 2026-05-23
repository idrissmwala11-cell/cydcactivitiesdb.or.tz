@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil me-2"></i>
                        Hariri Fomu ya Kumtembelea Mshiriki
                    </h5>
                    <a href="{{ route('home-visitation.show', $homeVisitation) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Rudi Nyuma
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('home-visitation.update', $homeVisitation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- TAARIFA ZA MSHIRIKI -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">TAARIFA ZA MSHIRIKI</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jina" class="form-label">1. Jina la Mshiriki <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('jina') is-invalid @enderror" 
                                               id="jina" name="jina" value="{{ old('jina', $homeVisitation->jina) }}" required>
                                        @error('jina')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="namba" class="form-label">2. Namba ya Mshiriki <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('namba') is-invalid @enderror" 
                                               id="namba" name="namba" value="{{ old('namba', $homeVisitation->namba) }}" required>
                                        @error('namba')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="shule" class="form-label">3. Jina la shule anayosoma Mshiriki <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('shule') is-invalid @enderror" 
                                               id="shule" name="shule" value="{{ old('shule', $homeVisitation->shule) }}" required>
                                        @error('shule')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="darasa" class="form-label">4. Darasa analosoma Mshiriki <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('darasa') is-invalid @enderror" 
                                               id="darasa" name="darasa" value="{{ old('darasa', $homeVisitation->darasa) }}" required>
                                        @error('darasa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="last_program" class="form-label">5. Mara ya mwisho kuhudhuria program ni lini? <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_program') is-invalid @enderror" 
                                               id="last_program" name="last_program" value="{{ old('last_program', $homeVisitation->last_program) }}" required>
                                        @error('last_program')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="likes_program" class="form-label">6. Je bado unaipenda program? <span class="text-danger">*</span></label>
                                        <select class="form-select @error('likes_program') is-invalid @enderror" id="likes_program" name="likes_program" required>
                                            <option value="">--Chagua--</option>
                                            <option value="Ndio" {{ old('likes_program', $homeVisitation->likes_program) == 'Ndio' ? 'selected' : '' }}>Ndio</option>
                                            <option value="Hapana" {{ old('likes_program', $homeVisitation->likes_program) == 'Hapana' ? 'selected' : '' }}>Hapana</option>
                                        </select>
                                        @error('likes_program')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="participant_comments" class="form-label">7. Maoni ya mshiriki</label>
                                    <textarea class="form-control @error('participant_comments') is-invalid @enderror" 
                                              id="participant_comments" name="participant_comments" rows="3">{{ old('participant_comments', $homeVisitation->participant_comments) }}</textarea>
                                    @error('participant_comments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAARIFA ZA MAKAZI -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">TAARIFA ZA MAKAZI</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="mtaa" class="form-label">8. Mahali anakoishi / mtaa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mtaa') is-invalid @enderror" 
                                               id="mtaa" name="mtaa" value="{{ old('mtaa', $homeVisitation->mtaa) }}" required>
                                        @error('mtaa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="mazingira" class="form-label">9. Mazingira anayoishi Mshiriki <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mazingira') is-invalid @enderror" 
                                               id="mazingira" name="mazingira" value="{{ old('mazingira', $homeVisitation->mazingira) }}" required>
                                        @error('mazingira')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nyumba" class="form-label">10. Nyumba ni yao <span class="text-danger">*</span></label>
                                        <select class="form-select @error('nyumba') is-invalid @enderror" id="nyumba" name="nyumba" required>
                                            <option value="">--Chagua--</option>
                                            <option value="Yao" {{ old('nyumba', $homeVisitation->nyumba) == 'Yao' ? 'selected' : '' }}>Yao</option>
                                            <option value="Mkopo" {{ old('nyumba', $homeVisitation->nyumba) == 'Mkopo' ? 'selected' : '' }}>Mkopo</option>
                                            <option value="Mpangaji" {{ old('nyumba', $homeVisitation->nyumba) == 'Mpangaji' ? 'selected' : '' }}>Mpangaji</option>
                                        </select>
                                        @error('nyumba')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="paa" class="form-label">11. Aina ya paa <span class="text-danger">*</span></label>
                                        <select class="form-select @error('paa') is-invalid @enderror" id="paa" name="paa" required>
                                            <option value="">--Chagua--</option>
                                            <option value="Bati" {{ old('paa', $homeVisitation->paa) == 'Bati' ? 'selected' : '' }}>Bati</option>
                                            <option value="Nyasi" {{ old('paa', $homeVisitation->paa) == 'Nyasi' ? 'selected' : '' }}>Nyasi</option>
                                            <option value="Nyingine" {{ old('paa', $homeVisitation->paa) == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                                        </select>
                                        @error('paa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="choo" class="form-label">12. Wanachoo au hawana choo <span class="text-danger">*</span></label>
                                        <select class="form-select @error('choo') is-invalid @enderror" id="choo" name="choo" required>
                                            <option value="">--Chagua--</option>
                                            <option value="Wanachoo" {{ old('choo', $homeVisitation->choo) == 'Wanachoo' ? 'selected' : '' }}>Wanachoo</option>
                                            <option value="Hawana choo" {{ old('choo', $homeVisitation->choo) == 'Hawana choo' ? 'selected' : '' }}>Hawana choo</option>
                                        </select>
                                        @error('choo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="milo" class="form-label">13. Idadi ya milo wapatayo kwa siku <span class="text-danger">*</span></label>
                                        <select class="form-select @error('milo') is-invalid @enderror" id="milo" name="milo" required>
                                            <option value="">--Chagua--</option>
                                            <option value="1" {{ old('milo', $homeVisitation->milo) == '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('milo', $homeVisitation->milo) == '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('milo', $homeVisitation->milo) == '3' ? 'selected' : '' }}>3</option>
                                            <option value="Zaidi ya 3" {{ old('milo', $homeVisitation->milo) == 'Zaidi ya 3' ? 'selected' : '' }}>Zaidi ya 3</option>
                                        </select>
                                        @error('milo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAARIFA ZA FAMILIA -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">TAARIFA ZA FAMILIA</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="wanaume" class="form-label">14. Idadi ya wanafamilia wa kiume <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('wanaume') is-invalid @enderror" 
                                               id="wanaume" name="wanaume" value="{{ old('wanaume', $homeVisitation->wanaume) }}" min="0" required>
                                        @error('wanaume')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="wanawake" class="form-label">15. Idadi ya wanafamilia wa kike <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('wanawake') is-invalid @enderror" 
                                               id="wanawake" name="wanawake" value="{{ old('wanawake', $homeVisitation->wanawake) }}" min="0" required>
                                        @error('wanawake')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tabia" class="form-label">16. Tabia ya Mshiriki</label>
                                    <textarea class="form-control @error('tabia') is-invalid @enderror" 
                                              id="tabia" name="tabia" rows="3">{{ old('tabia', $homeVisitation->tabia) }}</textarea>
                                    @error('tabia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAARIFA ZA ALIE MTEMBELEA -->
                        <div class="card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">TAARIFA ZA ALIE MTEMBELEA</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="visit_date" class="form-label">17. Tarehe aliyo mtembelea mshiriki <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('visit_date') is-invalid @enderror" 
                                               id="visit_date" name="visit_date" value="{{ old('visit_date', $homeVisitation->visit_date ? $homeVisitation->visit_date->format('Y-m-d') : '') }}" required>
                                        @error('visit_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="mtembelezaji" class="form-label">19. Jina la aliye mtembelea Mshiriki <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mtembelezaji') is-invalid @enderror" 
                                               id="mtembelezaji" name="mtembelezaji" value="{{ old('mtembelezaji', $homeVisitation->mtembelezaji) }}" required>
                                        @error('mtembelezaji')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nafasi" class="form-label">20. Nafasi yake <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nafasi') is-invalid @enderror" 
                                               id="nafasi" name="nafasi" value="{{ old('nafasi', $homeVisitation->nafasi) }}" required>
                                        @error('nafasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="maoni" class="form-label">18. Maoni ya kumtembelea Mshiriki</label>
                                    <textarea class="form-control @error('maoni') is-invalid @enderror" 
                                              id="maoni" name="maoni" rows="4">{{ old('maoni', $homeVisitation->maoni) }}</textarea>
                                    @error('maoni')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('home-visitation.show', $homeVisitation) }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-x-circle me-1"></i>
                                Ghairi
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>
                                SASISHA FOMU
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection