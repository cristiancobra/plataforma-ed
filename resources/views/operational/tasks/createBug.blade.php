@extends('layouts/master')

@section('title','BUGS')

@section('image-top')
{{ asset('images/task.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
@endsection

@section('main')
@if(Session::has('failed'))
<div class='alert alert-danger'>
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div class='row'>
    <div class='col-12'>
        @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
        <form action=' {{route('task.storeBug')}} ' method='post' enctype='multipart/form-data'>
            @csrf
            <label class='labels' for='' >RELATADO POR: </label>
            <input type='hidden' name='contact_id' value='{{auth()->user()->contact_id}}'>
            {{auth()->user()->contact->name}}
            <br>
            <span class='labels'>da</span>
            {{auth()->user()->account->name}}
            <br>
            <br>
            <label class='labels' for='' >PRIORIDADE:</label>
            {{createSimpleSelect('priority', 'fields', $priorities)}}
            <br>
            <br>
            <label class='labels' for='' >ONDE OCORREU:</label>
            {{createSimpleSelect('module', 'select', $modules)}}
            <br>
            <br>
            <label class='labels' for='' >O QUE VOCÊ ESTÁVA FAZENDO:</label>
            {{createSimpleSelect('action', 'select', $actions)}}
            <br>
            <br>
            <label class='labels' for='' >ANEXAR IMAGEM (opcional):</label>
            <input type='file' name='image'>
            <br>
            <br>
    <label class='labels' for='' >OBSERVAÇÕES:</label>
    <textarea id='description' name='description' rows='20' cols='90'>
{{old('description')}}
    </textarea>
    <!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
    <script src='//cdn.ckeditor.com/4.5.7/standard/ckeditor.js'></script>
    <script>
CKEDITOR.replace('description');
    </script>
    <br>
    <br>
    <p style='text-align: right'>
        <input class='btn btn-secondary' type='submit' value='REPORTAR BUG'>
    </p>
</form>
</div>
@endsection