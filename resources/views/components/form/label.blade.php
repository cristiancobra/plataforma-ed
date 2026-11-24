{{-- Rótulo de campo de formulário na cor principal da conta (classe .labels usa var(--principal-color)). --}}
@props(['for' => null, 'required' => false])

<label {{ $attributes->merge(['class' => 'labels']) }} @if ($for) for="{{ $for }}" @endif>
    {{ $slot }}
    @if ($required)
        <span class="text-danger">*</span>
    @endif
</label>
