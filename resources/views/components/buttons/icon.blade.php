{{-- Botão circular genérico (mesmo visual de edit/list/create) para ações com ícone e link. --}}
@props([
    'href',
    'icon',
    'title' => '',
    'principalColor' => null,
])

<a class='btn rounded-circle' title='{{ $title }}' href='{{ $href }}'
    style='background-color: {{ $principalColor ?? '#6c757d' }}; border-color: {{ $principalColor ?? '#6c757d' }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    {{ $attributes }}>
    <i class='{{ $icon }}'></i>
</a>
