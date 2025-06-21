@props(['label', 'type', 'name', 'value' => '', 'placeholder' => '', 'desc' => '', 'disabled' => false, 'required' => false])

@php
    $type = $type ?? 'text';
    $placeholder = $placeholder ?? '';
    $value = $value ?? '';
@endphp


<div class="row mb-4">
    <label class="col-sm-2 col-form-label" for="{{ $name }}">{{ $label }}</label>
    <div class="col-sm-10">
        <div class="input-group input-group-merge">
            <input type="{{ $type }}" class="form-control" id="{{ $name }}" name="{{ $name }}"
                placeholder="{{ $placeholder }}" value="{{ $value }}"/>
        </div>
        <div class="form-text">{{ $desc }}</div>
    </div>
</div>
