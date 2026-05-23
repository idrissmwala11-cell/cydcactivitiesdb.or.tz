@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Maelezo ya Utembeleo wa Nyumbani</h4>
                    <div>
                        <a href="{{ route('home_visitation.edit', $homeVisitation->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Hariri
                        </a>
                        <a href="{{ route('home_visitation.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Rudi
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Taarifa za Mshiriki -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Taarifa za Mshiriki</h5>
                            
                            <div class="mb-3">
                                <strong>Jina:</strong>
                                <p class="mb-1">{{ $homeVisitation->jina }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Namba:</strong>
                                <p class="mb-1">{{ $homeVisitation->namba }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Shule:</strong>
                                <p class="mb-1">{{ $homeVisitation->shule }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Darasa:</strong>
                                <p class="mb-1">{{ $homeVisitation->darasa }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Mpango wa Mwisho:</strong>
                                <p class="mb-1">{{ $homeVisitation->last_program }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Anapenda Mpango:</strong>
                                <p class="mb-1">{{ $homeVisitation->likes_program }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Maoni ya Mshiriki:</strong>
                                <p class="mb-1">{{ $homeVisitation->participant_comments ?: 'Hakuna maoni' }}</p>
                            </div>
                        </div>

                        <!-- Mazingira ya Nyumbani -->
                        <div class="col-md-6">
                            <h5 class="text-success mb-3">Mazingira ya Nyumbani</h5>
                            
                            <div class="mb-3">
                                <strong>Mtaa:</strong>
                                <p class="mb-1">{{ $homeVisitation->mtaa }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Mazingira:</strong>
                                <p class="mb-1">{{ $homeVisitation->mazingira }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Nyumba:</strong>
                                <p class="mb-1">{{ $homeVisitation->nyumba }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Paa:</strong>
                                <p class="mb-1">{{ $homeVisitation->paa }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Choo:</strong>
                                <p class="mb-1">{{ $homeVisitation->choo }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Milo:</strong>
                                <p class="mb-1">{{ $homeVisitation->milo }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Taarifa za Familia -->
                        <div class="col-md-6">
                            <h5 class="text-info mb-3">Taarifa za Familia</h5>
                            
                            <div class="mb-3">
                                <strong>Wanaume:</strong>
                                <p class="mb-1">{{ $homeVisitation->wanaume }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Wanawake:</strong>
                                <p class="mb-1">{{ $homeVisitation->wanawake }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Tabia:</strong>
                                <p class="mb-1">{{ $homeVisitation->tabia ?: 'Hakuna maelezo' }}</p>
                            </div>
                        </div>

                        <!-- Taarifa za Utembeleo -->
                        <div class="col-md-6">
                            <h5 class="text-warning mb-3">Taarifa za Utembeleo</h5>
                            
                            <div class="mb-3">
                                <strong>Tarehe ya Utembeleo:</strong>
                                <p class="mb-1">{{ \Carbon\Carbon::parse($homeVisitation->visit_date)->format('d/m/Y') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Mtembelezaji:</strong>
                                <p class="mb-1">{{ $homeVisitation->mtembelezaji }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Nafasi:</strong>
                                <p class="mb-1">{{ $homeVisitation->nafasi }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Maoni:</strong>
                                <p class="mb-1">{{ $homeVisitation->maoni ?: 'Hakuna maoni' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="text-muted">
                                <small>
                                    <strong>Imeundwa:</strong> {{ $homeVisitation->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Imebadilishwa:</strong> {{ $homeVisitation->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection