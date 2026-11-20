{{-- Pílula colorida com o nome de um campo personalizado; a cor é fixa por campo. --}}
@props(['field'])
@php [$bg, $fg] = $field->pillColors(); @endphp
<span title="{{ $field->type->label() }}{{ $field->required ? ' · obrigatório' : '' }}{{ $field->active ? '' : ' · desativado' }}"
    style="display: inline-block; padding: 2px 10px; margin: 2px 2px; border-radius: 999px; font-size: 0.8rem;
        font-weight: 500; line-height: 1.5; white-space: nowrap; background-color: {{ $bg }}; color: {{ $fg }};
        border: 1px solid {{ $fg }}33;{{ $field->active ? '' : ' opacity: .5; text-decoration: line-through;' }}">{{ $field->label }}</span>
