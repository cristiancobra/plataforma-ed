@extends('layouts/edit')

@section('title', 'DOCUMENTOS')

@section('image-top')
    {{ asset('images/text.png') }}
@endsection

@section('form_start')
    <form action=' {{ route('text.update', ['text' => $text]) }} ' method='post' enctype="multipart/form-data">
        @csrf
        @method('put')
    @endsection


    @section('buttons')
        <a class='circular-button secondary' title='Cancelar alterações' href='{{ url()->previous() }}'>
            <i class='fas fa-times-circle'></i>
        </a>
        <button id='' class='circular-button primary' title='Salvar alterações'
            style='border:none;padding-left:4px;padding-top:2px' type='submit'>
            <i class='fas fa-save'></i>
        </button>
    @endsection

    @section('name')
        NOME:
        <input type='text' name='name' size='60' style="margin-left: 10px" value='{{ $text->name }}'>
    @endsection


    @section('priority')
        TIPO:
        {{ createSimpleSelect('type', 'fields', $types, $text->type) }}
    @endsection


    @section('status')
        SITUAÇÃO:
        {{ createSimpleSelect('status', 'fields', $status, $text->status) }}
    @endsection

    @section('fieldsId')
        <div class='col-lg-2 col-xs-6' style='text-align: center'>
            <div class='show-label'>
                RESPONSÁVEL
            </div>
        </div>
        <div class='col-lg-4 col-xs-6' style='text-align: center'>
            <div class='show-field-end'>
                <select name='user_id' style="width: 89%">
                    <option class='fields' value='{{ $text->user_id }}'>
                        {{ $text->user->contact->name }}
                    </option>
                    @foreach ($users as $user)
                        <option class='fields' value='{{ $user->id }}'>
                            {{ $user->contact->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class='col-lg-2 col-xs-6' style='text-align: center'>
            <div class='show-label'>
                DEPARTAMENTO
            </div>
        </div>
        <div class='col-lg-4 col-xs-6' style='text-align: center'>
            <div class='show-field-end'>
                {{ createSimpleSelect('department', 'fields', $departments, $text->department) }}
            </div>
        </div>
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
        <div>

            <label class='labels' for=''>TÍTULO:</label>
            <input type='title' name='title' style='width: 600px' value='{{ $text->title }}'>
            @if ($errors->has('title'))
                <span class='text-danger'>{{ $errors->first('title') }}</span>
            @endif
            <br>
            <br>
            <label class='labels' for=''>TEXTO:</label>
            <br>
            @if ($errors->has('text'))
                <span class='text-danger'>{{ $errors->first('text') }}</span>
            @endif
            <textarea id='text' name='text' rows='20' cols='120'>
  {{ $text->text }}
            </textarea>
            <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
            <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace('text');
            </script>

        @section('images')
            @if (count($text->images) > 0)
                <div class='show-label-large'>
                    IMAGENS
                </div>
                <div class='description-field'>
                    <div class="row">
                        @foreach ($text->images as $image)
                            <div class='col'>
                                <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->name }}"
                                    style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endsection

        <div class="row mt-3">
            <label class='labels' for=''>ANEXAR IMAGEM:</label>
            <input type='file' name='image'>
        </div>
    </div>

@endsection
