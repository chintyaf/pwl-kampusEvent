{{-- resources/views/finance/registrations.blade.php --}}
@extends('layouts.app')

@section('title', 'Payment Verification')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Payment Verification</h1>
                <div>
                    <a href="{{ route('finance.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('finance.registrations') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Payment Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="event_id" class="form-label">Event</label>
                    <select name="event_id" id="event_id" class="form-select">
                        <option value="">All Events</option>
                        @foreach($events as $event)
                        <option value="{{ $event['_id'] }}" {{ request('event_id') == $event['_id'] ? 'selected' : '' }}>
                            {{ $event['name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div class="card mb-4" id="bulk-actions" style="display: none;">
        <div class="card-body">
            <form method="POST" action="{{ route('finance.bulk-update') }}" id="bulk-form">
                @csrf
                @method('PUT')
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="bulk_status" class="form-label">Update Status</label>
                        <select name="status" id="bulk_status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="verified">Verified</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="bulk_notes" class="form-label">Notes (Optional)</label>
                        <input type="text" name="notes" id="bulk_notes" class="form-control" 
                               placeholder="Add notes for bulk update...">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Update Selected
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary" onclick="clearSelection()">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Registrations Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Registrations</h5>
            <div>
                <span id="selected-count" class="badge badge-info me-2" style="display: none;"></span>
                <small class="text-muted">
                    Showing {{ count($data['registrations']) }} of {{ $data['pagination']['totalItems'] }} registrations
                </small>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>Registration ID</th>
                            <th>Participant</th>
                            <th>Event</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['registrations'] as $registration)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_registrations[]" 
                                       value="{{ $registration['_id'] }}" class="form-check-input registration-checkbox">
                            </td>
                            <td>
                                <code>{{ $registration['_id'] }}</code>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $registration['participant']['name'] ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $registration['participant']['email'] ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $registration['event']['name'] ?? 'Unknown Event' }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($registration['amount'] ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $status = $registration['paymentStatus'] ?? 'pending';
                                    $badgeClass = match($status) {
                                        'pending' => 'bg-warning text-dark',
                                        'paid' => 'bg-info',
                                        'verified' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                <small>
                                    {{ \Carbon\Carbon::parse($registration['createdAt'])->format('d M Y, H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" 
                                            onclick="viewRegistration('{{ $registration['_id'] }}')"
                                            data-bs-toggle="tooltip" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($registration['paymentProof'] ?? false)
                                    <button type="button" class="btn btn-outline-info" 
                                            onclick="viewPaymentProof('{{ $registration['paymentProof'] }}')"
                                            data-bs-toggle="tooltip" title="View Payment Proof">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                    @endif
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $registration['_id'] }}', 'verified')">
                                                    <i class="fas fa-check text-success"></i> Verify Payment
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $registration['_id'] }}', 'rejected')">
                                                    <i class="fas fa-times text-danger"></i> Reject Payment
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" 
                                                   onclick="updateStatus('{{ $registration['_id'] }}', 'pending')">
                                                    <i class="fas fa-clock text-warning"></i> Set Pending
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>No registrations found matching your criteria.</p>
                                    <a href="{{ route('finance.registrations') }}" class="btn btn-sm btn-primary">
                                        View All Registrations
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($data['pagination']['totalPages'] > 1)
    <nav aria-label="Registrations pagination">
        <ul class="pagination justify-content-center">
            @if($data['pagination']['currentPage'] > 1)
            <li class="page-item">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $data['pagination']['currentPage'] - 1]) }}">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
            </li>
            @endif

            @for($i = max(1, $data['pagination']['currentPage'] - 2); $i <= min($data['pagination']['totalPages'], $data['pagination']['currentPage'] + 2); $i++)
            <li class="page-item {{ $i == $data['pagination']['currentPage'] ? 'active' : '' }}">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
            </li>
            @endfor

            @if($data['pagination']['currentPage'] < $data['pagination']['totalPages'])
            <li class="page-item">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $data['pagination']['currentPage'] + 1]) }}">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    @endif
</div>

{{-- Modal for Registration Details --}}
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationModalLabel">Registration Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="registrationModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Payment Proof --}}
<div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="paymentProofModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentProofModalLabel">Payment Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="paymentProofImage" src="" alt="Payment Proof" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle select all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    const registrationCheckboxes = document.querySelectorAll('.registration-checkbox');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCountBadge = document.getElementById('selected-count');

    selectAllCheckbox.addEventListener('change', function() {
        registrationCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    registrationCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.registration-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === registrationCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < registrationCheckboxes.length;
            updateBulkActions();
        });
    });

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.registration-checkbox:checked');
        if (checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCountBadge.style.display = 'inline';
            selectedCountBadge.textContent = `${checkedBoxes.length} selected`;
        } else {
            bulkActions.style.display = 'none';
            selectedCountBadge.style.display = 'none';
        }
    }

    // Handle bulk form submission
    document.getElementById('bulk-form').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.registration-checkbox:checked');
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one registration to update.');
            return;
        }

        if (!confirm(`Are you sure you want to update ${checkedBoxes.length} registration(s)?`)) {
            e.preventDefault();
            return;
        }

        // Add selected IDs to form
        checkedBoxes.forEach(checkbox => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'registration_ids[]';
            hiddenInput.value = checkbox.value;
            this.appendChild(hiddenInput);
        });
    });
});

function clearSelection() {
    document.getElementById('select-all').checked = false;
    document.querySelectorAll('.registration-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('bulk-actions').style.display = 'none';
    document.getElementById('selected-count').style.display = 'none';
}

function viewRegistration(registrationId) {
    const modal = new bootstrap.Modal(document.getElementById('registrationModal'));
    const modalBody = document.getElementById('registrationModalBody');
    
    modalBody.innerHTML = `
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    // Fetch registration details via AJAX
    fetch(`/finance/registrations/${registrationId}`)
        .then(response => response.json())
        .then(data => {
            modalBody.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Participant Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Name:</strong></td><td>${data.participant?.name || 'N/A'}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${data.participant?.email || 'N/A'}</td></tr>
                            <tr><td><strong>Phone:</strong></td><td>${data.participant?.phone || 'N/A'}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Registration Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Event:</strong></td><td>${data.event?.name || 'Unknown'}</td></tr>
                            <tr><td><strong>Amount:</strong></td><td>Rp ${new Intl.NumberFormat('id-ID').format(data.amount || 0)}</td></tr>
                            <tr><td><strong>Status:</strong></td><td><span class="badge bg-${getStatusColor(data.paymentStatus)}">${data.paymentStatus || 'pending'}</span></td></tr>
                            <tr><td><strong>Date:</strong></td><td>${new Date(data.createdAt).toLocaleDateString('id-ID')}</td></tr>
                        </table>
                    </div>
                </div>
                ${data.notes ? `<div class="mt-3"><h6>Notes</h6><p class="text-muted">${data.notes}</p></div>` : ''}
            `;
        })
        .catch(error => {
            modalBody.innerHTML = '<div class="alert alert-danger">Failed to load registration details.</div>';
        });
}

function viewPaymentProof(proofUrl) {
    const modal = new bootstrap.Modal(document.getElementById('paymentProofModal'));
    document.getElementById('paymentProofImage').src = proofUrl;
    modal.show();
}

function updateStatus(registrationId, status) {
    if (!confirm(`Are you sure you want to ${status} this payment?`)) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/finance/registrations/${registrationId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Failed to update status: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Failed to update status. Please try again.');
    });
}

function getStatusColor(status) {
    switch(status) {
        case 'pending': return 'warning';
        case 'paid': return 'info';
        case 'verified': return 'success';
        case 'rejected': return 'danger';
        default: return 'secondary';
    }
}
</script>
@endpush