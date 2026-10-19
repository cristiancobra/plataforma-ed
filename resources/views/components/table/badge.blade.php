{{-- Etiqueta (pill) para colunas de etapa/situação. $colors = [fundo, texto]; sem cores usa cinza. --}}
@props(['label' => null, 'colors' => null])

@php
    [$background, $color] = $colors ?? ['#ECEFF1', '#546E7A'];
@endphp

@if ($label)
    <span {{ $attributes->merge(['class' => 'badge rounded-pill text-wrap']) }}
        style="background-color: {{ $background }}; color: {{ $color }}; font-size: 0.75rem; padding: 0.4em 0.75em; max-width: 100%;">
        {{ $label }}
    </span>
@else
    <span class="text-muted small">—</span>
@endif
