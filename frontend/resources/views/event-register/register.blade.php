@extends('layouts.front')
@push('extraCSS')
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('back/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/event-register.css') }}" />
@endpush


@section('content')
    <section id="event-register" class="section" style="margin: 40px; margin-top: 0px;">
        <div class="detail-section">
            <div class="container">
                <form id="formInput">
                    {{-- Input user + events --}}
                    <input type="hidden" name="user_id" id="user_id" value="682d81260dc7fc62f4eb0a6f">
                    <input type="hidden" name="event_id" id="event_id" value="{{ $event['_id'] }}">

                    <!-- Informasi Event -->
                    <div class="detail-card">
                        <div class="mb-4">
                            <h4 class="mb-3 form-title">Event Information</h4>
                            <hr>

                            <x-forms-front.input label="Event Name" name="name" value="{{ $event['name'] }}" disabled />

                            <x-forms-front.textarea label="Description" name="description"
                                value="{{ $event['description'] }}" disabled />

                        </div>
                    </div>

                    <!-- Data Pendaftar Utama -->
                    <div class="detail-card">
                        <div class="mb-4">
                            <h4 class="mb-3 form-title">Visitors Data</h4>
                            <hr>

                            <x-forms-front.input label="Full Name" name="name" value="{{ $user['name'] }}" disabled />
                            <x-forms-front.input type="email" label="Email" name="email" value="{{ $user['email'] }}" disabled />
                            <x-forms-front.input label="Phone Number" name="phone_num" value="" disabled />

                        </div>
                    </div>


                    <div class="detail-card">
                        <div class="mb-4">
                            <label class="col-sm-2 col-form-label" for="session">Session</label>
                            <div class="sessions-list" id="sessionsGrid">
                                @foreach ($event['session'] as $session)
                                    @include('event-register.input.session')
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @include('event-register.input.payment')

                    <!-- Submit Button -->
                    <div class="row mb-5">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div style="background-color: gray;">
            <a href="/event1/payment">Continue</a>
        </div>
    </section>
@endsection
@section('extraJS')
    <script src={{ asset('front/assets/js/event-register.js') }}></script>


    <script>
        function getInitials(name) {
            return name
                .split(" ")
                .map((word) => word[0])
                .join("")
                .toUpperCase();
        }

        // Format date and time
        function formatDateTime(startTime, endTime) {
            const start = new Date(startTime);
            const end = new Date(endTime);
            const dateStr = start.toLocaleDateString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric",
            });
            const timeStr = `${start.toLocaleTimeString("en-US", {
                hour: "numeric",
                minute: "2-digit",
                hour12: false,
            })} - ${end.toLocaleTimeString("en-US", {
                hour: "numeric",
                minute: "2-digit",
                hour12: false,
            })}`;
            return { dateStr, timeStr };
        }

        // Create session card HTML
        function createSessionCard(session) {}
    </script>

<script>
    document.querySelector('#formInput').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;

        const method = document.querySelector('#paymentMethod')?.value;
        const proofFile = document.querySelector('#paymentProof')?.files[0];

        // Placeholder upload (replace with real upload logic)
        const proof_image_url = "test.png";

        // ⬇️ Get selected sessions
        const sessions = selectedSessions.map(session => ({
            id: session.id,
            title: session.title,
            fee: session.fee
        }));

        const data = {
            user_id: document.getElementById("user_id").value,
            event_id: document.getElementById("event_id").value,
            sessions: sessions, // 🔥 include session info
            payment: {
                method,
                proof_image_url
            }
        };

        try {
            const response = await fetch('http://localhost:3000/api/member/event/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message || 'New event added successfully!');
                form.reset();
                window.location.href = "";
            } else {
                alert(result.message || 'Failed to add event');
            }
        } catch (error) {
            alert('Error connecting to server');
            console.error(error);
        }
    });
</script>

@endsection
