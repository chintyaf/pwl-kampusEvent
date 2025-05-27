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
                        <form>
                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Event Name</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="basic-default-name"
                                            placeholder="e.g., Digital Marketing 101" />
                                    </div>
                                    <div class="form-text">Enter a clear and concise title for your event.</div>
                                </div>

                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="date" class="form-control" id="basic-default-name"
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
                                                    id="startDate" />
                                                <!-- <span class="input-group-text" data-td-target="#startPicker"
                                                                                                                                                                data-td-toggle="datetimepicker">
                                                                                                                                                                <i class="bi bi-calendar"></i>
                                                                                                                                                            </span> -->
                                            </div>
                                        </div>

                                        <div class="col">
                                            <label for="endDate" class="form-label">End</label>
                                            <div class="input-group" id="endPicker" data-td-target-input="nearest"
                                                data-td-target-toggle="nearest">
                                                <input type="time" class="form-control" data-td-target="#endPicker"
                                                    id="endDate" />
                                                <!-- <span class="input-group-text" data-td-target="#endPicker"
                                                                                                                                                                data-td-toggle="datetimepicker">
                                                                                                                                                                <i class="bi bi-clock"></i>
                                                                                                                                                            </span> -->
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
                                            aria-label="e.g., Auditorium A, Campus Center" aria-describedby="basic-icon-default-message2"></textarea>
                                    </div>
                                    <div class="form-text">Provide a physical address or online meeting link.</div>
                                </div>

                            </div>


                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label" for="basic-default-company">Speaker(s)</label>
                                <div class="col-sm-10">
                                    <div id="speakers-list">

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
                                        <input class="form-control" type="file" id="formFile" />
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
                                        <input type="number" class="form-control" id="basic-default-name"
                                            placeholder="e.g., 100" />
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
@endsection
