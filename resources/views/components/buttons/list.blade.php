@props([
    'model' => null,
    'title' => 'Ir para lista',
    'parameter' => null,
    'value' => null,
    'principalColor' => null,
])

@php
    $route = $model . '.index';
    $routeParams = $parameter && $value ? [$parameter => $value] : [];
    $bgColor = $principalColor ?? '#007bff';
@endphp

<a class='btn rounded-circle' title='{{ $title }}' href='{{ route($route, $routeParams) }}'
    style='background-color: {{ $bgColor }}; border-color: {{ $bgColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    {{ $attributes }}>
    <i class='fas fa-list'></i>
</a>
