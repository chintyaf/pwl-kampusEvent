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
                <form id="formInput" action="{{ route('eventreg.store', ['id' => (string) $event['_id']]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Input user + events --}}
                    <input type="hidden" name="sessions" id="selectedSessions">
                    <input type="hidden" name="user_id" id="user_id" value="{{ (string) $user['id'] }}">
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
                            <x-forms-front.input type="email" label="Email" name="email" value="{{ $user['email'] }}"
                                disabled />
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

@push('extraJS')
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
            return {
                dateStr,
                timeStr
            };
        }

        // Create session card HTML
        function createSessionCard(session) {}
    </script>

    <script>
        // Show file name when selected
        document.getElementById('paymentProof').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('filePreview').style.display = 'flex';
            }
        });

        function removeFile() {
            const input = document.getElementById('paymentProof');
            input.value = '';
            document.getElementById('filePreview').style.display = 'none';
            document.getElementById('fileName').textContent = '';
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('#formInput');
        const checkboxes = document.querySelectorAll('.session-checkbox');
        const sessionDataInput = document.getElementById('selectedSessions');

        function collectSessions() {
            const selected = [];

            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    const card = checkbox.closest('.session-card');
                    selected.push({
                        id: card.dataset.sessionId,
                    });
                }
            });

            sessionDataInput.value = JSON.stringify(selected);
            console.log(sessionDataInput.value)
        }

        // Kumpulkan saat ada perubahan pada checkbox
        checkboxes.forEach(cb => cb.addEventListener('change', collectSessions));

        // Kumpulkan ulang saat submit
        form.addEventListener('submit', collectSessions);

        // Jalankan sekali saat load
        collectSessions();
    });
</script>

@endpush
