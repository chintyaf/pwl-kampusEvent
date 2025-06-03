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
                                        <input type="text" class="form-control" id="" name="name" value="{{ $event['name'] }}"
                                            placeholder="e.g., Digital Marketing 101" />
                                    </div>
                                    <div class="form-text">Enter a clear and concise title for your event.</div>
                                </div>

                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="date" class="form-control" id="" name="date" value="{{ $event['date'] }}"
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
                                                <input type="time" class="form-control" data-td-target="#startPicker" name="start_time" value="{{ $event['start_time'] }}"
                                                    id="startDate" />
                                                <!-- <span class="input-group-text" data-td-target="#startPicker" --->
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="endDate" class="form-label">End</label>
                                            <div class="input-group" id="endPicker" data-td-target-input="nearest"
                                                data-td-target-toggle="nearest">
                                                <input type="time" class="form-control" data-td-target="#endPicker" name="end_time" value="{{ $event['end_time'] }}"
                                                    id="endDate" />
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
                                        <textarea id="basic-default-message" class="form-control" placeholder="e.g., Auditorium A, Campus Center" name="location"
                                            aria-label="e.g., Auditorium A, Campus Center" aria-describedby="basic-icon-default-message2">{{ $event['location'] }}</textarea>
                                    </div>
                                    <div class="form-text">Provide a physical address or online meeting link.</div>
                                </div>

                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Speaker(s)</label>
                                <div class="col-sm-10">
                                    <div id="speakers-list">
                                        @if(isset($event['speaker']) && is_array($event['speaker']))
                                            @foreach($event['speaker'] as $speaker)
                                                <div class="input-group input-group-merge mb-2">
                                                    <input type="text" class="form-control" name="speakers[]" value="{{ $speaker }}" placeholder="e.g., Jane Smith, CEO of TechCorp">
                                                    <button type="button" class="btn btn-outline-danger" onclick="removeSpeaker(this)">&times;</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addSpeaker()">Add
                                        Speaker</button>
                                    <div class="form-text">List the main speaker(s)</div>
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
                                        <input type="text" class="form-control" placeholder="Amount" name="registration_fee" value="{{ $event['registration_fee'] }}"
                                            aria-label="Amount (to the nearest dollar)" />
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
                                        <input type="number" class="form-control" id="max_participants" name="max_participants" value="{{ $event['max_participants'] }}"
                                            placeholder="e.g., 100" />
                                    </div>
                                    <div class="form-text">Set a cap for the number of attendees. Use numeric values only.
                                    </div>
                                </div>

                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <a href="#" class="btn btn-primary">Update</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
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
            inputGroup.className = "input-group input-group-merge mb-2";

            const input = document.createElement("input");
            input.type = "text";
            input.className = "form-control";
            input.name = "speakers[]";
            input.placeholder = "e.g., Jane Smith, CEO of TechCorp";

            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.className = "btn btn-outline-danger";
            removeBtn.innerHTML = "&times;";
            removeBtn.onclick = function() {
                removeSpeaker(removeBtn);
            };

            inputGroup.appendChild(input);
            inputGroup.appendChild(removeBtn);
            container.appendChild(inputGroup);
        }

        function removeSpeaker(button) {
            const inputGroup = button.parentNode;
            inputGroup.remove();
        }
    </script>

    <script>
            document.getElementById('formInput').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData();

        formData.append("name", form.name.value);
        formData.append("date", form.date.value);
        formData.append("start_time", form.start_time.value);
        formData.append("end_time", form.end_time.value);
        formData.append("location", form.location.value);
        formData.append("registration_fee", form.registration_fee.value);
        formData.append("max_participants", form.max_participants.value);

        const speakers = document.querySelectorAll('input[name="speakers[]"]');
        speakers.forEach(input => {
            if (input.value) formData.append("speaker[]", input.value);
        });

        const fileInput = form.poster_url;
        if (fileInput.files.length > 0) {
            formData.append("poster_url", fileInput.files[0]);
        }

        try {
            const eventId = `{{ $event['_id'] }}`;
            const response = await fetch(`http://localhost:3000/api/events/update/${eventId}`, {
                method: 'PUT',
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message || "Event updated successfully!");
                window.location.href = "/events";
            } else {
                alert(result.message || "Update failed");
            }
        } catch (err) {
            console.error(err);
            alert("Server error");
        }
    })
    </script>
@endsection
