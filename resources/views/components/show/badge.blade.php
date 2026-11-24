{{-- Etiqueta (pill) com ícone, para indicar um estado numa tela de detalhe (não é clicável).
     $colors = [fundo, texto]; sem cores usa cinza. Ex.: <x-show.badge icon="fa fa-check" label="Proposta ganha" :colors="['#E8F5E9', '#2E7D32']" /> --}}
@props(['label', 'icon' => null, 'colors' => null])

@php
    [$background, $color] = $colors ?? ['#ECEFF1', '#546E7A'];
@endphp

<span {{ $attributes->merge(['class' => 'badge rounded-pill d-inline-flex align-items-center gap-1']) }}
    style="background-color: {{ $background }}; color: {{ $color }}; font-size: 0.8rem; padding: 0.5em 0.9em;">
    @if ($icon)<i class="{{ $icon }}" aria-hidden="true"></i>@endif
    {{ $label }}
</span>
