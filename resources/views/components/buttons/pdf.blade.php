@props([
    'object' => null,
    'model' => null,
    'title' => 'Gerar PDF',
    'principalColor' => null,
])

@php
    if (!$object || !$model) {
        throw new \Exception('Componente pdf requer object e model');
    }

    $route = "$model.pdf";
    $bgColor = $principalColor ?? '#6c757d';
@endphp

<a class='btn rounded-circle' title='{{ $title }}'
    style='background-color: {{ $bgColor }}; border-color: {{ $bgColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    href='{{ route($route, [$model => $object->id]) }}' {{ $attributes }}>
    <i class='fa fa-print'></i>
</a>
