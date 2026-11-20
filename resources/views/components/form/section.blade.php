{{-- Bloco de formulário com título, para agrupar campos relacionados. --}}
@props(['title', 'icon' => null, 'hint' => null])
<div {{ $attributes->merge(['class' => 'border rounded p-3 mb-4']) }}>
    <h6 class="fw-bold mb-1" style="color: {{ $principalColor ?? '#6c757d' }}">
        @if ($icon)<i class="{{ $icon }} me-1"></i>@endif {{ $title }}
    </h6>
    @if ($hint)
        <p class="text-muted small mb-2">{{ $hint }}</p>
    @endif
    {{ $slot }}
</div>
