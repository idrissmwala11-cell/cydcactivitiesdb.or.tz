<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-pencil-square me-2"></i>{{ __('Edit Base Leadership') }}
        </h2>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white">
                <h5 class="mb-0">Edit base leadership information</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('base-leaders.update', $baseLeader) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Base Name</label>
                            <input type="text" name="base_name" class="form-control" value="{{ old('base_name', $baseLeader->base_name) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Number of Leaders</label>
                            <input type="number" name="leaders_count" class="form-control" value="{{ old('leaders_count', $baseLeader->leaders_count) }}" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Number of Meetings</label>
                            <input type="number" name="meeting_count" class="form-control" value="{{ old('meeting_count', $baseLeader->meeting_count) }}" min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Leadership Term End Date</label>
                            <input type="date" name="term_end" class="form-control" value="{{ old('term_end', optional($baseLeader->term_end)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Additional Comments</label>
                            <textarea name="additional_notes" class="form-control" rows="3">{{ old('additional_notes', $baseLeader->additional_notes) }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">Leaders List</h6>
                    <div id="leaders-container">
                        @foreach($baseLeader->baseLeaderDetails as $index => $detail)
                            <div class="row g-3 align-items-end leader-entry mb-3">
                                <div class="col-md-2">
                                    <label class="form-label">No.</label>
                                    <input type="number" name="leaders[{{ $index }}][leader_number]" class="form-control" value="{{ old('leaders.'.$index.'.leader_number', $detail->leader_number) }}" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Leader Name</label>
                                    <input type="text" name="leaders[{{ $index }}][leader_name]" class="form-control" value="{{ old('leaders.'.$index.'.leader_name', $detail->leader_name) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Leader Number</label>
                                    <input type="text" name="leaders[{{ $index }}][leader_id]" class="form-control" value="{{ old('leaders.'.$index.'.leader_id', $detail->leader_id) }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Position</label>
                                    <input type="text" name="leaders[{{ $index }}][leader_position]" class="form-control" value="{{ old('leaders.'.$index.'.leader_position', $detail->leader_position) }}" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-outline-danger remove-leader w-100"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-4" id="add-leader">
                        <i class="bi bi-plus-circle me-1"></i>Add Leader
                    </button>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('base-leaders.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let leaderIndex = {{ $baseLeader->baseLeaderDetails->count() }};

        document.getElementById('add-leader').addEventListener('click', function () {
            const container = document.getElementById('leaders-container');
            const row = document.createElement('div');
            row.className = 'row g-3 align-items-end leader-entry mb-3';
            row.innerHTML = `
                <div class="col-md-2">
                    <label class="form-label">No.</label>
                    <input type="number" name="leaders[${leaderIndex}][leader_number]" class="form-control" value="${leaderIndex + 1}" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Leader Name</label>
                    <input type="text" name="leaders[${leaderIndex}][leader_name]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Leader Number</label>
                    <input type="text" name="leaders[${leaderIndex}][leader_id]" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Position</label>
                    <input type="text" name="leaders[${leaderIndex}][leader_position]" class="form-control" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger remove-leader w-100"><i class="bi bi-trash"></i></button>
                </div>
            `;
            container.appendChild(row);
            leaderIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-leader')) {
                const entries = document.querySelectorAll('.leader-entry');
                if (entries.length > 1) {
                    e.target.closest('.leader-entry').remove();
                }
            }
        });
    </script>
</x-app-layout>
