@extends('layouts.back')

@push('extraCSS')
    <link rel="stylesheet" href="{{ asset('front/assets/css/fontawesome.css') }}">

        <style>
        img {
            width: 100%;
            overflow: hidden;
        }

        .events .section-heading {
            margin-bottom: 100px;
        }

        .events .item {
            background-color: #ffffff;
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

        .events .item .event-list .event-item {
            display: inline-block;
            /* width: 17.5%; */
            /* vertical-align: middle; */
        }

        .event-list {
            display: flex;
            align-content: center;
            align-items: center;
            justify-content: space-between;
        }

        .events .item .event-list .event-item:first-child {
            width: 35%;
        }

        .events .item .event-list .event-item:nth-of-type(2) {
            width: 28%;
        }

        .events .item .event-list .event-item span.category {
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

        .events .item .event-list .event-item h4 {
            font-size: 22px;
            font-weight: 600;
        }

        .events .item .event-list .event-item span {
            display: inline-block;
            font-size: 14px;
            color: #4a4a4a;
            margin-bottom: 10px;
        }

        .events .item .event-list .event-item h6 {
            font-size: 16px;
            color: #7a6ad8;
            font-weight: 600;
        }
    </style>
@endpush

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
                                    <ul class="event-list">
                                        <li class="event-item">
                                            <h4>{{ $event['name'] }}</h4>
                                        </li>
                                        <li>
                                            <span>Date:</span>
                                            {{-- <h6>{{ $event['start_date'] }}, </h6> --}}
                                        </li>
                                        <li class="event-item">
                                            <div class="btn-group">
                                                <button type="button"
                                                    class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route('events.edit', ['id' => (string) $event['_id']]) }}">Event Details</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('events.view-attendace', ['id' => (string) $event['_id']]) }}">Session Details</a></li>

                                                </ul>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
