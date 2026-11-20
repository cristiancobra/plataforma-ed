{{--
    Grade de pares rótulo/valor no padrão das telas de detalhe (rótulo na cor da conta, valor com borda),
    dois pares por linha. $items: array de ['label' => ..., 'value' => string|HtmlString|null].
--}}
@props(['items'])
@foreach (array_chunk($items, 2) as $pair)
    <div class="row g-0 mb-3">
        @foreach ($pair as $item)
            <div class="col-2 text-white text-center py-2 d-flex align-items-center justify-content-center"
                style="background-color: {{ $principalColor }}">
                {{ $item['label'] }}
            </div>
            <div class="{{ count($pair) === 1 ? 'col-10' : 'col-4' }} border border-start-0 text-center py-2 d-flex align-items-center justify-content-center"
                style="word-break: break-word;">
                @if ($item['value'] === null || $item['value'] === '')
                    -
                @else
                    {{ $item['value'] }}
                @endif
            </div>
        @endforeach
    </div>
@endforeach
