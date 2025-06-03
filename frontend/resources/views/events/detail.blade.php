@extends('layouts.front')
@section('content')
    <section class="section" style="margin: 80px; margin-top: 0px;">
        <!-- Event Detail Banner
                        <div class="event-detail-banner">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="event-header">
                                            <span class="event-date-badge">Friday, 12 July 2025</span>
                                            <h1 class="event-title">AI Innovations Summit 2025</h1>
                                            <p class="event-subtitle">A full-day conference showcasing the latest in artificial intelligence, featuring keynote speakers from OpenAI, Google DeepMind, and more.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

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
                            <h4>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet, id!
                                Lorem, ipsum dolor. Lorem, ipsum dolor sit amet
                            </h4>
                            <hr>

                            <div class="">

                                <div class="info-item mb-0">
                                    <div class="info-icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Date & Time</h6>
                                        <p>Friday, July 12, 2025 | 09:00 AM - 06:00 PM</p>
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

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fa fa-wallet"></i>
                                    </div>
                                    <div class="info-content">
                                        <h6>Price</h6>
                                        <p style="font-size: 20px; font-weight:600; color:black">RP750,000 /person    </p>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-end">
                                    <a href="#" class="register-btn">Register Now</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Event Description -->
                <div class="detail-card">

                                        <h4>About This Event</h4>
                    <p>Join us for the most comprehensive AI conference of 2025! The AI Innovations Summit brings together industry leaders, researchers, and innovators to explore the cutting-edge developments in artificial intelligence.</p>

                    <p>This full-day conference will cover topics including:</p>
                    <ul>
                        <li>Latest breakthroughs in machine learning and deep learning</li>
                        <li>AI applications in healthcare, finance, and education</li>
                        <li>Ethical considerations in AI development</li>
                        <li>Future trends and predictions for AI technology</li>
                        <li>Practical workshops and hands-on demonstrations</li>
                    </ul>

                    <p>Whether you're a seasoned AI professional or just starting your journey in artificial intelligence, this summit offers valuable insights and networking opportunities that will advance your understanding and career in this rapidly evolving field.</p>
                </div>

                <!-- Featured Speakers -->
                <div class="detail-card">
                    <h4>Featured Speakers</h4>

                    <div class="col-4 speaker-card" style="margin-bottom: 20px; padding: 20px;">
                        <div class="speaker-avatar">
                            <i class="fa fa-user" style="font-size: 40px; color: #ccc;"></i>
                        </div>
                        <h6>Dr. Sarah Chen</h6>
                        <p style="font-size: 12px; color: #666; margin: 0;">Head of AI Research, OpenAI</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
