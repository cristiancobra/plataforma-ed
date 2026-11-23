@extends('layouts/show')

@section('title', 'ACERVO')

@php
    // link seguro (escapado) usado nas grades de rótulo/valor abaixo
    $link = fn ($url, $text = null) => $url
        ? new \Illuminate\Support\HtmlString('<a href="' . e($url) . '" target="_blank" rel="noopener">' . e($text ?? $url) . '</a>')
        : null;
@endphp

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('buttons')
    <x-buttons.edit model="collection" :object="$collection" :principalColor="$principalColor" />
    <x-buttons.list model="collection" :object="$collection" :principalColor="$principalColor" />
@endsection

@section('trash')
    <x-buttons.trash :object="$collection" model="collection" />
@endsection

@section('name', $collection->name)

@section('status', $collection->status)


@section('fieldsId')
    <x-show.field-grid :items="array_values(array_filter([
        ['label' => 'TIPO', 'value' => $collection->collectionType->name ?? null],
        ['label' => 'CATEGORIA', 'value' => $collection->collectionType->category ?? null],
        ['label' => 'ACERVO', 'value' => $collection->collectionsGroup->name ?? null],
        ['label' => 'PROJETO', 'value' => $collection->project->name ?? null],
        ['label' => 'RESPONSÁVEL', 'value' => $collection->contact ? $link(route('contact.show', $collection->contact), $collection->contact->name) : null],
        ['label' => 'REGISTRADO POR', 'value' => isset($collection->user->contact->name) ? $link(route('user.show', ['user' => $collection->user_id]), $collection->user->contact->name) : 'foi excluído'],
        ['label' => 'MARCA', 'value' => $collection->brand],
        ['label' => 'MODELO', 'value' => $collection->model],
        ['label' => 'PATRIMÔNIO', 'value' => $collection->patrimony_number],
        ['label' => 'CONTROLE', 'value' => $collection->control_code],
        ['label' => 'NÚMERO DE SÉRIE', 'value' => $collection->serial_number],
        ['label' => 'TAG DE RASTREAMENTO', 'value' => $collection->tracking_tag],
        ['label' => 'LINK DE REDIRECIONAMENTO', 'value' => $link($collection->redirect_link)],
        ['label' => 'ACESSÓRIOS', 'value' => $collection->accessories],
        $collection->title ? ['label' => 'TÍTULO', 'value' => $collection->title] : null,
    ]))" />
@endsection

@section('description')
    @if ($collection->description)
        {!! nl2br(e($collection->description)) !!}
    @endif
@endsection

@section('main')
    @php
        $toItem = function ($field) use ($collection, $link) {
            $value = $collection->custom_fields[$field->key] ?? null;
            $display = match (true) {
                $value === null => null,
                $field->type === \App\Enums\CustomFieldType::Url => $link($value),
                $field->type === \App\Enums\CustomFieldType::Secret => new \Illuminate\Support\HtmlString(
                    '<span class="secret-value">••••••••</span> '
                    . '<button type="button" class="btn btn-sm btn-outline-secondary ms-2 reveal-secret" data-url="'
                    . e(route('collection.reveal-secret', [$collection, $field->key])) . '"><i class="fas fa-eye"></i> Mostrar</button>'
                ),
                $field->type === \App\Enums\CustomFieldType::Textarea => new \Illuminate\Support\HtmlString(nl2br(e($value))),
                default => $field->displayValue($collection->custom_fields),
            };

            return ['label' => mb_strtoupper($field->label), 'value' => $display];
        };
        $customItems = $customFields->map($toItem)->all();
        $otherItems = $otherFields->map($toItem)->all();

        $specItems = array_values(array_filter([
            $collection->purchase_date ? ['label' => 'DATA DA COMPRA', 'value' => $collection->purchase_date->format('d/m/Y')] : null,
            $collection->manufacturing_date ? ['label' => 'DATA DE FABRICAÇÃO', 'value' => $collection->manufacturing_date->format('d/m/Y')] : null,
            $collection->video_url ? ['label' => 'URL DO VÍDEO', 'value' => $link($collection->video_url)] : null,
            $collection->code_url ? ['label' => 'URL DO CÓDIGO', 'value' => $link($collection->code_url)] : null,
            $collection->image_url ? ['label' => 'URL DA IMAGEM', 'value' => $link($collection->image_url)] : null,
        ]));
    @endphp

    @if ($customItems)
        <div class="row mt-5">
            <h4 class="mb-3 fw-bold" style="color: {{ $principalColor }}">
                CAMPOS DO TIPO {{ mb_strtoupper($collection->collectionType->name ?? '') }}
            </h4>
            <x-show.field-grid :items="$customItems" />
        </div>
    @endif

    @if ($otherItems)
        <div class="row mt-5">
            <h4 class="mb-1 fw-bold" style="color: {{ $principalColor }}">
                OUTROS CAMPOS PREENCHIDOS
            </h4>
            <p class="text-muted small mb-3">
                Valores guardados em campos que não fazem mais parte do tipo deste item ou foram desativados.
                Para editá-los, ligue o campo ao tipo na tela do tipo de acervo.
            </p>
            <x-show.field-grid :items="$otherItems" />
        </div>
    @endif

    @if ($specItems)
        <div class="row mt-5">
            <h4 class="mb-3 fw-bold" style="color: {{ $principalColor }}">
                AQUISIÇÃO E LINKS
            </h4>
            <x-show.field-grid :items="$specItems" />
        </div>
    @endif

    <div class="row mt-5">
        <h4 class="mb-3 fw-bold" style="color: {{ $principalColor }}">
            LOCALIZAÇÃO ATUAL
        </h4>
        <div class="border rounded p-3 bg-light">
            @if ($collection->currentLocation)
                <div class="row">
                    <div class="col-md-4"><strong>Local:</strong> {{ $collection->currentLocation->location }}</div>
                    <div class="col-md-4"><strong>Movido em:</strong> {{ $collection->currentLocation->moved_at->format('d/m/Y H:i') }}</div>
                    <div class="col-md-4">
                        @if ($collection->currentLocation->user && $collection->currentLocation->user->contact)
                            <strong>Por:</strong> {{ $collection->currentLocation->user->contact->name }}
                        @endif
                    </div>
                </div>
                @if ($collection->currentLocation->notes)
                    <p class="mt-2 mb-0"><strong>Notas:</strong> {{ $collection->currentLocation->notes }}</p>
                @endif
            @else
                <p class="mb-0">Sem localização registrada</p>
            @endif

            <form action="{{ route('collection.add-location', $collection) }}" method="POST" class="mt-3 pt-3 border-top">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label class="labels">NOVA LOCALIZAÇÃO:</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="labels">NOTAS:</label>
                        <input type="text" name="notes" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="labels">DATA/HORA:</label>
                        <input type="datetime-local" name="moved_at" class="form-control"
                            value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                </div>
                <button type="submit" class="btn mt-2 text-white" style="background-color: {{ $principalColor }};">
                    Atualizar Localização
                </button>
            </form>
        </div>
    </div>

    @if ($collection->locations->count() > 1)
        <div class="row mt-5">
            <h4 class="mb-3 fw-bold" style="color: {{ $principalColor }}">
                HISTÓRICO DE LOCALIZAÇÕES
            </h4>
            <div class="border rounded p-3 bg-light">
                @foreach ($collection->locations->sortByDesc('moved_at') as $location)
                    @if (!$location->is_current)
                        <div class="mb-2 p-2" style="border-left: 3px solid #ccc;">
                            <strong> {{ $location->moved_at->format('d/m/Y H:i') }} </strong>
                            - {{ $location->location }}
                            @if ($location->user && $location->user->contact)
                                por {{ $location->user->contact->name }}
                            @endif
                            @if ($location->notes)
                                <br><small>{{ $location->notes }}</small>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    @endsection

    @section('attachments')
        <x-attachments-section :attachments="$collection->attachments" modelId="{{ $collection->id }}" modelIdField="collection_id"
            routeStore="attachment.store" routeDestroy="attachment.destroy" :types="['nota_fiscal', 'termo_emprestimo']" :principalColor="$principalColor" />
    @endsection

@section('js-scripts')
    <script>
        // senhas protegidas: busca o valor só ao clicar em "Mostrar" e volta a esconder no segundo clique
        document.querySelectorAll('.reveal-secret').forEach(function (button) {
            button.addEventListener('click', function () {
                var target = button.parentElement.querySelector('.secret-value');
                if (button.dataset.revealed) {
                    target.textContent = '••••••••';
                    delete button.dataset.revealed;
                    button.innerHTML = '<i class="fas fa-eye"></i> Mostrar';
                    return;
                }
                fetch(button.dataset.url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
                    .then(function (data) {
                        target.textContent = data.value;
                        button.dataset.revealed = '1';
                        button.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar';
                    })
                    .catch(function () { target.textContent = 'não foi possível mostrar'; });
            });
        });
    </script>
@endsection
