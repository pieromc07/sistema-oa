@props(['id', 'placeholder', 'icon', 'name', 'value', 'label'])

@php
    $id = $id ?? md5('input-text' . rand(1, 1000));
    $placeholder = $placeholder ?? 'input';
    $icon = $icon ?? 'bi-search';
    $name = $name ?? 'search';
    $value = $value ?? '';
    $label = $label ?? $placeholder;
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $id }}">
        {{ $label }}
    </label>
    <div class="input-group input-group-merge">
        <span id="" class="input-group-text">
            <i class="bi {{ $icon }}" id="{{ $id }}-icon"></i>
        </span>
        <input class="form-control" @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
            id="{{ $id }}" aria-label="{{ $placeholder }}" name="{{ $name }}"
            value="{{ old($name, $value) }}" {{ $attributes }} aria-describedby="{{ $name }}" />
    </div>
</div>
