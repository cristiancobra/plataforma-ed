{{-- Bloco de formulário com título sublinhado, para agrupar campos relacionados (sem caixa, alinhado à página). --}}
@props(['title', 'icon' => null, 'hint' => null])
<div {{ $attributes->merge(['class' => 'mt-4 mb-2']) }}>
    <h6 class="fw-bold pb-2 mb-3 border-bottom"
        style="color: {{ $principalColor ?? '#6c757d' }}; border-color: {{ $principalColor ?? '#dee2e6' }} !important;">
        @if ($icon)<i class="{{ $icon }} me-1"></i>@endif {{ $title }}
    </h6>
    @if ($hint)
        <p class="text-muted small mb-2">{{ $hint }}</p>
    @endif
    {{ $slot }}
</div>
