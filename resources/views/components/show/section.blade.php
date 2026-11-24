{{-- Seção de uma tela de detalhe: moldura com título (ícone Font Awesome) e ações opcionais à direita.
     Uso: <x-show.section title="PROPOSTAS" icon="fa fa-receipt"> ... <x-slot:actions> botões </x-slot:actions> </x-show.section> --}}
@props(['title', 'icon' => null, 'color' => null])

@php
    $frameColor = $color ?? ($principalColor ?? '#6c757d');
@endphp

<section {{ $attributes->merge(['class' => 'frame mt-5 p-3']) }} style="border-color: {{ $frameColor }}">
    <div class="row align-items-center mb-3">
        <div class="col fw-bold" style="font-size: 24px; color: {{ $frameColor }}">
            @if ($icon)<i class="{{ $icon }} me-1"></i>@endif {{ $title }}
        </div>
        @isset($actions)
            <div class="col-auto d-flex flex-wrap justify-content-end align-items-center gap-2">
                {{ $actions }}
            </div>
        @endisset
    </div>
    {{ $slot }}
</section>
