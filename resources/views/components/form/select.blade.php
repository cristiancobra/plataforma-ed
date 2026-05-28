@props([
    'name',
    'options' => [],
    'placeholder' => 'Selecione...',
    'selected' => null,
    'labelField' => 'name',
    'valueField' => 'id',
])

@php
    // Permite receber array associativo, array indexado ou coleção de objetos
    $selectOptions = [];
    if (is_object($options) && method_exists($options, 'toArray')) {
        // Coleção Eloquent
        foreach ($options as $item) {
            $selectOptions[$item->{$valueField}] = $item->{$labelField};
        }
    } elseif (is_array($options)) {
        // Array associativo ou indexado
        $isAssoc = array_keys($options) !== range(0, count($options) - 1);
        if ($isAssoc) {
            $selectOptions = $options;
        } else {
            $selectOptions = array_combine($options, $options);
        }
    }
    $current = old($name, $selected);
@endphp

<div class="col-auto">
    <select name="{{ $name }}" class="form-select" {{ $attributes }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($selectOptions as $value => $label)
            <option value="{{ $value }}" {{ (string) $current === (string) $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>
