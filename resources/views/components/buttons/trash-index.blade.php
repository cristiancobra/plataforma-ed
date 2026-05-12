@props(['trashStatus', 'parameter', 'variation' => null])

@if ($trashStatus == 1)
    @if ($variation)
        <x-buttons.list :model="$parameter" parameter="variation" :value="$variation" title="Ver todos"
            principalColor="#28a745" />
    @else
        <x-buttons.list :model="$parameter" title="Ver todos" principalColor="#28a745" />
    @endif
@else
    @php
        $link = route("$parameter.index", ['trash' => 1, 'variation' => $variation]);
        $bgColor = '#dc3545'; // vermelho
        $iconName = 'fa fa-trash-restore';
        $title = 'Ver lixeira';
    @endphp
    <a href="{{ $link }}" title="{{ $title }}" class="btn rounded-circle"
        style="background-color: {{ $bgColor }}; border-color: {{ $bgColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
        <i class="{{ $iconName }}" aria-hidden="true"></i>
    </a>
@endif
