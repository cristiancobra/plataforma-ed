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
                    <label class='labels' for=''>CATEGORIA:</label>
                    {{ createSimpleSelect('category', 'fields', $categories) }}
                    @if ($errors->has('category'))
                        <span class='text-danger'>{{ $errors->first('category') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>TIPO:</label>
                    {{ createSimpleSelect('type', 'fields', $types) }}
                    @if ($errors->has('type'))
                        <span class='text-danger'>{{ $errors->first('type') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>CONTATO:</label>
                    {{ createDoubleSelectIdName('contact_id', 'fields', $contacts, 'Não possui') }}
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
                    <input type='text' name='patrimony_number' class='form-control'
                        value='{{ old('patrimony_number') }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>CÓDIGO DE CONTROLE:</label>
                    <input type='text' name='control_code' class='form-control' value='{{ old('control_code') }}'>
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
                    <input type='text' name='operating_system' class='form-control'
                        value='{{ old('operating_system') }}'>
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

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>RODA NO ADOBE:</label>
                    <input type='text' name='runs_adobe' class='form-control' value='{{ old('runs_adobe') }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>RODA NO VRCHAT:</label>
                    <input type='text' name='runs_vrchat' class='form-control' value='{{ old('runs_vrchat') }}'>
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
