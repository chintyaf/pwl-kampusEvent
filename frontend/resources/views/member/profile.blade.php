@extends('layouts.front')
@push('extraCSS')
    <style>
        .events .item a.no-custom-style {
            all: unset;
            display: inline-block;
            background-color: #0d6efd;
            /* atau sesuai btn-primary Bootstrap */
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
            font-size: 0.875rem;
            text-decoration: none;
        }
    </style>
@endpush
@section('content')
    <div class="section events" id="events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Schedule</h6>
                        <h2>Upcoming Events</h2>
                    </div>
                </div>

                @foreach ($event as $ev)
                    <div class="col-lg-12 col-md-6">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="image">
                                        <img src="{{ asset('front/assets/images/event-01.jpg') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <ul>
                                        <li>
                                            <h4 style="min-height: 90px">{{ $ev['event_id']['name'] }}</h4>
                                        </li>

                                        <li>
                                            {{-- <h4>{{ $ev['_id'] }}</h4> --}}

                                            @foreach ($ev['event_id']['session'] as $session)
                                                @foreach ($session['attending_user'] as $att)
                                                    @php
                                                        $attUser = (string) ($att['user'] ?? 'GA ADA');
                                                        $regi = (string) $ev['_id'] ?? null;
                                                        $cetiUrl = $att['certificate_url'] ?? null;
                                                    @endphp
                                                    @if ($attUser === $regi)
                                                        <a href="http://127.0.0.1:3000/{{ $cetiUrl }}"
                                                            class="btn btn-sm btn-primary mb-1 no-custom-style" download>
                                                            <i class="fa fa-download"></i> Certificate:
                                                            {{ $session['title'] ?? 'Session' }}
                                                        </a><br>
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </li>

                                        <li>
                                            <span>Payment Status:</span>
                                            <h6>{{ $ev['payment']['status'] }}</h6>
                                        </li>
                                    </ul>

                                    @if ($ev['payment']['status'] === 'approved')
                                        <a href="{{ route('member.registered', ['id' => (string) $ev['_id']]) }}">
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
