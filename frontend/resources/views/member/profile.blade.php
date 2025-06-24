@extends('layouts.front')

{{-- @section('title', 'Dashboard') --}}

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
                @foreach ($event as $event)
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
                                        {{-- <span class="category">Web Design</span> --}}
                                        <h4 style="min-height: 90px">{{ $event['event_id']['name'] }}</h4>
                                    </li>
                                    {{-- <li>
                                        <span>Date:</span>
                                        <h6>16 Feb 2036</h6>
                                    </li>
                                    <li>
                                        <span>Duration:</span>
                                        <h6>22 Hours</h6>
                                    </li> --}}
                                    <li>
                                        <span>Payment Status:</span>
                                        <h6>{{ $event['payment']['status'] }}</h6>
                                    </li>
                                </ul>
                                @if ($event['payment']['status'] == 'approved')
                                <a href="{{ route('member.registered', ['id' => (string) $event['_id']]) }}"><i class="fa fa-angle-right"></i></a>
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
