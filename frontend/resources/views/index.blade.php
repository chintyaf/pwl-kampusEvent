@extends('layouts.front')
@section('content')
    <style>
        .main-banner {
            background-image: url("{{ asset('front/assets/images/banner-bg.jpg') }}");
            background-position: right bottom;
            background-repeat: no-repeat;
            background-size: cover;
            padding: 120px 0px 120px 0px;
        }

        .main-banner .item-1 {
            background-image: url(" {{ asset('front/assets/images/banner-item-01.jpg') }} ");
        }

        .main-banner .item-2 {
            background-image: url(" {{ asset('front/assets/images/banner-item-02.jpg') }} ");
        }

        .main-banner .item-3 {
            background-image: url(" {{ asset('front/assets/images/banner-item-03.jpg') }} ");
        }
    </style>

    <div class="main-banner" id="top">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        <div class="item item-1">
                            <div class="header-text">
                                <span class="category">Friday, 12 July 2025</span>
                                <h2>AI Innovations Summit 2025</h2>
                                <p>
                                    A full-day conference showcasing the latest in artificial intelligence, featuring
                                    keynote speakers from OpenAI, Google DeepMind, and more.
                                </p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Learn More</a>
                                    </div>
                                    <!-- <div class="icon-button">
                                <a href="#"><i class="fa fa-play"></i> What's Scholar?</a>
                              </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="item item-2">
                            <div class="header-text">
                                <span class="category">Tuesday, 5 May 2025</span>
                                <h2>Mobile App Hackathon</h2>
                                <p>
                                    24-hour hackathon for developers and designers to build innovative mobile apps. Prizes
                                    for best UI/UX, functionality, and creativity.
                                </p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Learn More</a>
                                    </div>
                                    <!-- <div class="icon-button">
                                <a href="#"><i class="fa fa-play"></i> What's the best result?</a>
                              </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="item item-3">
                            <div class="header-text">
                                <span class="category">Monday, 1 December 2025</span>
                                <h2>Intro to Cybersecurity Workshop</h2>
                                <p>Description: Hands-on workshop covering the fundamentals of cybersecurity, ethical
                                    hacking basics, and securing web applications.</p>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Learn More</a>
                                    </div>
                                    <!-- <div class="icon-button">
                                <a href="#"><i class="fa fa-play"></i> What's Online Course?</a>
                              </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section courses" id="courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <!-- <h6>Latest Events</h6> -->
                        <h2>Upcoming Event</h2>
                    </div>
                </div>
            </div>
            <!-- <ul class="event_filter">
                    <li>
                      <a class="is_active" href="#!" data-filter="*">Show All</a>
                    </li>
                    <li>
                      <a href="#!" data-filter=".design">Webdesign</a>
                    </li>
                    <li>
                      <a href="#!" data-filter=".development">Development</a>
                    </li>
                    <li>
                      <a href="#!" data-filter=".wordpress">Wordpress</a>
                    </li>
                  </ul> -->
            <div class="row event_box">
                @foreach ($events as $event)
                    <div id="event-item" class="col-lg-4 col-md-6 align-self-center mb-30 event_outer col-md-6 design">
                        <a href="{{ route('event.view', ['id' => (string) $event['_id']]) }}">
                            <div class="events_item">
                                <div class="thumb">
                                    <img src="{{ asset('front/assets/images/course-01.jpg') }}" alt="">
                                    <!-- <span class="category">Webdesign</span> -->
                                    <!-- <span class="price"><h6><em>$</em>160<   /h6></span> -->
                                </div>
                                <div class="down-content">
                                    <h4>{{ $event['name'] }}</h4>
                                    {{-- <span class="author">{{ $event['date'] }}</span> --}}
                                    {{-- <p class="price">{{ $event['registration_fee'] }}</p> --}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--
            <div class="section events" id="events">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-12 text-center">
                      <div class="section-heading">
                        <h6>Schedule</h6>
                        <h2>Upcoming Events</h2>
                      </div>
                    </div>
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
                                <span class="category">Web Design</span>
                                <h4>UI Best Practices</h4>
                              </li>
                              <li>
                                <span>Date:</span>
                                <h6>16 Feb 2036</h6>
                              </li>
                              <li>
                                <span>Duration:</span>
                                <h6>22 Hours</h6>
                              </li>
                              <li>
                                <span>Price:</span>
                                <h6>$120</h6>
                              </li>
                            </ul>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                      <div class="item">
                        <div class="row">
                          <div class="col-lg-3">
                            <div class="image">
                              <img src="{{ asset('front/assets/images/event-02.jpg') }}" alt="">
                            </div>
                          </div>
                          <div class="col-lg-9">
                            <ul>
                              <li>
                                <span class="category">Front End</span>
                                <h4>New Design Trend</h4>
                              </li>
                              <li>
                                <span>Date:</span>
                                <h6>24 Feb 2036</h6>
                              </li>
                              <li>
                                <span>Duration:</span>
                                <h6>30 Hours</h6>
                              </li>
                              <li>
                                <span>Price:</span>
                                <h6>$320</h6>
                              </li>
                            </ul>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                      <div class="item">
                        <div class="row">
                          <div class="col-lg-3">
                            <div class="image">
                              <img src="assets/images/event-03.jpg" alt="">
                            </div>
                          </div>
                          <div class="col-lg-9">
                            <ul>
                              <li>
                                <span class="category">Full Stack</span>
                                <h4>Web Programming</h4>
                              </li>
                              <li>
                                <span>Date:</span>
                                <h6>12 Mar 2036</h6>
                              </li>
                              <li>
                                <span>Duration:</span>
                                <h6>48 Hours</h6>
                              </li>
                              <li>
                                <span>Price:</span>
                                <h6>$440</h6>
                              </li>
                            </ul>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
@endsection
