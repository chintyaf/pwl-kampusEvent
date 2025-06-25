@extends('layouts.front')
@section('content')
    {{-- @foreach ($event as $event) --}}

    {{-- <!-- Success Banner -->
<div class="success-banner" style="margin-top: 40px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="success-header">
                    <div class="success-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <h1 class="success-title">Registration Successful!</h1>
                    <p class="success-subtitle">Your event registration has been confirmed</p>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <!-- Confirmation Section -->
    <div class="confirmation-section" style="margin-top: 40px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="confirmation-card">
                        <!-- Brand Header -->
                        <div class="brand-header">
                            {{-- <div class="brand-logo">
                            <i class="fa fa-calendar"></i>
                        </div> --}}
                            <h2 class="brand-name">Evoria</h2>
                        </div>

                        <!-- Order ID -->
                        {{-- <div class="order-id">
                        <h6>Order ID</h6>
                        <div class="order-id-number">#KE-2025-001247</div>
                    </div> --}}

                        <!-- Order Title & Description -->
                        <h3 class="order-title">{{ $event['event_id']['name'] }} - Registration Confirmation</h3>

                        <p class="order-description">
                            Thank you for registering for the {{ $event['event_id']['name'] }}! We're excited to have you
                            join us for this comprehensive conference showcasing the latest developments in artificial
                            intelligence. Your registration has been successfully processed and you will receive a
                            confirmation email shortly with additional details about the event.
                        </p>

                        <p class="">
                            Please scan this QR code at the registration desk to confirm your attendance.
                            This code is unique to you, do not share this with anyone.
                        </p>
                        <p class="qr-note">
                            Save this page or take a screenshot for easy access on event day.
                        </p>

                        <div>
                            @foreach ($session as $session)
                            <div class="d-flex align-items-center gap-2">
                                <div class="qr-section">
                                    {{-- <h3 class="qr-title">QR Code</h3> --}}
                                    <div class="qr-placeholder">
                                        <img src="http://localhost:3000{{ $session['qr_code'] }}" alt="">
                                    </div>
                                </div>

                                <div class="event-summary m-4" style="height: 100%">
                                    <div class="event-info">
                                        <div class="event-icon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div class="event-text">
                                            <h6>Event Date & Time</h6>
                                            <p>Friday, July 12, 2025 | 09:00 AM - 06:00 PM</p>
                                        </div>
                                    </div>

                                    <div class="event-info">
                                        <div class="event-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="event-text">
                                            <h6>Registered Name</h6>
                                            <p>John Doe - john.doe@email.com</p>
                                        </div>
                                    </div>

                                    <div class="event-info">
                                        <div class="event-icon">
                                            <i class="fa fa-wallet"></i>
                                        </div>
                                        <div class="event-text">
                                            <h6>Registration Fee</h6>
                                            <p>Rp 750,000 (Early Bird Price) - Paid via Bank Transfer</p>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            @endforeach
                        </div>


                        <!-- Footer Message -->
                        <div class="footer-message">
                            <p><strong>We look forward to your attendance!</strong></p>
                            <p style="margin-top: 15px; font-size: 14px;">
                                If you have any questions, please contact us at <strong>info@kampusevent.com</strong> or
                                <strong>+62 21 1234 5678</strong>
                            </p>

                            <a href="/" class="back-home-btn">
                                <i class="fa fa-home"></i> Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}
@endsection
