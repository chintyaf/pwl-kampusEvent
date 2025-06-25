@extends('layouts.front')

@section('content')
<section class="section" style="margin: 80px; margin-top: 0px;">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="mb-3">Welcome to Guest Area</h2>
                    <p class="lead">Discover and register for upcoming events</p>
                </div>
            </div>
        </div>

        <!-- Error Message (if any) -->
        @if(isset($error))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    {{ $error }}
                </div>
            </div>
        </div>
        @endif

        <!-- Events Grid -->
        <div class="row">
            @if(isset($events) && count($events) > 0)
                @foreach($events as $event)
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="detail-card h-100">
                        <div class="row h-100">
                            <!-- Event Image -->
                            <div class="col-12 col-md-5">
                                <img class="img-fluid rounded-3 border-3 w-100" 
                                     src="{{ asset('front/assets/images/banner-item-01.jpg') }}" 
                                     alt="{{ $event['name'] ?? 'Event Image' }}"
                                     style="height: 200px; object-fit: cover;">
                            </div>
                            
                            <!-- Event Details -->
                            <div class="col-12 col-md-7 d-flex flex-column">
                                <div class="flex-grow-1">
                                    <h5 class="mb-3">{{ $event['name'] ?? 'Event Name' }}</h5>
                                    
                                    <!-- Date Info -->
                                    <div class="info-item mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="info-icon me-2">
                                                <i class="fa fa-calendar text-primary"></i>
                                            </div>
                                            <div class="info-content">
                                                <small class="text-muted">Date</small>
                                                <p class="mb-0 small">
                                                    @if(isset($event['start_date']))
                                                        {{ \Carbon\Carbon::parse($event['start_date'])->format('M j, Y') }}
                                                        @if(isset($event['end_date']) && $event['start_date'] != $event['end_date'])
                                                            - {{ \Carbon\Carbon::parse($event['end_date'])->format('M j, Y') }}
                                                        @endif
                                                    @else
                                                        TBA
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Time Info -->
                                    @if(isset($event['start_time']) || isset($event['end_time']))
                                    <div class="info-item mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="info-icon me-2">
                                                <i class="fa fa-clock text-primary"></i>
                                            </div>
                                            <div class="info-content">
                                                <small class="text-muted">Time</small>
                                                <p class="mb-0 small">
                                                    {{ $event['start_time'] ?? '00:00' }} - {{ $event['end_time'] ?? '23:59' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Location Info -->
                                    <div class="info-item mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="info-icon me-2">
                                                <i class="fa fa-map-marker text-primary"></i>
                                            </div>
                                            <div class="info-content">
                                                <small class="text-muted">Venue</small>
                                                <p class="mb-0 small">
                                                    {{ $event['location'] ?? 'Jakarta Convention Center, Hall A' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Info -->
                                    @if(isset($event['registration_fee']))
                                    <div class="info-item mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="info-icon me-2">
                                                <i class="fa fa-wallet text-primary"></i>
                                            </div>
                                            <div class="info-content">
                                                <small class="text-muted">Price</small>
                                                <p class="mb-0 fw-bold text-success">
                                                    @if($event['registration_fee'] == 0)
                                                        FREE
                                                    @else
                                                        Rp {{ number_format($event['registration_fee'], 0, ',', '.') }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Short Description -->
                                    @if(isset($event['description']))
                                    <div class="mb-3">
                                        <p class="text-muted small mb-0">
                                            {{ Str::limit($event['description'], 100) }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-auto">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('event.detail', ['id' => (string) $event['_id']]) }}" 
                                           class="btn btn-outline-primary btn-sm flex-fill">
                                            View Details
                                        </a>
                                        <a href="{{ route('eventreg.register', ['id' => (string) $event['_id']]) }}" 
                                           class="btn btn-primary btn-sm flex-fill">
                                            Register
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- No Events Available -->
                <div class="col-12">
                    <div class="detail-card text-center py-5">
                        <div class="mb-4">
                            <i class="fa fa-calendar-times fa-3x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No Events Available</h4>
                        <p class="text-muted">There are currently no events to display. Please check back later.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination (if needed) -->
        @if(isset($events) && method_exists($events, 'links'))
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $events->links() }}
            </div>
        </div>
        @endif

        <!-- Guest Info Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="detail-card bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">Want to access more features?</h5>
                            <p class="mb-0 text-muted">
                                Create an account to track your registrations, receive updates, and get exclusive access to member-only events.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('register') }}" class="btn btn-success me-2">Sign Up</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-success">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.detail-card {
    background: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.detail-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.info-item {
    margin-bottom: 15px;
}

.info-icon {
    width: 20px;
    text-align: center;
}

.register-btn, .btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    padding: 8px 20px;
    border-radius: 25px;
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.register-btn:hover, .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    color: white;
    text-decoration: none;
}

.btn-outline-primary {
    border: 2px solid #007bff;
    color: #007bff;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #007bff;
    color: white;
    transform: translateY(-1px);
}

.btn-success {
    background: linear-gradient(45deg, #28a745, #1e7e34);
    border: none;
    border-radius: 25px;
    font-weight: 500;
}

.btn-outline-success {
    border: 2px solid #28a745;
    color: #28a745;
    border-radius: 25px;
    font-weight: 500;
}

.btn-outline-success:hover {
    background: #28a745;
    color: white;
}

@media (max-width: 768px) {
    section.section {
        margin: 20px !important;
        margin-top: 0px !important;
    }
    
    .detail-card {
        padding: 15px;
    }
}
</style>
@endsection