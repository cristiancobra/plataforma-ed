@props(['name', 'options' => [], 'placeholder' => 'Selecione...'])

@php
    // Se o array é simples (indexed), converte para associativo
    $isIndexed = array_values($options) === $options;
    $selectOptions = $isIndexed ? array_combine($options, $options) : $options;
@endphp

<div class="col-auto">
    <select name="{{ $name }}" class="form-select" {{ $attributes }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($selectOptions as $value => $label)
            <option value="{{ $value }}" {{ request($name) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
