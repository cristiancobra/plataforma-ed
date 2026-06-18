@props(['name', 'label' => '', 'value' => '1'])

<div class="col-auto d-flex align-items-center">
    <div class="form-check">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" class="form-check-input"
            value="{{ $value }}" {{ request($name) == $value ? 'checked' : '' }} {{ $attributes }}>
        <label class="form-check-label" for="{{ $name }}">
            {{ $label }}
        </label>
    </div>
</div>
