@props(['label', 'name', 'value' => '', 'placeholder' => '', 'desc' => '', 'disabled' => false])

@php
    $type = $type ?? 'text';
    $placeholder = $placeholder ?? '';
    $value = $value ?? '';
@endphp

<div class="row mb-4">
    <label class="col-sm-2 col-form-label" for="{{ $name }}">
        {{ $label }}

        {{-- <span class="text-danger">*</span> --}}
    </label>
    <div class="col-sm-10">
        <div class="input-group input-group-merge">
            <textarea id="basic-default-message" class="form-control" placeholder="{{ $placeholder }}"
                id="{{ $name }}"
                name="{{ $name }}"
                aria-label="{{ $placeholder }}"
                aria-describedby="basic-icon-default-message2"
                @if($disabled) disabled @endif
                >{{ $value }}

            </textarea>
        </div>
        <div class="form-text">{{ $desc }}</div>
    </div>
</div>
