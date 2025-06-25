@props(['label', 'name', 'value' => '', 'placeholder' => '', 'desc' => '', 'disabled' => false, 'required' => false])

@php
    $type = $type ?? 'text';
    $placeholder = $placeholder ?? '';
    $value = $value ?? '';
@endphp

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="{{ $name }}">
        {{ $label }}

        @if($required)
        <span class="text-danger">*</span>
        @endif

    </label>
    <div class="col-sm-10">
        <input type="text" name="{{ $name }}" id="{{ $name }}" class="form-control" value="{{ $value }}"
             placeholder="{{ $placeholder }}"
                @if($disabled) disabled @endif
             >
    </div>
</div>
