{{-- resources/views/finance/dashboard.blade.php --}}
@extends('layouts.finance')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Finance Dashboard</h1>
                <div>
                    <a href="{{ route('finance.registrations') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> View All Registrations
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $data['summary']['totalRegistrations'] }}</h4>
                            <p class="card-text">Total Registrations</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $data['summary']['verifiedPayments'] }}</h4>
                            <p class="card-text">Verified Payments</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $data['summary']['pendingPayments'] }}</h4>
                            <p class="card-text">Pending Payments</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $data['summary']['paidRegistrations'] }}</h4>
                            <p class="card-text">Paid Registrations</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Event Payment Summary --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Payment Summary by Event</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Total Registrations</th>
                                    <th>Verified</th>
                                    <th>Pending</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data['eventPaymentSummary'] as $event)
                                <tr>
                                    <td>{{ $event['_id']['eventName'] }}</td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $event['totalRegistrations'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            {{ $event['verifiedCount'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">
                                            {{ $event['pendingCount'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($event['totalRevenue'], 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No events found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Payment Activities</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($data['recentActivities'] as $activity)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $activity['memberName'] }}</div>
                                    <small class="text-muted">{{ $activity['eventId']['name'] ?? 'Unknown Event' }}</small>
                                </div>
                                <span class="badge badge-{{ $activity['paymentStatus'] == 'verified' ? 'success' : ($activity['paymentStatus'] == 'pending' ? 'warning' : 'info') }}">
                                    {{ ucfirst($activity['paymentStatus']) }}
                                </span>
                            </div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($activity['registrationDate'])->diffForHumans() }}
                            </small>
                        </div>
                        @empty
                        <div class="list-group-item px-0 text-center">
                            <small class="text-muted">No recent activities</small>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.875em;
}

.list-group-item {
    border-left: 0;
    border-right: 0;
}

.list-group-item:first-child {
    border-top: 0;
}

.list-group-item:last-child {
    border-bottom: 0;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
});
</script>
@endpush
@endsection