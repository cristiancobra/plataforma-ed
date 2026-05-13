@extends('layouts/show')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('buttons')
    <x-buttons.trash :object="$collection" model="collection" />
    <x-buttons.edit model="collection" :object="$collection" :principalColor="$principalColor" />
    <x-buttons.list model="collection" :object="$collection" :principalColor="$principalColor" />
@endsection

@section('name', $collection->name)

@section('status', $collection->status)


@section('fieldsId')
    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            RESPONSÁVEL
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            @if (isset($collection->user->contact->name))
                <a href='{{ route('user.show', ['user' => $collection->user_id]) }}' class="text-decoration-none">
                    {{ $collection->user->contact->name }}
                </a>
            @else
                foi excluído
            @endif
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            CATEGORIA
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->category }}
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            TIPO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->type }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            PATRIMÔNIO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->patrimony_number ?? '-' }}
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            CONTROLE
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->control_code ?? '-' }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            MARCA
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->brand ?? '-' }}
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            MODELO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->model ?? '-' }}
        </div>
    </div>

    @if ($collection->title)
        <div class="row g-0 mb-3">
            <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
                TÍTULO
            </div>
            <div class="col-10 border border-start-0 text-center py-2">
                {{ $collection->title }}
            </div>
        </div>
    @endif
@endsection


@section('description')
    @if ($collection->description)
        {!! nl2br(e($collection->description)) !!}
    @endif
@endsection

@section('main')

    <h4 class="mt-4 mb-3 fw-bold" style="color: {{ $principalColor }}">
        ESPECIFICAÇÕES TÉCNICAS
    </h4>
    <div class="border rounded p-3 bg-light">
        <div class="row">
            <div class="col-md-6">
                @if ($collection->operating_system)
                    <p><strong>Sistema Operacional:</strong> {{ $collection->operating_system }}</p>
                @endif
                @if ($collection->video_card)
                    <p><strong>Placa de Vídeo:</strong> {{ $collection->video_card }}</p>
                @endif
                @if ($collection->best_ai)
                    <p><strong>Melhor IA:</strong> {{ $collection->best_ai }}</p>
                @endif
                @if ($collection->runs_adobe)
                    <p><strong>Roda no Adobe:</strong> {{ $collection->runs_adobe }}</p>
                @endif
                @if ($collection->runs_vrchat)
                    <p><strong>Roda no VRChat:</strong> {{ $collection->runs_vrchat }}</p>
                @endif
            </div>
            <div class="col-md-6">
                @if ($collection->purchase_date)
                    <p><strong>Data da Compra:</strong> {{ $collection->purchase_date->format('d/m/Y') }}</p>
                @endif
                @if ($collection->manufacturing_date)
                    <p><strong>Data de Fabricação:</strong> {{ $collection->manufacturing_date->format('d/m/Y') }}</p>
                @endif
                @if ($collection->users)
                    <p><strong>Usuários:</strong> {{ $collection->users }}</p>
                @endif
                @if ($collection->password)
                    <p><strong>Senha:</strong> {{ $collection->password }}</p>
                @endif
            </div>
        </div>

        @if ($collection->video_url || $collection->code_url || $collection->image_url)
            <div class="row mt-3">
                <div class="col-12">
                    <strong>Links:</strong>
                    @if ($collection->video_url)
                        <a href="{{ $collection->video_url }}" target="_blank" class="btn btn-sm btn-primary ms-2">
                            <i class="fa fa-video"></i> Vídeo
                        </a>
                    @endif
                    @if ($collection->code_url)
                        <a href="{{ $collection->code_url }}" target="_blank" class="btn btn-sm btn-success ms-2">
                            <i class="fa fa-code"></i> Código
                        </a>
                    @endif
                    @if ($collection->image_url)
                        <a href="{{ $collection->image_url }}" target="_blank" class="btn btn-sm btn-info ms-2">
                            <i class="fa fa-image"></i> Imagem
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <h4 class="mt-4 mb-3 fw-bold" style="color: {{ $principalColor }}">
        LOCALIZAÇÃO ATUAL
    </h4>
    <div class="border rounded p-3 bg-light">
        @if ($collection->currentLocation)
            <p><strong>Local:</strong> {{ $collection->currentLocation->location }}</p>
            @if ($collection->currentLocation->notes)
                <p><strong>Notas:</strong> {{ $collection->currentLocation->notes }}</p>
            @endif
            <p><strong>Movido em:</strong> {{ $collection->currentLocation->moved_at->format('d/m/Y H:i') }}</p>
            @if ($collection->currentLocation->user && $collection->currentLocation->user->contact)
                <p><strong>Por:</strong> {{ $collection->currentLocation->user->contact->name }}</p>
            @endif
        @else
            <p>Sem localização registrada</p>
        @endif

        <form action="{{ route('collection.add-location', $collection) }}" method="POST" class="mt-3">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label>Nova Localização:</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Notas:</label>
                    <input type="text" name="notes" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Data/Hora:</label>
                    <input type="datetime-local" name="moved_at" class="form-control"
                        value="{{ now()->format('Y-m-d\TH:i') }}">
                </div>
            </div>
            <button type="submit" class="btn mt-2 text-white" style="background-color: {{ $principalColor }};"
                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Atualizar Localização
            </button>
        </form>
    </div>

    @if ($collection->locations->count() > 1)
        <h4 class="mt-4 mb-3 fw-bold" style="color: {{ $principalColor }}">
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
    @endif
@endsection
