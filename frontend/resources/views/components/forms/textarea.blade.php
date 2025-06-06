@props(['label', 'name', 'placeholder' => '', 'desc' => ''])

<div class="row mb-4">
    <label class="col-sm-2 col-form-label" for="{{ $name }}">{{ $label }}</label>
    <div class="col-sm-10">
        <div class="input-group input-group-merge">
            <textarea id="basic-default-message" class="form-control" placeholder="{{ $placeholder }}"
                id="{{ $name }}"  name="{{ $name }}" aria-label="{{ $placeholder }}" aria-describedby="basic-icon-default-message2"></textarea>
        </div>
        <div class="form-text">{{ $desc }}</div>
    </div>
</div>
