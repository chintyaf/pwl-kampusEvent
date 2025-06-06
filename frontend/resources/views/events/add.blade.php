@extends('layouts.back')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Events/</span>New Event</h4>

        <form id="formInput">
            <input type="hidden" id="user_id" name="user_id" value="6836c967d0b370e632fe49a3">

            {{-- Event Information --}}
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4 p-6">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Event Information</h5>
                            <small class="text-muted float-end">General information for the public to know</small>
                        </div>
                        <div class="card-body">
                            <x-forms.input label="Event Name" name="name" placeholder="e.g., Digital Marketing 101"
                                desc="Enter a clear and concise title for your event." />


                            <x-forms.textarea name="description" label="Description" placeholder="..."
                                desc="Tell us more about your event" />

                            <x-forms.input label="Event Poster" name="poster_url" type="file"
                                placeholder="Upload a visual poster or banner for the event. Max file size 2MB."
                                desc="" />

                        </div>
                    </div>
                </div>
            </div>
            <div id="sessions-list">
                @include('events.input.session')
            </div>

            <button type="button" class="btn btn-primary mb-4 col-12" onclick="addSession()">Add Session</button>
            <button type="submit" class="btn btn-primary mb-4">Submit</button>
        </form>
    </div>
    <!-- / Content -->
@endsection

@section('extraJS')
    <script src="{{ asset('back/js/event-add.js') }}"></script>

    {{-- Masukkan data --}}
    <script>
        document.getElementById("formInput").addEventListener("submit", async function(e) {
            e.preventDefault();
            const form = e.target;

            console.log(form);
            const sessions = [];

            // Loop through each session block
            document.querySelectorAll('.session-item').forEach((sessionEl) => {
                const session = {
                    title: sessionEl.querySelector('input[name="session_title[]"]')?.value || "",

                    description: sessionEl.querySelector('textarea[name="session_desc[]"]')?.value || "",

                    date: sessionEl.querySelector('input[name="session_date[]"]')?.value || "",
                    start_time: sessionEl.querySelector('input[name="start_time"]')?.value || "",
                    end_time: sessionEl.querySelector('input[name="end_time"]')?.value || "",
                    max_participants: sessionEl.querySelector('input[name="session_max_participants"]')
                        ?.value || "",
                    registration_fee: sessionEl.querySelector('input[name="session_registration_fee"]')
                        ?.value || "",
                    location: sessionEl.querySelector('textarea[name="session_location[]"]')
                        ?.value || "",
                    speakers: [],
                    moderators: []
                };

                // Speakers in this session
                sessionEl.querySelectorAll('.speaker-item').forEach((speakerEl) => {
                    session.speakers.push({
                        name: speakerEl.querySelector('input[name="speaker_name[]"]')
                            ?.value || "",
                        image: speakerEl.querySelector('input[name="speaker_img[]"]')
                            ?.value || "",
                        title: speakerEl.querySelector('input[name="speaker_title[]"]')
                            ?.value || "",
                        description: speakerEl.querySelector(
                            'input[name="speaker_desc[]"]')?.value || ""
                    });
                });

                // Moderators in this session
                sessionEl.querySelectorAll('.moderator-item').forEach((moderatorEl) => {
                    session.moderators.push({
                        name: moderatorEl.querySelector(
                            'input[name="moderator_name[]"]')?.value || "",
                        image: moderatorEl.querySelector(
                            'input[name="moderator_img[]"]')?.value || "",
                        title: moderatorEl.querySelector(
                            'input[name="moderator_title[]"]')?.value || "",
                        description: moderatorEl.querySelector(
                            'input[name="moderator_desc[]"]')?.value || ""
                    });
                });

                sessions.push(session);
            });

            const data = {
                user_id: form.user_id.value,
                name: form.name.value,
                description: form.description.value,
                poster_url: form.poster_url.value,
                sessions: sessions
            };
            console.log(sessions)

            try {
                const response = await fetch("http://localhost:3000/api/events/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json"
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message || "Event created successfully!");
                    // form.reset();
                    // window.location.href = "/committee/events";
                } else {
                    alert(result.message || "Failed to create event.");
                }
            } catch (error) {
                console.error("Error submitting form:", error);
                alert("Failed to connect to server.");
            }
        });
    </script>
@endsection
