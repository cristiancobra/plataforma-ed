@props([
    'title' => 'Criar novo',
    'model' => null,
    'parameter' => null,
    'value' => null,
    'principalColor' => null,
])

@php
    $route = "$model.create";
    $routeParams = [];

    if ($parameter && $value) {
        $routeParams[$parameter] = $value;
    }
@endphp

<a class='btn rounded-circle' title='{{ $title }}'
    style='background-color: {{ $principalColor ?? '#6c757d' }}; border-color: {{ $principalColor ?? '#6c757d' }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    href='{{ route($route, $routeParams) }}' {{ $attributes }}>
    <i class='fas fa-plus'></i>
</a>
