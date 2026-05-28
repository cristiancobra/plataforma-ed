@extends('layouts/master')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <x-buttons.list model="collection" :principalColor="$principalColor ?? null" />
@endsection

@section('main')
    @if (Session::has('failed'))
        <div class='alert alert-danger'>
            {{ Session::get('failed') }}
            @php
                Session::forget('failed');
            @endphp
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fa fa-exclamation-triangle"></i> Erro ao criar o item:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div>
        <form action=' {{ route('collection.store') }} ' method='post' enctype='multipart/form-data'>
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <label class='labels' for=''>NOME:</label>
                    <input type='text' name='name' class='form-control' value='{{ old('name') }}' required>
                    @if ($errors->has('name'))
                        <span class='text-danger'>{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class='labels' for=''>ACERVO:</label>
                    <x-form.select name="collections_group_id" :options="$collectionsGroupSelectOptions" :selected="old('collections_group_id')"
                        placeholder="Selecione o grupo" class="fields" />
                    @if ($errors->has('collections_group_id'))
                        <span class='text-danger'>{{ $errors->first('collections_group_id') }}</span>
                    @endif
                </div>

            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>TIPO:</label>
                    <div class="row">
                        @php
                            $col = 0;
                            $total = count($types);
                            $perCol = ceil($total / 4);
                        @endphp
                        @foreach ($types as $key => $value)
                            @if ($col % $perCol == 0)
                                <div class="col-md-3">
                            @endif
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_id" id="type_{{ $key }}"
                                    value="{{ $key }}" {{ old('type_id') == $key ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_{{ $key }}">{{ $value }}</label>
                            </div>
                            @php $col++; @endphp
                            @if ($col % $perCol == 0 || $loop->last)
                    </div>
                    @endif
                    @endforeach
                </div>
                @if ($errors->has('type_id'))
                    <span class='text-danger'>{{ $errors->first('type_id') }}</span>
                @endif
            </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for=''>CONTATO:</label>
            <x-form.select name="contact_id" :options="$contactsSelectOptions" placeholder="Não possui" class="fields" />
            @if ($errors->has('contact_id'))
                <span class='text-danger'>{{ $errors->first('contact_id') }}</span>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for=''>TÍTULO:</label>
            <input type='text' name='title' class='form-control' value='{{ old('title') }}'>
            @if ($errors->has('title'))
                <span class='text-danger'>{{ $errors->first('title') }}</span>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for=''>DESCRIÇÃO:</label>
            <textarea name='description' class='form-control' rows='4'>{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class='text-danger'>{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>NÚMERO PATRIMÔNIO:</label>
            <input type='text' name='patrimony_number' class='form-control' value='{{ old('patrimony_number') }}'>
        </div>

        <div class="col-md-6">
            <label class='labels' for=''>CÓDIGO DE CONTROLE:</label>
            <input type='text' name='control_code' class='form-control' value='{{ old('control_code') }}'>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>TAG DE RASTREAMENTO:</label>
            <input type='text' name='tracking_tag' class='form-control' value='{{ old('tracking_tag') }}'>
        </div>
        <div class="col-md-6">
            <label class='labels' for=''>LINK DE REDIRECIONAMENTO:</label>
            <input type='text' name='redirect_link' class='form-control' value='{{ old('redirect_link') }}'>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>NÚMERO DE SÉRIE:</label>
            <input type='text' name='serial_number' class='form-control' value='{{ old('serial_number') }}'>
        </div>
        <div class="col-md-6">
            <label class='labels' for=''>ACESSÓRIOS:</label>
            <textarea name='accessories' class='form-control' rows='2'>{{ old('accessories') }}</textarea>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>MARCA:</label>
            <input type='text' name='brand' class='form-control' value='{{ old('brand') }}'>
        </div>

        <div class="col-md-6">
            <label class='labels' for=''>MODELO:</label>
            <input type='text' name='model' class='form-control' value='{{ old('model') }}'>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>DATA DA COMPRA:</label>
            <input type='date' name='purchase_date' class='form-control' value='{{ old('purchase_date') }}'>
        </div>

        <div class="col-md-6">
            <label class='labels' for=''>DATA DE FABRICAÇÃO:</label>
            <input type='date' name='manufacturing_date' class='form-control'
                value='{{ old('manufacturing_date') }}'>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>SISTEMA OPERACIONAL:</label>
            <input type='text' name='operating_system' class='form-control' value='{{ old('operating_system') }}'>
        </div>

        <div class="col-md-6">
            <label class='labels' for=''>PLACA DE VÍDEO:</label>
            <input type='text' name='video_card' class='form-control' value='{{ old('video_card') }}'>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>MELHOR IA:</label>
            <input type='text' name='best_ai' class='form-control' value='{{ old('best_ai') }}'>
        </div>

        <div class="col-md-6">
            <label class='labels' for=''>SENHA:</label>
            <input type='text' name='password' class='form-control' value='{{ old('password') }}'>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for=''>USUÁRIOS:</label>
            <input type='text' name='users' class='form-control' value='{{ old('users') }}'>
        </div>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-md-6">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="runs_adobe" id="runs_adobe" value="1"
                    {{ old('runs_adobe') ? 'checked' : '' }}>
                <label class="form-check-label" for="runs_adobe">Roda no Adobe</label>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="runs_vrchat" id="runs_vrchat" value="1"
                    {{ old('runs_vrchat') ? 'checked' : '' }}>
                <label class="form-check-label" for="runs_vrchat">Roda no VRChat</label>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label class='labels' for=''>URL DO VÍDEO:</label>
            <input type='url' name='video_url' class='form-control' value='{{ old('video_url') }}'>
        </div>

        <div class="col-md-4">
            <label class='labels' for=''>URL DO CÓDIGO:</label>
            <input type='url' name='code_url' class='form-control' value='{{ old('code_url') }}'>
        </div>

        <div class="col-md-4">
            <label class='labels' for=''>URL DA IMAGEM:</label>
            <input type='url' name='image_url' class='form-control' value='{{ old('image_url') }}'>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label class='labels' for=''>LOCALIZAÇÃO INICIAL: <span class="text-danger">*</span></label>
            <input type='text' name='initial_location'
                class='form-control @error('initial_location') is-invalid @enderror'
                value='{{ old('initial_location') }}' required>
            @error('initial_location')
                <span class='text-danger'>{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label class='labels' for=''>SITUAÇÃO:</label>
            {{ createSimpleSelect('status', 'fields', $status) }}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <label class='labels' for=''>NOTAS DA LOCALIZAÇÃO:</label>
            <textarea name='location_notes' class='form-control' rows='2'>{{ old('location_notes') }}</textarea>
        </div>
    </div>

    <br>
    <p style='text-align: right'>
        <input class='btn btn-secondary' type='submit' value='CRIAR'>
    </p>
    </form>
    </div>
    <br>
    <br>
@endsection
