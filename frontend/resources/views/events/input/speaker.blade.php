<div class="speaker-item p-3 rounded-2 border border-primary mt-4" style="border-size: 3px">
    <div class="mt-2 mb-3">
        <div class="row d-flex justify-content-between mb-2">
            <div class="col-8">
                <h5 class="mb-0">Speaker <span class="speaker-number">1</span></h5>
                <label for="largeSelect" class="form-label">Tell us more about your speaker!</label>
            </div>

            <div class="col-1">
                <button type="button" class="btn btn-outline-danger w-100" onclick="removeSpeaker(this)">&times;</button>
            </div>
        </div>
    </div>


    <x-forms.input label="Name" name="speaker_name[]" placeholder="" desc="" required/>

    <x-forms.input label="Image" name="speaker_img[]" placeholder="" type="file" desc="" />

    <x-forms.input label="Title" name="speaker_title[]" placeholder="" desc="" />

    <x-forms.input label="Description" name="speaker_desc[]" placeholder="" desc="" />
</div>
