@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Hariri Utembeleo wa Nyumbani</h4>
                    <a href="{{ route('home_visitation.show', $homeVisitation->id) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Rudi
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('home_visitation.update', $homeVisitation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Taarifa za Mshiriki -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Taarifa za Mshiriki</h5>
                                
                                <div class="mb-3">
                                    <label for="jina" class="form-label">Jina <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('jina') is-invalid @enderror" 
                                           id="jina" name="jina" value="{{ old('jina', $homeVisitation->jina) }}" required>
                                    @error('jina')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="namba" class="form-label">Namba <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('namba') is-invalid @enderror" 
                                           id="namba" name="namba" value="{{ old('namba', $homeVisitation->namba) }}" required>
                                    @error('namba')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="shule" class="form-label">Shule <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('shule') is-invalid @enderror" 
                                           id="shule" name="shule" value="{{ old('shule', $homeVisitation->shule) }}" required>
                                    @error('shule')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="darasa" class="form-label">Darasa <span class="text-danger">*</span></label>
                                    <select class="form-select @error('darasa') is-invalid @enderror" id="darasa" name="darasa" required>
                                        <option value="">Chagua Darasa</option>
                                        @for($i = 1; $i <= 7; $i++)
                                            <option value="Darasa la {{ $i }}" {{ old('darasa', $homeVisitation->darasa) == "Darasa la $i" ? 'selected' : '' }}>Darasa la {{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('darasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="last_program" class="form-label">Mpango wa Mwisho <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_program') is-invalid @enderror" 
                                           id="last_program" name="last_program" value="{{ old('last_program', $homeVisitation->last_program) }}" required>
                                    @error('last_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="likes_program" class="form-label">Anapenda Mpango <span class="text-danger">*</span></label>
                                    <select class="form-select @error('likes_program') is-invalid @enderror" id="likes_program" name="likes_program" required>
                                        <option value="">Chagua Jibu</option>
                                        <option value="Ndio" {{ old('likes_program', $homeVisitation->likes_program) == 'Ndio' ? 'selected' : '' }}>Ndio</option>
                                        <option value="Hapana" {{ old('likes_program', $homeVisitation->likes_program) == 'Hapana' ? 'selected' : '' }}>Hapana</option>
                                    </select>
                                    @error('likes_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="participant_comments" class="form-label">Maoni ya Mshiriki</label>
                                    <textarea class="form-control @error('participant_comments') is-invalid @enderror" 
                                              id="participant_comments" name="participant_comments" rows="3">{{ old('participant_comments', $homeVisitation->participant_comments) }}</textarea>
                                    @error('participant_comments')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mazingira ya Nyumbani -->
                            <div class="col-md-6">
                                <h5 class="text-success mb-3">Mazingira ya Nyumbani</h5>
                                
                                <div class="mb-3">
                                    <label for="mtaa" class="form-label">Mtaa <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mtaa') is-invalid @enderror" 
                                           id="mtaa" name="mtaa" value="{{ old('mtaa', $homeVisitation->mtaa) }}" required>
                                    @error('mtaa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="mazingira" class="form-label">Mazingira <span class="text-danger">*</span></label>
                                    <select class="form-select @error('mazingira') is-invalid @enderror" id="mazingira" name="mazingira" required>
                                        <option value="">Chagua Mazingira</option>
                                        <option value="Mazuri" {{ old('mazingira', $homeVisitation->mazingira) == 'Mazuri' ? 'selected' : '' }}>Mazuri</option>
                                        <option value="Wastani" {{ old('mazingira', $homeVisitation->mazingira) == 'Wastani' ? 'selected' : '' }}>Wastani</option>
                                        <option value="Mabaya" {{ old('mazingira', $homeVisitation->mazingira) == 'Mabaya' ? 'selected' : '' }}>Mabaya</option>
                                    </select>
                                    @error('mazingira')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nyumba" class="form-label">Nyumba <span class="text-danger">*</span></label>
                                    <select class="form-select @error('nyumba') is-invalid @enderror" id="nyumba" name="nyumba" required>
                                        <option value="">Chagua Aina ya Nyumba</option>
                                        <option value="Matofali" {{ old('nyumba', $homeVisitation->nyumba) == 'Matofali' ? 'selected' : '' }}>Matofali</option>
                                        <option value="Udongo" {{ old('nyumba', $homeVisitation->nyumba) == 'Udongo' ? 'selected' : '' }}>Udongo</option>
                                        <option value="Mbao" {{ old('nyumba', $homeVisitation->nyumba) == 'Mbao' ? 'selected' : '' }}>Mbao</option>
                                        <option value="Nyingine" {{ old('nyumba', $homeVisitation->nyumba) == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                                    </select>
                                    @error('nyumba')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="paa" class="form-label">Paa <span class="text-danger">*</span></label>
                                    <select class="form-select @error('paa') is-invalid @enderror" id="paa" name="paa" required>
                                        <option value="">Chagua Aina ya Paa</option>
                                        <option value="Bati" {{ old('paa', $homeVisitation->paa) == 'Bati' ? 'selected' : '' }}>Bati</option>
                                        <option value="Makuti" {{ old('paa', $homeVisitation->paa) == 'Makuti' ? 'selected' : '' }}>Makuti</option>
                                        <option value="Tiles" {{ old('paa', $homeVisitation->paa) == 'Tiles' ? 'selected' : '' }}>Tiles</option>
                                        <option value="Nyingine" {{ old('paa', $homeVisitation->paa) == 'Nyingine' ? 'selected' : '' }}>Nyingine</option>
                                    </select>
                                    @error('paa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="choo" class="form-label">Choo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('choo') is-invalid @enderror" id="choo" name="choo" required>
                                        <option value="">Chagua Aina ya Choo</option>
                                        <option value="Kiko" {{ old('choo', $homeVisitation->choo) == 'Kiko' ? 'selected' : '' }}>Kiko</option>
                                        <option value="Hakiko" {{ old('choo', $homeVisitation->choo) == 'Hakiko' ? 'selected' : '' }}>Hakiko</option>
                                    </select>
                                    @error('choo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="milo" class="form-label">Milo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('milo') is-invalid @enderror" id="milo" name="milo" required>
                                        <option value="">Chagua Hali ya Milo</option>
                                        <option value="Tosha" {{ old('milo', $homeVisitation->milo) == 'Tosha' ? 'selected' : '' }}>Tosha</option>
                                        <option value="Haitosha" {{ old('milo', $homeVisitation->milo) == 'Haitosha' ? 'selected' : '' }}>Haitosha</option>
                                    </select>
                                    @error('milo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <!-- Taarifa za Familia -->
                            <div class="col-md-6">
                                <h5 class="text-info mb-3">Taarifa za Familia</h5>
                                
                                <div class="mb-3">
                                    <label for="wanaume" class="form-label">Wanaume <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('wanaume') is-invalid @enderror" 
                                           id="wanaume" name="wanaume" value="{{ old('wanaume', $homeVisitation->wanaume) }}" min="0" required>
                                    @error('wanaume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="wanawake" class="form-label">Wanawake <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('wanawake') is-invalid @enderror" 
                                           id="wanawake" name="wanawake" value="{{ old('wanawake', $homeVisitation->wanawake) }}" min="0" required>
                                    @error('wanawake')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="tabia" class="form-label">Tabia</label>
                                    <textarea class="form-control @error('tabia') is-invalid @enderror" 
                                              id="tabia" name="tabia" rows="3">{{ old('tabia', $homeVisitation->tabia) }}</textarea>
                                    @error('tabia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Taarifa za Utembeleo -->
                            <div class="col-md-6">
                                <h5 class="text-warning mb-3">Taarifa za Utembeleo</h5>
                                
                                <div class="mb-3">
                                    <label for="visit_date" class="form-label">Tarehe ya Utembeleo <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('visit_date') is-invalid @enderror" 
                                           id="visit_date" name="visit_date" value="{{ old('visit_date', $homeVisitation->visit_date) }}" required>
                                    @error('visit_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="mtembelezaji" class="form-label">Mtembelezaji <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mtembelezaji') is-invalid @enderror" 
                                           id="mtembelezaji" name="mtembelezaji" value="{{ old('mtembelezaji', $homeVisitation->mtembelezaji) }}" required>
                                    @error('mtembelezaji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nafasi" class="form-label">Nafasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nafasi') is-invalid @enderror" 
                                           id="nafasi" name="nafasi" value="{{ old('nafasi', $homeVisitation->nafasi) }}" required>
                                    @error('nafasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="maoni" class="form-label">Maoni</label>
                                    <textarea class="form-control @error('maoni') is-invalid @enderror" 
                                              id="maoni" name="maoni" rows="3">{{ old('maoni', $homeVisitation->maoni) }}</textarea>
                                    @error('maoni')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('home_visitation.show', $homeVisitation->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Ghairi
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Hifadhi Mabadiliko
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection