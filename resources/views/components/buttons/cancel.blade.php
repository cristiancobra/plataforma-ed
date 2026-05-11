@props([
    'title' => 'Cancelar alterações',
    'href' => null,
])

<a class='btn btn-secondary rounded-circle' title='{{ $title }}' href='{{ $href ?? url()->previous() }}'
    style='width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    {{ $attributes }}>
    <i class='fas fa-times-circle'></i>
</a>
