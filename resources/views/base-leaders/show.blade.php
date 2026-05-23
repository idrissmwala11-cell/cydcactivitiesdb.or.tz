<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-eye me-2"></i>{{ __('Base Leadership Details') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">{{ $baseLeader->base_name }}</h5>
                <a href="{{ route('base-leaders.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
            <div class="card-body">
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="text-muted small">Number of Leaders</div>
                            <div class="fw-bold fs-4">{{ $baseLeader->leaders_count }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="text-muted small">Number of Meetings</div>
                            <div class="fw-bold fs-4">{{ $baseLeader->meeting_count ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="text-muted small">Term End Date</div>
                            <div class="fw-bold">{{ $baseLeader->term_end?->format('d M Y') ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="text-muted small">Submitted By</div>
                            <div class="fw-bold">{{ $baseLeader->user->center_id ?? $baseLeader->user->email ?? $baseLeader->user->name ?? 'Legacy record' }}</div>
                        </div>
                    </div>
                </div>

                @if($baseLeader->additional_notes)
                    <div class="mb-4">
                        <h6>Additional Notes</h6>
                        <div class="border rounded-3 p-3 bg-light">{{ $baseLeader->additional_notes }}</div>
                    </div>
                @endif

                <h6 class="mb-3">Leaders List</h6>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Leader Name</th>
                                <th>Leader Number</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($baseLeader->baseLeaderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->leader_number }}</td>
                                    <td>{{ $detail->leader_name }}</td>
                                    <td>{{ $detail->leader_id }}</td>
                                    <td>{{ $detail->leader_position }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No leaders have been added.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(auth()->user()->role === 'admin' || $baseLeader->user_id === auth()->id())
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('base-leaders.edit', $baseLeader) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('base-leaders.destroy', $baseLeader) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
