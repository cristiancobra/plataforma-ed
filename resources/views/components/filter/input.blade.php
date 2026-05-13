@props(['name', 'placeholder' => '', 'type' => 'text'])

<div class="col-auto">
    <input type="{{ $type }}" name="{{ $name }}" class="form-control" placeholder="{{ $placeholder }}"
        value="{{ request($name) }}" {{ $attributes }}>
</div>
