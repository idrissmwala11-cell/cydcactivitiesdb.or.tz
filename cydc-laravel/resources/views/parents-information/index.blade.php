@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ __('Parents Information') }}</h4>
                    @if(!Auth::user()->is_admin)
                        <a href="{{ route('parents-information.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> {{ __('Add New Parent') }}
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" 
                                       placeholder="Search by name, child, activity, or support type..." 
                                       class="form-control"
                                       id="searchInput">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="supportFilter">
                                    <option value="">All Support Types</option>
                                    <option value="Hapana">Hapana</option>
                                    <option value="HVC">HVC</option>
                                    <option value="IGA">IGA</option>
                                    <option value="CIV">CIV</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Parents Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="parentsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th><i class="bi bi-person"></i> Parent Name</th>
                                    <th><i class="bi bi-people"></i> Parent Of</th>
                                    <th><i class="bi bi-activity"></i> Activity</th>
                                    <th><i class="bi bi-hand-thumbs-up"></i> Support Type</th>
                                    <th><i class="bi bi-person-check"></i> Submitted By</th>
                                    <th><i class="bi bi-check-circle"></i> Status</th>
                                    <th><i class="bi bi-gear"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parentsInformation as $parent)
                                    <tr>
                                        <td>{{ $parent->parent_name }}</td>
                                        <td>{{ $parent->parent_of }}</td>
                                        <td>{{ $parent->activity }}</td>
                                        <td>{{ $parent->support_type }}</td>
                                        <td>{{ $parent->user->center_id ?? 'No Center ID' }}</td>
                                        <td>
                                            @php
                                                $statusColor = match($parent->status ?? 'pending') {
                                                    'approved' => 'bg-success',
                                                    'rejected' => 'bg-danger',
                                                    default => 'bg-warning'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusColor }}">
                                                {{ ucfirst($parent->status ?? 'pending') }}
                                            </span>
                                            @if($parent->admin_comments)
                                                <i class="bi bi-chat-text ms-1" 
                                                   data-bs-toggle="tooltip" 
                                                   title="{{ $parent->admin_comments }}"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('parents-information.show', $parent) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if(Auth::user()->is_admin)
                                                    @if(($parent->status ?? 'pending') === 'pending')
                                                        <button class="btn btn-sm btn-outline-success" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#approveModal{{ $parent->id }}">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#rejectModal{{ $parent->id }}">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                                <a href="{{ route('parents-information.edit', $parent) }}" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if(Auth::user()->is_admin)
                                                    <form action="{{ route('parents-information.destroy', $parent) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this parent record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="bi bi-inbox"></i> No parent records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($parentsInformation->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $parentsInformation->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval and Rejection Modals -->
@foreach($parentsInformation as $parent)
    <!-- Approval Modal -->
    <div class="modal fade" id="approveModal{{ $parent->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('parents-information.approve', $parent->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Are you sure you want to approve the submission for <strong>{{ $parent->parent_name }}</strong>?</p>
                        <div class="mb-3">
                            <label for="admin_comments_approve_{{ $parent->id }}" class="form-label">Admin Comments (Optional)</label>
                            <textarea class="form-control" id="admin_comments_approve_{{ $parent->id }}" name="admin_comments" rows="3" placeholder="Add any comments about this approval..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectModal{{ $parent->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('parents-information.reject', $parent->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Are you sure you want to reject the submission for <strong>{{ $parent->parent_name }}</strong>?</p>
                        <div class="mb-3">
                            <label for="admin_comments_reject_{{ $parent->id }}" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="admin_comments_reject_{{ $parent->id }}" name="admin_comments" rows="3" placeholder="Please provide a reason for rejection..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Search and Filter JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const supportFilter = document.getElementById('supportFilter');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value.toLowerCase();
            const supportValue = supportFilter.value.toLowerCase();

            tableRows.forEach(row => {
                if (row.cells.length <= 1) return; // Skip "no records" row
                // Columns: 0=parent_name, 1=parent_of, 2=activity, 3=support_type, 4=submitted_by, 5=status
                const parentName = row.cells[0].textContent.toLowerCase();
                const parentOf = row.cells[1].textContent.toLowerCase();
                const activity = row.cells[2].textContent.toLowerCase();
                const supportType = row.cells[3].textContent.toLowerCase();
                const status = row.cells[5].textContent.toLowerCase();

                const matchesSearch = [parentName, parentOf, activity, supportType].some(text => text.includes(searchTerm));
                const matchesStatus = !statusValue || status.includes(statusValue);
                const matchesSupport = !supportValue || supportType.includes(supportValue);

                row.style.display = (matchesSearch && matchesStatus && matchesSupport) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        supportFilter.addEventListener('change', filterTable);
    });
</script>
@endsection