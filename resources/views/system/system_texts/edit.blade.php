@extends('layouts/edit')

@section('title','TEXTOS DO SISTEMA')

@section('image-top')
{{ asset('images/text.png') }} 
@endsection

@section('form_start')
<form action=' {{route('systemText.update', ['systemText' => $systemText])}} ' method='post'>
    @csrf
    @method('put')
    @endsection


    @section('buttons')
    <a class='circular-button secondary'  title='Cancelar alterações' href='{{url()->previous()}}'>
        <i class='fas fa-times-circle'></i>
    </a>
    <button id='' class='circular-button primary' title='Salvar alterações' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
        <i class='fas fa-save'></i>
    </button>
    @endsection

    @section('name')
    NOME:
    <input type='systemText' name='name' size='60' style="margin-left: 10px" value='{{$systemText->name}}'>
    @endsection


    @section('priority')
    TIPO:
    {{createSimpleSelect('type', 'fields', $types, $systemText->type)}}
    @endsection

    
    @section('status')
    SITUAÇÃO:
    {{createSimpleSelect('status', 'fields', $status, $systemText->status)}}
    @endsection

    @section('fieldsId')
    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            DEPARTAMENTO
        </div>
    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>
        <div class='show-field-end'>
            {{createSimpleSelect('department', 'fields', $departments, $systemText->department)}}
        </div>
    </div>
    <div class='col-lg-2 col-xs-6' style='text-align: center'>

    </div>
    <div class='col-lg-4 col-xs-6' style='text-align: center'>

    </div>
    @endsection


    @section('main')
    <div>
        <form action=' {{route('text.store')}} ' method='post' enctype='multipart/form-data'>
            @csrf
            <br>
            <label class='labels' for='' >TÍTULO:</label>
            <input type='title' name='title' style='width: 600px' value='{{$systemText->title}}'>
            @if ($errors->has('title'))
            <span class='text-danger'>{{$errors->first('title')}}</span>
            @endif
            <br>
            <br>
            <label class='labels' for='' >TEXTO:</label>
            <br>
            @if ($errors->has('systemText'))
            <span class='text-danger'>{{$errors->first('text')}}</span>
            @endif
            <div class="row mb-5">
                <div class="col">
            <textarea id='systemText' name='text' rows='200' cols='320'>
  {{$systemText->text}}
            </textarea>
        <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
        <script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
        <script>
CKEDITOR.replace('systemText');
        </script>
            </div>
            </div>
            <label class='labels' for='' >ANEXAR IMAGEM:</label>
            <input type='file' name='image'>
            <br>
            <br>
    </div>
    <br>
    <br>
    @endsection