@extends('layouts.back')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Events/</span>New Event</h4>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4 p-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Add New Event</h5>
                        <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">
                        <form id="formInput">
                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="">Event Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="" name="name"
                                            placeholder="e.g., Digital Marketing 101" />
                                    </div>
                                    <div class="form-text">Enter a clear and concise title for your event.</div>
                                </div>

                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="date" class="form-control" id="" name="date"
                                            placeholder="Select date for your event" />
                                    </div>
                                    <div class="form-text">Choose the scheduled start date and time for the event.</div>
                                </div>
                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Time</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col">
                                            <label for="startDate" class="form-label">Start</label>
                                            <div class="input-group" id="startPicker" data-td-target-input="nearest"
                                                data-td-target-toggle="nearest">
                                                <input type="time" class="form-control" data-td-target="#startPicker"
                                                    name="start_time" id="startDate" />
                                                <!-- <span class="input-group-text" data-td-target="#startPicker" --->
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="endDate" class="form-label">End</label>
                                            <div class="input-group" id="endPicker" data-td-target-input="nearest"
                                                data-td-target-toggle="nearest">
                                                <input type="time" class="form-control" data-td-target="#endPicker"
                                                    name="end_time" id="endDate" />
                                                <!-- <span class="input-group-text" data-td-target="#endPicker" --->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Location</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <textarea id="basic-default-message" class="form-control" placeholder="e.g., Auditorium A, Campus Center"
                                            name="location" aria-label="e.g., Auditorium A, Campus Center" aria-describedby="basic-icon-default-message2"></textarea>
                                    </div>
                                    <div class="form-text">Provide a physical address or online meeting link.</div>
                                </div>

                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Speaker(s)</label>
                                <div class="col-sm-10">
                                    <div id="speakers-list"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpeaker()">Add
                                        Speaker</button>
                                    <div class="form-text">List the main speaker(s) and their session time</div>
                                </div>
                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Event Poster</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="file" id="formFile" name="poster_url" />
                                    </div>
                                    <div class="form-text">Upload a visual poster or banner for the event. Max file size
                                        2MB.</div>
                                </div>

                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Registration
                                    Fee</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" placeholder="Amount"
                                            name="registration_fee" aria-label="Amount (to the nearest dollar)" />
                                        <span class="input-group-text">/ person</span>
                                    </div>
                                    <div class="form-text">Specify the fee for participants or write "Free" if no cost.
                                    </div>
                                </div>

                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Maximum
                                    Participants</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" id="max_participants"
                                            name="max_participants" placeholder="e.g., 100" />
                                    </div>
                                    <div class="form-text">Set a cap for the number of attendees. Use numeric values only.
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection

@section('extraJS')
    <script>
        function addSpeaker() {
            const container = document.getElementById("speakers-list");

            const inputGroup = document.createElement("div");
            inputGroup.className = "row g-2 align-items-end mb-2";

            inputGroup.innerHTML = `
            <div class="col-md-6">
                <input type="text" name="speaker_names[]" class="form-control" placeholder="e.g., Jane Smith, CEO of TechCorp">
            </div>
            <div class="col-md-4">
                <input type="text" name="session_times[]" class="form-control" placeholder="e.g., 10:00 AM - 11:00 AM">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100" onclick="removeSpeaker(this)">&times;</button>
            </div>
        `;

            container.appendChild(inputGroup);
        }

        function removeSpeaker(button) {
            const inputGroup = button.closest('.row');
            inputGroup.remove();
        }

        const formInput = document.getElementById('formInput');

        formInput.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;

            const speakerNameInputs = document.querySelectorAll('input[name="speaker_names[]"]');
            const sessionTimeInputs = document.querySelectorAll('input[name="session_times[]"]');

            const speakers = [];
            speakerNameInputs.forEach((input, index) => {
                const name = input.value;
                const session_time = sessionTimeInputs[index]?.value || "";
                if (name) {
                    speakers.push({
                        name,
                        session_time
                    });
                }
            });

            const data = {
                name: form.name.value,
                date: form.date.value,
                start_time: form.start_time.value,
                end_time: form.end_time.value,
                location: form.location.value,
                speaker: speakers,
                poster_url: form.poster_url.value,
                registration_fee: form.registration_fee.value,
                max_participants: form.max_participants.value,
            };

            try {
                const response = await fetch('http://localhost:3000/api/events/store', {
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
                    window.location.href = "/events";
                } else {
                    alert(result.message || 'Fail to add event');
                }
            } catch (error) {
                alert('Error connecting to server');
                console.error(error);
            }
        });
    </script>
@endsection
