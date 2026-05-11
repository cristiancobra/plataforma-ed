@props([
    'object' => null,
    'model' => null,
    'title' => 'Enviar por email',
    'route' => null,
    'principalColor' => null,
])

@php
    if (!$object || !$model) {
        throw new \Exception('Componente email requer object e model');
    }

    // Se não especificou rota, usa model.pdf por padrão
    $routeName = $route ?? "$model.pdf";
    $bgColor = $principalColor ?? '#6c757d';
@endphp

<a class='btn rounded-circle' title='{{ $title }}'
    style='background-color: {{ $bgColor }}; border-color: {{ $bgColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    href='{{ route($routeName, [$model => $object]) }}' {{ $attributes }}>
    <i class='fas fa-envelope'></i>
</a>
