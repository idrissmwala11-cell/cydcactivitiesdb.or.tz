@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('submissions.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <!-- Section Header -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-book-open me-2"></i>
                        <h4 class="mb-0">MASOMO YA MTAALA</h4>
                    </div>
                </div>
            </div>

            <!-- Status Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('submissions.masomo-ya-mtaala.store') }}" method="POST">
                        @csrf
                        
                        <!-- 1. TAREHE -->
                        <div class="mb-3">
                            <label for="tarehe" class="form-label fw-bold">1. TAREHE:</label>
                            <input type="date" class="form-control" id="tarehe" name="tarehe" 
                                   value="{{ old('tarehe', $existingSubmission->tarehe ?? '') }}" required>
                        </div>

                        <!-- 2. JINA LA MWALIMU -->
                        <div class="mb-3">
                            <label for="jina_la_mwalimu" class="form-label fw-bold">2. JINA LA MWALIMU:</label>
                            <input type="text" class="form-control" id="jina_la_mwalimu" name="jina_la_mwalimu" 
                                   value="{{ old('jina_la_mwalimu', $existingSubmission->jina_la_mwalimu ?? '') }}" required>
                        </div>

                        <!-- 3. SOMO ANALOFUNDISHA -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">3. SOMO ANALOFUNDISHA:</label>
                            <input type="text" class="form-control" name="somo_analofundisha" 
                                   value="{{ old('somo_analofundisha', $existingSubmission->somo_analofundisha ?? '') }}" required>
                        </div>

                        <!-- Spiritual Category Selection -->
                        <div class="mb-3">
                            <label for="spiritual_category" class="form-label fw-bold">3. CHAGUA AINA YA KIROHO:</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="spiritual_category" value="kiroho" id="category_kiroho"
                                               {{ old('spiritual_category', $existingSubmission->spiritual_category ?? '') == 'kiroho' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kiroho">
                                            <strong>Kiroho</strong>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="spiritual_category" value="kimwili" id="category_kimwili"
                                               {{ old('spiritual_category', $existingSubmission->spiritual_category ?? '') == 'kimwili' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kimwili">
                                            <strong>Kimwili</strong>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="spiritual_category" value="kiakili" id="category_kiakili"
                                               {{ old('spiritual_category', $existingSubmission->spiritual_category ?? '') == 'kiakili' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kiakili">
                                            <strong>Kiakili</strong>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="spiritual_category" value="kijamii" id="category_kijamii"
                                               {{ old('spiritual_category', $existingSubmission->spiritual_category ?? '') == 'kijamii' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kijamii">
                                            <strong>Kijamii</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. DARASA LA MJAKA MINGAPI ANAFUNDISHIA -->
                        <div class="mb-3">
                            <label for="darasa_la_mjaka_mingapi" class="form-label fw-bold">4. DARASA LA MJAKA MINGAPI ANAFUNDISHIA:</label>
                            <select class="form-select" id="darasa_la_mjaka_mingapi" name="darasa_la_mjaka_mingapi">
                                <option value="">Chagua umri...</option>
                                <option value="1" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '1' ? 'selected' : '' }}>Miaka 1</option>
                                <option value="2" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '2' ? 'selected' : '' }}>Miaka 2</option>
                                <option value="3" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '3' ? 'selected' : '' }}>Miaka 3</option>
                                <option value="4" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '4' ? 'selected' : '' }}>Miaka 4</option>
                                <option value="5" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '5' ? 'selected' : '' }}>Miaka 5</option>
                            </select>
                        </div>

                        <!-- 5. MADA ALIYO FUNDISHA -->
                        <div class="mb-3">
                            <label for="mada_aliyo_fundisha" class="form-label fw-bold">5. MADA ALIYO FUNDISHA:</label>
                            <textarea class="form-control" id="mada_aliyo_fundisha" name="mada_aliyo_fundisha" rows="3">{{ old('mada_aliyo_fundisha', $existingSubmission->mada_aliyo_fundisha ?? '') }}</textarea>
                        </div>

                        <!-- 6. MAONI YA MWANAFUNZI -->
                        <div class="mb-3">
                            <label for="maoni_ya_mwanafunzi" class="form-label fw-bold">6. MAONI YA MWANAFUNZI:</label>
                            <textarea class="form-control" id="maoni_ya_mwanafunzi" name="maoni_ya_mwanafunzi" rows="4">{{ old('maoni_ya_mwanafunzi', $existingSubmission->maoni_ya_mwanafunzi ?? '') }}</textarea>
                        </div>

                        <!-- 7. MAONI YA MWALIMU -->
                        <div class="mb-3">
                            <label for="maoni_ya_mwalimu" class="form-label fw-bold">7. MAONI YA MWALIMU:</label>
                            <textarea class="form-control" id="maoni_ya_mwalimu" name="maoni_ya_mwalimu" rows="4">{{ old('maoni_ya_mwalimu', $existingSubmission->maoni_ya_mwalimu ?? '') }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" name="action" value="save_draft" class="btn btn-outline-primary">
                                <i class="fas fa-save"></i> Save as Draft
                            </button>
                            <button type="submit" name="action" value="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Submit for Review
                            </button>
                            @if(isset($existingSubmission) && $existingSubmission->status === 'draft')
                                <a href="#" class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this draft?')) { /* Add delete functionality */ }">
                                    <i class="fas fa-trash"></i> Delete Draft
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection