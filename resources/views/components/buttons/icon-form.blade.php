{{-- Botão circular (mesmo visual de icon/trash) que envia um formulário, para ações que alteram dados. --}}
@props([
    'action',
    'icon',
    'title' => '',
    'method' => 'PUT',
    'color' => null,
    'principalColor' => null,
    'confirm' => null,
])

@php
    $bgColor = $color ?? ($principalColor ?? '#6c757d');
@endphp

<form style='display: inline-block' action='{{ $action }}' method='post'
    @if ($confirm) onsubmit="return confirm('{{ $confirm }}')" @endif>
    @csrf
    @method($method)
    <button class='btn rounded-circle' title='{{ $title }}' type='submit'
        style='background-color: {{ $bgColor }}; border-color: {{ $bgColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'
        {{ $attributes }}>
        <i class='{{ $icon }}'></i>
    </button>
</form>
