<div class="visitor-item   p-3 rounded-2 border border-primary mt-4" style="border-size: 3px"" id="visitor-0">
    <div class="visitor-header d-flex justify-content-between mb-1">
        <div class="col-8">
            <h5 class="mb-0" style="font-size:17px">
                Visitor
                <span class="visitor-number fw-semibold">1</span>
            </h5>
            <label class="form-label" style="font-size:13px">Tell us more about your speaker!</label>
        </div>
    </div>

    <x-forms-front.input label="Full Name" name="name" value="" required />
    <x-forms-front.input type="email" label="Email" name="email" value="" required />
    <x-forms-front.input label="Phone Number" name="phone_num" value="" required />

    <div class="">
        <div class="mb-4">
            <label class="col-sm-2 col-form-label" for="session">Session</label>
            <div class="sessions-list">
            @foreach ($event['session'] as $session)
                @include('event-register.input.session')
            @endforeach
            </div>
        </div>
    </div>
</div>
