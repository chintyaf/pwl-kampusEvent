<div class="session-item row">
    <div class="col-xxl">
        <div class="card mb-4 p-6">
            <div class="card-header row d-flex justify-content-between mb-2">
                <div class="col-8">
                    <h5 class="mb-0">Session <span class="session-number">1</span></h5>
                    <label for="largeSelect" class="form-label">Give us detailed information on who your session</label>
                </div>

                <div class="col-1">
                    <button type="button" class="btn btn-outline-danger w-100"
                        onclick="removeSession(this)">&times;</button>
                </div>
            </div>

            <div class="card-body">
                <x-forms.input label="Title" name="session_title[]" placeholder=""
                    desc="Enter a clear and concise title for your event." />

                <x-forms.textarea label="Description" name="session_desc[]" placeholder="" desc="moderator_" />

                <x-forms.input label="Date" name="session_date[]" type="date" desc="moderator_" />

                <x-forms.textarea label="Location" name="session_location[]" desc="Locatoin?" />

                {{-- time --}}
                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Time</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col">
                                <label for="start_time" class="form-label">Start</label>
                                <div class="input-group" id="startPicker" data-td-target-input="nearest"
                                    data-td-target-toggle="nearest">
                                    <input type="time" class="form-control" data-td-target="#startPicker"
                                        name="session_start_time[]" id="start_time" />
                                    <!-- <span class="input-group-text" data-td-target="#startPicker" --->
                                </div>
                            </div>

                            <div class="col">
                                <label for="end_time" class="form-label">End</label>
                                <div class="input-group" id="endPicker" data-td-target-input="nearest"
                                    data-td-target-toggle="nearest">
                                    <input type="time" class="form-control" data-td-target="#endPicker"
                                        name="session_end_time[]" id="end_time" />
                                    <!-- <span class="input-group-text" data-td-target="#endPicker" --->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-forms.input label="Maximum Participants" name="session_max_participants[]" placeholder="" type="number"
                    desc="Enter a clear and concise title for your event." />

                <x-forms.input label="Registration Fee" name="session_registration_fee[]" placeholder="" type="number"
                    desc="Enter a clear and concise title for your event." />


                {{-- SPEAKER --}}
                <div id="speakers-list" class="mb-4">
                    @include('events.input.speaker')
                </div>
                <button type="button" class="btn btn-primary" style="min-width: 150px" onclick="addSpeaker()">Add
                    Speaker</button>


                {{-- MODERATOR --}}
                <div id="moderators-list" class="mb-4">
                </div>
                <button type="button" class="btn btn-primary" style="min-width: 150px" onclick="addModerator()">Add
                    Moderator</button>
            </div>
        </div>
    </div>
</div>
