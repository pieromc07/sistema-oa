@props(['id', 'placeholder', 'icon', 'name'])

@php
    $id = $id ?? md5('choice' . rand(1, 1000));
    $placeholder = $placeholder ?? 'Search';
    $icon = $icon ?? 'bi-search';
    $name = $name ?? 'search';
@endphp

<div class="input-group">
    <label class="input-group-text" for="inputGroupSelect01">
        <i class="bi {{ $icon }}"></i>
    </label>
    <select class="form-select @error($name) is-invalid @enderror" id="{{ $id }}" {{ $attributes }}
        name="{{ $name }}" value="{{ old($name) }}">
        <option value="">{{ $placeholder }}</option>
        {{ $options }}
    </select>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
