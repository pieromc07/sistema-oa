@props(['id', 'placeholder', 'icon', 'name', 'value', 'label', 'req'])

@php
    $id = $id ?? md5('input-text' . rand(1, 1000));
    $placeholder = $placeholder ?? 'input';
    $icon = $icon ?? 'bi-search';
    $name = $name ?? 'search';
    $value = $value ?? '';
    $label = $label ?? $placeholder;
    $req = $req ?? true;
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $id }}">
        {{ $label }} @if ($req) <span class="text-danger">*</span> @endif
    </label>
    <div class="input-group input-group-merge">
        <span id="" class="input-group-text">
            <i class="bi {{ $icon }}" id="{{ $id }}-icon"></i>
        </span>
        <input class="form-control @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
            id="{{ $id }}" aria-label="{{ $placeholder }}" name="{{ $name }}"
            value="{{ old($name, $value) }}" {{ $attributes }} aria-describedby="{{ $name }}" />
    </div>
</div>
