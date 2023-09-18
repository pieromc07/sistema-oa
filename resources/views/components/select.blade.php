@props(['id', 'placeholder', 'icon', 'name', 'label'])

@php
    $id = $id ?? md5('input-text' . rand(1, 1000));
    $placeholder = $placeholder ?? 'Search';
    $icon = $icon ?? 'bi-search';
    $name = $name ?? 'search';
    $label = $label ?? $placeholder;
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $id }}">
        {{ $label }}
    </label>
    <select class="form-select  @error($name) is-invalid @enderror" id="{{ $id }}" {{ $attributes }}
        name="{{ $name }}">
        <option value="">{{ $placeholder }}</option>
        {{ $options }}
    </select>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
