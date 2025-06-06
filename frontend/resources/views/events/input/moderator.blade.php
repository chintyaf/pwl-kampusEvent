<div class="moderator-item p-3 rounded-2 border border-primary mt-4" style="border-size: 3px">
    <div class="mt-2 mb-3">
        <div class="mt-2 mb-3">
            <div class="row d-flex justify-content-between mb-2">
                <div class="col-8">
                    <h5 class="mb-0">Moderator <span class="moderator-number">1</span></h5>
                    <label for="largeSelect" class="form-label">Tell us more about your moderator</label>
                </div>

                <div class="col-1">
                    <button type="button" class="btn btn-outline-danger w-100"
                        onclick="removeModerator(this)">&times;</button>
                </div>
            </div>
        </div>


        <x-forms.input label="Name" name="moderator_name[]" placeholder="" desc="" required />

        <x-forms.input label="Image" name="moderator_img[]" placeholder="" type="file" desc="" />

        <x-forms.input label="Title" name="moderator_title[]" placeholder="" desc="" />

        <x-forms.input label="Description" name="moderator_desc[]" placeholder="" desc="" />
    </div>
</div>
