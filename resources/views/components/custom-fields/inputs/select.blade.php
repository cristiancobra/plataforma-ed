@php
    $options = $field->options ?? [];
    // valor gravado que saiu da lista de opções: mantém no select para não ser perdido ao salvar
    $orphan = $value !== null && $value !== '' && !in_array((string) $value, array_map('strval', $options), true);
@endphp
<select name='{{ $name }}' id='{{ $id }}' class='form-select' @required($field->required)>
    <option value="">Selecione...</option>
    @if ($orphan)
        <option value="{{ $value }}" selected>{{ $value }} (fora da lista)</option>
    @endif
    @foreach ($options as $option)
        <option value="{{ $option }}" @selected((string) $value === (string) $option)>{{ $option }}</option>
    @endforeach
</select>
