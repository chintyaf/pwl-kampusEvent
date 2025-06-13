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

                            <x-forms-front.input label="Full Name" name="name" value="" disabled />
                            <x-forms-front.input type="email" label="Email" name="email" value="" disabled />
                            <x-forms-front.input label="Phone Number" name="phone_num" value="" disabled />

                            {{-- <div id="visitors-list" class="mb-3">
                                @include('event-register.input.visitor')
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-secondary" onclick="addVisitor()">➕ Tambah
                                        Pengunjung</button>
                                </div>
                            </div> --}}

                        </div>
                    </div>


                    <div class="detail-card">
                        <div class="mb-4">
                            <label class="col-sm-2 col-form-label" for="session">Session</label>
                            <div class="sessions-list">
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
        document.querySelector('#formInput').addEventListener('submit', async function(e) {
            console.log(document.querySelector('#formInput'));
            e.preventDefault();

            const form = e.target;
            const visitorGroups = document.querySelectorAll('.visitor-item');
            const visitors = [];

            visitorGroups.forEach(group => {
                const name = group.querySelector('input[name*="[name]"]')?.value;
                const email = group.querySelector('input[name*="[email]"]')?.value;
                const phone_num = group.querySelector('input[name*="[phone_num]"]')?.value;

                if (name && email && phone_num) {
                    visitors.push({
                        name: name,
                        email: email,
                        phone_num: phone_num
                    });
                }
            });

            console.log(visitors)

            const method = document.querySelector('#paymentMethod')?.value;
            const proofFile = document.querySelector('#paymentProof')?.files[0];

            // You must upload the file first to get the URL
            // const proof_image_url = await uploadFileToCloud(proofFile); // implement this
            const proof_image_url = "test.png"

            const data = {
                user_id: document.getElementById("user_id").value,
                event_id: document.getElementById("event_id").value,
                visitors: visitors,
                payment: {
                    method,
                    proof_image_url
                }
            };
            // console.log(response)

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
