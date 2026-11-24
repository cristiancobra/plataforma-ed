{{-- Botão circular (mesmo visual de icon/edit/create) que NÃO navega: serve para ações de JavaScript, como abrir/fechar uma área.
     Passe o id (ou data-*) pelos atributos: <x-buttons.toggle id="abrir" icon="fa fa-list" title="Ver pagamentos" :principalColor="$principalColor" /> --}}
@props([
    'icon',
    'title' => '',
    'principalColor' => null,
])

<button type='button' class='btn rounded-circle' title='{{ $title }}'
    style='background-color: {{ $principalColor ?? '#6c757d' }}; border-color: {{ $principalColor ?? '#6c757d' }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
    {{ $attributes }}>
    <i class='{{ $icon }}'></i>
</button>
