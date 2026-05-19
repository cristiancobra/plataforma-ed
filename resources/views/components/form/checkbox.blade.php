@props(['name', 'label', 'checked' => false])
<div class="form-check mt-4">
    <input class="form-check-input" type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1"
        {{ $checked ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
</div>
