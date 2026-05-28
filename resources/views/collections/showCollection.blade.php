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
            ACERVO
        </div>
        <div class="col-10 border border-start-0 text-center py-2">
            @if ($collection->collectionsGroup)
                {{ $collection->collectionsGroup->name }}
            @else
                -
            @endif
        </div>
    </div>
    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            REGISTRADO POR
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
            RESPONSÁVEL
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            @if ($collection->contact)
                <a href="{{ route('contact.show', ['contact' => $collection->contact->id]) }}" class="text-decoration-none">
                    {{ $collection->contact->name }}
                </a>
            @else
                -
            @endif
        </div>
    </div>

    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            CATEGORIA
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ optional($collection->collectionType)->category ?? '-' }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            TIPO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ optional($collection->collectionType)->name ?? '-' }}
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
            TAG DE RASTREAMENTO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->tracking_tag ?? '-' }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            LINK DE REDIRECIONAMENTO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            @if ($collection->redirect_link)
                <a href="{{ $collection->redirect_link }}" target="_blank">{{ $collection->redirect_link }}</a>
            @else
                -
            @endif
        </div>
    </div>
    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            NÚMERO DE SÉRIE
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->serial_number ?? '-' }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            ACESSÓRIOS
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->accessories ?? '-' }}
        </div>
    </div>


    <div class="row g-0 mb-3">
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            MODELO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->model ?? '-' }}
        </div>
        <div class="col-2 text-white text-center py-2" style="background-color: {{ $principalColor }}">
            PATRIMÔNIO
        </div>
        <div class="col-4 border border-start-0 text-center py-2">
            {{ $collection->patrimony_number ?? '-' }}
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
    <div class="row g-0 mb-3">
        <h4 class="mt-4 mb-3 fw-bold" style="color: {{ $principalColor }}">
            ESPECIFICAÇÕES TÉCNICAS
        </h4>
    </div>
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
                <p><strong>Roda no Adobe:</strong> {{ $collection->runs_adobe ? 'Sim' : 'Não' }}</p>
                <p><strong>Roda no VRChat:</strong> {{ $collection->runs_vrchat ? 'Sim' : 'Não' }}</p>
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

@section('attachments')
    <div class="row g-0 mb-3">
        <h4 class="mt-5 mb-3 fw-bold" style="color: {{ $principalColor }}">
            DOCUMENTOS
        </h4>
    </div>
    <div class="border rounded p-3 bg-light mb-4">
        @if ($collection->attachments && $collection->attachments->count())
            <div class="row mt-3">
                @foreach ($collection->attachments as $attachment)
                    <div class='col-md-3 mb-4'>
                        <div class="card text-center p-3 h-100 shadow-sm" style="border: 2px solid #e0e0e0;">
                            <i class="fa fa-file-invoice-dollar"
                                style="font-size: 60px; color:{{ $principalColor }}"></i>
                            <div class="mt-2">
                                <span class="badge bg-secondary text-white"
                                    style="font-size: 11px;">{{ $attachment->type }}</span>
                            </div>
                            <div class="mt-2">
                                <strong style="font-size: 13px;">{{ Str::limit($attachment->name, 30) }}</strong>
                            </div>
                            <small class="text-muted mt-2">{{ date('d/m/Y', strtotime($attachment->created_at)) }}</small>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <form action="{{ route('attachment.destroy', ['attachment' => $attachment->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este documento?');"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                        <i class="fa fa-trash"></i> Excluir
                                    </button>
                                </form>
                                <a href="{{ asset('storage/' . $attachment->path) }}" download="{{ $attachment->name }}"
                                    class="btn btn-sm" title="Baixar"
                                    style="background-color: {{ $principalColor }}; color: white;">
                                    <i class="fa fa-download"></i> Baixar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-3">Nenhum documento anexado ainda.</p>
        @endif

        <div class='row mt-5 pt-4' style='border-top: 2px solid #e0e0e0;'>
            <div class='col-12'>
                <h5 class='mb-3' style='color:{{ $principalColor }}'>
                    <i class="fa fa-plus-circle me-2"></i>
                    ADICIONAR NOVO DOCUMENTO
                </h5>
            </div>
        </div>
        <form action="{{ route('attachment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="collection_id" value="{{ $collection->id }}">
            <div class='row mt-3'>
                <div class='col-md-4'>
                    <label class='labels mb-2' for='attachment_type'>Tipo de documento:</label>
                    <select id='attachment_type' name='type' class='form-control' required>
                        <option value=''>Selecione o tipo</option>
                        <option value='Nota fiscal'>Nota fiscal</option>
                        <option value='Termo de empréstimo'>Termo de empréstimo</option>
                    </select>
                </div>
                <div class='col-md-4'>
                    <label class='labels mb-2' for='attachment_file'>Selecione o arquivo PDF:</label>
                    <input type='file' id='attachment_file' name='attachment' accept=".pdf" class='form-control'
                        required>
                </div>
                <div class='col-md-4'>
                    <button type="submit" class='btn w-100'
                        style="margin-top: 32px; background-color: {{ $principalColor }}; color: white;">
                        <i class="fa fa-upload me-2"></i> Enviar Documento
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
