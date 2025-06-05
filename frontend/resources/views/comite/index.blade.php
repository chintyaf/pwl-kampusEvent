@extends('layouts.back')
@section('content')
    <div class="section events" id="events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h2>Events</h2>
                        <a href="{{ route('event.add') }}">New Event</a>
                    </div>
                </div>
                @if ($events)

                @foreach ($events as $event)
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
                                        <h4>{{ $event['name'] }}</h4>
                                    </li>
                                    <li>
                                        <span>Date:</span>
                                        <h6>{{ $event['date'] }}, </h6>
                                    </li>
                                    <li>
                                        <span>Time : </span>
                                        <h6>{{ $event['start_time'] }} - {{ $event['end_time'] }}</h6>
                                    </li>
                                    <li>
                                        <span>Price:</span>
                                        <h6>{{ $event['registration_fee'] }}</h6>
                                    </li>
                                </ul>
                                <a href="{{ route('events.edit', $event['_id']) }}"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div>
    </div>

    <style>
        img {
            width: 100%;
            overflow: hidden;
        }

        .events .section-heading {
            margin-bottom: 100px;
        }

        .events .item {
            background-color: #f1f0fe;
            border-radius: 25px;
            position: relative;
            padding: 40px;
            margin-bottom: 96px;
        }

        .events .item .image {
            position: relative;
        }

        .events .item .image img {
            position: absolute;
            border-radius: 25px;
            max-width: 260px;
            left: 0;
            top: -70px;
        }

        .events .item ul li {
            display: inline-block;
            width: 17.5%;
            vertical-align: middle;
        }

        .events .item ul li:first-child {
            width: 35%;
        }

        .events .item ul li:nth-of-type(2) {
            width: 28%;
        }

        .events .item ul li span.category {
            font-size: 14px;
            text-transform: uppercase;
            color: #7a6ad8;
            background-color: #fff;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 20px;
        }

        .events .item ul li h4 {
            font-size: 22px;
            font-weight: 600;
        }

        .events .item ul li span {
            display: inline-block;
            font-size: 14px;
            color: #4a4a4a;
            margin-bottom: 10px;
        }

        .events .item ul li h6 {
            font-size: 16px;
            color: #7a6ad8;
            font-weight: 600;
        }

        .events .item a {
            position: absolute;
            right: 0;
            top: 22px;
            background-color: #7a6ad8;
            width: 60px;
            height: 120px;
            display: inline-block;
            text-align: center;
            line-height: 120px;
            font-size: 18px;
            z-index: 1;
            color: #fff;
            border-radius: 60px 0px 0px 60px;
        }
    </style>
@endsection
