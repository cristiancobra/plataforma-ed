@extends('layouts/master')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    {{ createButtonList('collection') }}
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
            <strong><i class="fa fa-exclamation-triangle"></i> Erro ao atualizar o item:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div>
        <form action='{{ route('collection.update', $collection) }}' method='post' enctype='multipart/form-data'>
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <label class='labels' for=''>NOME:</label>
                    <input type='text' name='name' class='form-control' value='{{ old('name', $collection->name) }}'
                        required>
                    @if ($errors->has('name'))
                        <span class='text-danger'>{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>CATEGORIA:</label>
                    {{ createSimpleSelect('category', 'fields', $categories, old('category', $collection->category)) }}
                    @if ($errors->has('category'))
                        <span class='text-danger'>{{ $errors->first('category') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>TIPO:</label>
                    {{ createSimpleSelect('type', 'fields', $types, old('type', $collection->type)) }}
                    @if ($errors->has('type'))
                        <span class='text-danger'>{{ $errors->first('type') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>TÍTULO:</label>
                    <input type='text' name='title' class='form-control'
                        value='{{ old('title', $collection->title) }}'>
                    @if ($errors->has('title'))
                        <span class='text-danger'>{{ $errors->first('title') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>DESCRIÇÃO:</label>
                    <textarea name='description' class='form-control' rows='4'>{{ old('description', $collection->description) }}</textarea>
                    @if ($errors->has('description'))
                        <span class='text-danger'>{{ $errors->first('description') }}</span>
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>NÚMERO PATRIMÔNIO:</label>
                    <input type='text' name='patrimony_number' class='form-control'
                        value='{{ old('patrimony_number', $collection->patrimony_number) }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>CÓDIGO DE CONTROLE:</label>
                    <input type='text' name='control_code' class='form-control'
                        value='{{ old('control_code', $collection->control_code) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>MARCA:</label>
                    <input type='text' name='brand' class='form-control'
                        value='{{ old('brand', $collection->brand) }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>MODELO:</label>
                    <input type='text' name='model' class='form-control'
                        value='{{ old('model', $collection->model) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>DATA DA COMPRA:</label>
                    <input type='date' name='purchase_date' class='form-control'
                        value='{{ old('purchase_date', $collection->purchase_date ? $collection->purchase_date->format('Y-m-d') : '') }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>DATA DE FABRICAÇÃO:</label>
                    <input type='date' name='manufacturing_date' class='form-control'
                        value='{{ old('manufacturing_date', $collection->manufacturing_date ? $collection->manufacturing_date->format('Y-m-d') : '') }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>SISTEMA OPERACIONAL:</label>
                    <input type='text' name='operating_system' class='form-control'
                        value='{{ old('operating_system', $collection->operating_system) }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>PLACA DE VÍDEO:</label>
                    <input type='text' name='video_card' class='form-control'
                        value='{{ old('video_card', $collection->video_card) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>MELHOR IA:</label>
                    <input type='text' name='best_ai' class='form-control'
                        value='{{ old('best_ai', $collection->best_ai) }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>SENHA:</label>
                    <input type='text' name='password' class='form-control'
                        value='{{ old('password', $collection->password) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>USUÁRIOS:</label>
                    <input type='text' name='users' class='form-control'
                        value='{{ old('users', $collection->users) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label class='labels' for=''>RODA NO ADOBE:</label>
                    <input type='text' name='runs_adobe' class='form-control'
                        value='{{ old('runs_adobe', $collection->runs_adobe) }}'>
                </div>

                <div class="col-md-6">
                    <label class='labels' for=''>RODA NO VRCHAT:</label>
                    <input type='text' name='runs_vrchat' class='form-control'
                        value='{{ old('runs_vrchat', $collection->runs_vrchat) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label class='labels' for=''>URL DO VÍDEO:</label>
                    <input type='url' name='video_url' class='form-control'
                        value='{{ old('video_url', $collection->video_url) }}'>
                </div>

                <div class="col-md-4">
                    <label class='labels' for=''>URL DO CÓDIGO:</label>
                    <input type='url' name='code_url' class='form-control'
                        value='{{ old('code_url', $collection->code_url) }}'>
                </div>

                <div class="col-md-4">
                    <label class='labels' for=''>URL DA IMAGEM:</label>
                    <input type='url' name='image_url' class='form-control'
                        value='{{ old('image_url', $collection->image_url) }}'>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label class='labels' for=''>SITUAÇÃO:</label>
                    {{ createSimpleSelect('status', 'fields', $status, old('status', $collection->status)) }}
                </div>
            </div>

            <br>
            <p style='text-align: right'>
                <input class='btn btn-secondary' type='submit' value='ATUALIZAR'>
            </p>
        </form>
    </div>
    <br>
    <br>
@endsection
