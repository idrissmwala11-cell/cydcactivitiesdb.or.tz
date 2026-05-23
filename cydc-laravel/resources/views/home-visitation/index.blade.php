@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-house-door me-2"></i>
                        Rekodi za Kumtembelea Mshiriki
                    </h5>
                    <a href="{{ route('home-visitation.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>
                        Ongeza Rekodi Mpya
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Jina la Mshiriki</th>
                                    <th>Tarehe ya Kutembelea</th>
                                    <th>Shule</th>
                                    <th>Mtembelezaji</th>
                                    <th>Vitendo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($homeVisitations ?? [] as $visitation)
                                    <tr>
                                        <td>{{ $visitation->id }}</td>
                                        <td>{{ $visitation->jina ?? 'Hakuna' }}</td>
                                        <td>{{ $visitation->visit_date ? $visitation->visit_date->format('M d, Y') : 'Hakuna' }}</td>
                                        <td>{{ $visitation->shule ?? 'Hakuna' }}</td>
                                        <td>{{ $visitation->mtembelezaji ?? 'Hakuna' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('home-visitation.show', $visitation) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('home-visitation.edit', $visitation) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('home-visitation.destroy', $visitation) }}" method="POST" class="d-inline" onsubmit="return confirm('Je, una uhakika unataka kufuta rekodi hii?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-house-door text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2 mb-0">Hakuna rekodi za kumtembelea mshiriki.</p>
                                            <a href="{{ route('home-visitation.create') }}" class="btn btn-primary mt-2">
                                                <i class="bi bi-plus-circle me-1"></i>
                                                Ongeza Rekodi ya Kwanza
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($homeVisitations) && method_exists($homeVisitations, 'links'))
                        <div class="mt-4">
                            {{ $homeVisitations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection