@extends('layouts.app')

@section('title', isset($masomoYaMtaala) ? 'Edit Curriculum Studies Record' : 'Add New Curriculum Studies Record')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <a href="{{ route('submissions.masomo-ya-mtaala.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Records
                </a>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-book-open me-2"></i>
                        <h4 class="mb-0">
                            {{ isset($masomoYaMtaala) ? 'HARIRI MASOMO YA MTAALA' : 'MASOMO YA MTAALA' }}
                        </h4>
                    </div>
                </div>
            </div>

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

            @php
                $selectedCategory = old('spiritual_category');

                if (!$selectedCategory && isset($existingSubmission)) {
                    if ($existingSubmission->kiroho === 'ndio') {
                        $selectedCategory = 'kiroho';
                    } elseif ($existingSubmission->kimwili === 'ndio') {
                        $selectedCategory = 'kimwili';
                    } elseif ($existingSubmission->kiakili === 'ndio') {
                        $selectedCategory = 'kiakili';
                    } elseif ($existingSubmission->kijamii === 'ndio') {
                        $selectedCategory = 'kijamii';
                    }
                }
            @endphp

            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($masomoYaMtaala) ? route('submissions.masomo-ya-mtaala.update', $masomoYaMtaala) : route('submissions.masomo-ya-mtaala.store') }}" method="POST">
                        @csrf
                        @if(isset($masomoYaMtaala))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="Date" class="form-label fw-bold">1. DATE:</label>
                            <input type="date"
                                   class="form-control"
                                   id="date"
                                   name="date"
                                   value="{{ old('date', isset($existingSubmission) && $existingSubmission->date ? $existingSubmission->date->format('Y-m-d') : date('Y-m-d')) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="jina_la_mwalimu" class="form-label fw-bold">2. JINA LA MWALIMU:</label>
                            <input type="text"
                                   class="form-control"
                                   id="jina_la_mwalimu"
                                   name="jina_la_mwalimu"
                                   value="{{ old('jina_la_mwalimu', $existingSubmission->jina_la_mwalimu ?? '') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="somo_analofundisha" class="form-label fw-bold">3. SOMO ANALOFUNDISHA:</label>
                            <input type="text"
                                   class="form-control"
                                   id="somo_analofundisha"
                                   name="somo_analofundisha"
                                   value="{{ old('somo_analofundisha', $existingSubmission->somo_analofundisha ?? '') }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">4. CHAGUA AINA YA SOMO:</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="spiritual_category"
                                               value="kiroho"
                                               id="category_kiroho"
                                               {{ $selectedCategory === 'kiroho' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kiroho">
                                            <strong>Kiroho</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="spiritual_category"
                                               value="kimwili"
                                               id="category_kimwili"
                                               {{ $selectedCategory === 'kimwili' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kimwili">
                                            <strong>Kimwili</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="spiritual_category"
                                               value="kiakili"
                                               id="category_kiakili"
                                               {{ $selectedCategory === 'kiakili' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kiakili">
                                            <strong>Kiakili</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="spiritual_category"
                                               value="kijamii"
                                               id="category_kijamii"
                                               {{ $selectedCategory === 'kijamii' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_kijamii">
                                            <strong>Kijamii</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="darasa_la_mjaka_mingapi" class="form-label fw-bold">5. DARASA LA MIAKA MINGAPI ANAFUNDISHIA:</label>
                            <select class="form-select" id="darasa_la_mjaka_mingapi" name="darasa_la_mjaka_mingapi">
                                <option value="">Select age...</option>
                                <option value="1" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '1' ? 'selected' : '' }}>Miaka 1</option>
                                <option value="2" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '2' ? 'selected' : '' }}>Miaka 2</option>
                                <option value="3" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '3' ? 'selected' : '' }}>Miaka 3</option>
                                <option value="4" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '4' ? 'selected' : '' }}>Miaka 4</option>
                                <option value="5" {{ old('darasa_la_mjaka_mingapi', $existingSubmission->darasa_la_mjaka_mingapi ?? '') == '5' ? 'selected' : '' }}>Miaka 5</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mada_aliyo_fundisha" class="form-label fw-bold">6. MADA ALIYO FUNDISHA:</label>
                            <textarea class="form-control"
                                      id="mada_aliyo_fundisha"
                                      name="mada_aliyo_fundisha"
                                      rows="3">{{ old('mada_aliyo_fundisha', $existingSubmission->mada_aliyo_fundisha ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="maoni_ya_mwanafunzi" class="form-label fw-bold">7. MAONI YA MWANAFUNZI:</label>
                            <textarea class="form-control"
                                      id="maoni_ya_mwanafunzi"
                                      name="maoni_ya_mwanafunzi"
                                      rows="4">{{ old('maoni_ya_mwanafunzi', $existingSubmission->maoni_ya_mwanafunzi ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="maoni_ya_mwalimu" class="form-label fw-bold">8. MAONI YA MWALIMU:</label>
                            <textarea class="form-control"
                                      id="maoni_ya_mwalimu"
                                      name="maoni_ya_mwalimu"
                                      rows="4">{{ old('maoni_ya_mwalimu', $existingSubmission->maoni_ya_mwalimu ?? '') }}</textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end flex-wrap">
                            <a href="{{ route('submissions.masomo-ya-mtaala.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>

                            <button type="submit" name="action" value="save_draft" class="btn btn-outline-primary">
                                <i class="fas fa-save"></i> Save as Draft
                            </button>

                            <button type="submit" name="action" value="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                {{ isset($masomoYaMtaala) ? 'Update Record' : 'Submit for Review' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
