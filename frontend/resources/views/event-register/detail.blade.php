@extends('layouts.front')
@section('content')
    <section class="section" style="margin: 80px; margin-top: 0px;">
        <!-- Event Details Section -->
        <div class="detail-section">
            <div class="container">
                <div class="detail-card" style=";">
                    <div class="row">
                        <div class="col-6">
                            <img class="rounded-4 border-5" src="{{ asset('front/assets/images/banner-item-01.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-6">
                            <h4>{{ $event['name'] }}</h4>

                            <div class="">

                                <div class="info-item mb-0">
                                    <div class="info-icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Date</h6>
                                        <p>
                                            {{-- {{ \Carbon\Carbon::parse($event['start_date'])->format('l, j F Y') }} - --}}
                                            {{-- {{ \Carbon\Carbon::parse($event['end_date'])->format('l, j F Y') }} --}}
                                            {{-- | {{ $event['start_time'] }} - {{ $event['end_time'] }} --}}
                                        </p>
                                        {{-- <p>Friday, July 12, 2025 | 09:00 AM - 06:00 PM</p> --}}
                                    </div>
                                </div>

                                <div class="info-item mb-0">
                                    <div class="info-icon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Venue</h6>
                                        <p>Jakarta Convention Center, Hall A. Jl. Gatot Subroto, Jakarta Pusat</p>
                                    </div>
                                </div>

                                {{-- <div class="info-item mb-0">
                                    <div class="info-icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Capacity</h6>
                                        <p>500 participants | 347 registered</p>
                                    </div>
                                </div> --}}

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fa fa-wallet"></i>
                                    </div>
                                    {{-- <div class="info-content">
                                        <h6>Price</h6>
                                        <p style="font-size: 20px; font-weight:600; color:black">
                                            RP{{ $event['registration_fee'] }} /person </p>
                                    </div> --}}
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('event.register', ['id' => (string) $event['_id']]) }}" class="register-btn">Register Now</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Event Description -->
                <div class="detail-card">

                    <h4>About This Event</h4>
                    <p>
                        {{ $event['description'] }}
                    </p>
                </div>

            </div>
        </div>
    </section>
@endsection
