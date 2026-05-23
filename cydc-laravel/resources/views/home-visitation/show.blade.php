@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-house-door me-2"></i>
                        Taarifa za Kumtembelea Mshiriki
                    </h5>
                    <div>
                        <a href="{{ route('home-visitation.edit', $homeVisitation) }}" class="btn btn-warning me-2">
                            <i class="bi bi-pencil me-1"></i>
                            Hariri
                        </a>
                        <a href="{{ route('home-visitation.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Rudi Nyuma
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- TAARIFA ZA MSHIRIKI -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">TAARIFA ZA MSHIRIKI</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>1. Jina la Mshiriki:</strong>
                                    <p class="mb-0">{{ $homeVisitation->jina ?? 'Hakuna taarifa' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>2. Namba ya Mshiriki:</strong>
                                    <p class="mb-0">{{ $homeVisitation->namba ?? 'Hakuna taarifa' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>3. Jina la shule anayosoma Mshiriki:</strong>
                                    <p class="mb-0">{{ $homeVisitation->shule ?? 'Hakuna taarifa' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>4. Darasa analosoma Mshiriki:</strong>
                                    <p class="mb-0">{{ $homeVisitation->darasa ?? 'Hakuna taarifa' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>5. Mara ya mwisho kuhudhuria program ni lini?</strong>
                                    <p class="mb-0">{{ $homeVisitation->last_program ?? 'Hakuna taarifa' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>6. Je bado unaipenda program?</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ $homeVisitation->likes_program == 'Ndio' ? 'success' : 'danger' }}">
                                            {{ $homeVisitation->likes_program ?? 'Hakuna taarifa' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>7. Maoni ya mshiriki:</strong>
                                <p class="mb-0">{{ $homeVisitation->participant_comments ?? 'Hakuna maoni' }}</p>
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
                                    <strong>8. Mahali anakoishi / mtaa:</strong>
                                    <p class="mb-0">{{ $homeVisitation->mtaa ?? 'Hakuna taarifa' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>9. Mazingira anayoishi Mshiriki:</strong>
                                    <p class="mb-0">{{ $homeVisitation->mazingira ?? 'Hakuna taarifa' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>10. Nyumba ni yao:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-info">{{ $homeVisitation->nyumba ?? 'Hakuna taarifa' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>11. Aina ya paa:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-secondary">{{ $homeVisitation->paa ?? 'Hakuna taarifa' }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>12. Wanachuo au hawana choo:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-{{ $homeVisitation->chuo == 'Wanachuo' ? 'success' : 'warning' }}">
                                            {{ $homeVisitation->chuo ?? 'Hakuna taarifa' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>13. Idadi ya milo wapatayo kwa siku:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-primary">{{ $homeVisitation->milo ?? 'Hakuna taarifa' }}</span>
                                    </p>
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
                                    <strong>14. Idadi ya wanafamilia wa kiume:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-primary fs-6">{{ $homeVisitation->wanaume ?? 0 }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>15. Idadi ya wanafamilia wa kike:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-pink fs-6">{{ $homeVisitation->wanawake ?? 0 }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>16. Tabia ya Mshiriki:</strong>
                                <p class="mb-0">{{ $homeVisitation->tabia ?? 'Hakuna taarifa' }}</p>
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
                                    <strong>17. Tarehe aliyo mtembelea mshiriki:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-dark">{{ $homeVisitation->visit_date ? $homeVisitation->visit_date->format('d/m/Y') : 'Hakuna taarifa' }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>19. Jina la aliye mtembelea Mshiriki:</strong>
                                    <p class="mb-0">{{ $homeVisitation->mtembelezaji ?? 'Hakuna taarifa' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>20. Nafasi yake:</strong>
                                    <p class="mb-0">
                                        <span class="badge bg-success">{{ $homeVisitation->nafasi ?? 'Hakuna taarifa' }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>18. Maoni ya kumtembelea Mshiriki:</strong>
                                <p class="mb-0">{{ $homeVisitation->maoni ?? 'Hakuna maoni' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- TAARIFA ZA MTUMIAJI -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0">TAARIFA ZA MTUMIAJI</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Imeandikwa na:</strong>
                                    <p class="mb-0">{{ $homeVisitation->user->name ?? 'Hakuna taarifa' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Tarehe ya kuandika:</strong>
                                    <p class="mb-0">{{ $homeVisitation->created_at ? $homeVisitation->created_at->format('d/m/Y H:i') : 'Hakuna taarifa' }}</p>
                                </div>
                            </div>
                            @if($homeVisitation->updated_at && $homeVisitation->updated_at != $homeVisitation->created_at)
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong>Mara ya mwisho kubadilishwa:</strong>
                                        <p class="mb-0">{{ $homeVisitation->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home-visitation.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Rudi kwenye Orodha
                        </a>
                        <div>
                            <a href="{{ route('home-visitation.edit', $homeVisitation) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil me-1"></i>
                                Hariri Rekodi
                            </a>
                            <form action="{{ route('home-visitation.destroy', $homeVisitation) }}" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i>
                                    Futa Rekodi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection