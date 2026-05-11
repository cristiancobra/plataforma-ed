@props([
    'title' => 'Editar estas informações',
    'model' => null,
    'object' => null,
    'parameter2' => null,
    'value2' => null,
    'principalColor' => null,
])

@php
    $route = "$model.edit";
    $routeParams = [$model => $object];

    if ($parameter2 && $value2) {
        $routeParams[$parameter2] = $value2;
    }
@endphp

<a class='btn rounded-circle' title='{{ $title }}'
    style='background-color: {{ $principalColor ?? '#6c757d' }}; border-color: {{ $principalColor ?? '#6c757d' }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    href='{{ route($route, $routeParams) }}' {{ $attributes }}>
    <i class='fas fa-edit'></i>
</a>
