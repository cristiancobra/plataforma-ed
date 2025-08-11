@extends('layouts/master')

@section('title','IMPORTAR CONTATOS')

@section('image-top')
{{asset('images/contact.png')}} 
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
<div>
    <form action='{{route('contact.import')}}' method='post' enctype='multipart/form-data'>
        @csrf
        <label class='labels' for='account_id'>EMPRESA: </label>
        {{createSelectIdName('account_id', 'fields', $accounts)}}
        <br>
        <br>
        <label class='labels' for='delimiter'>DELIMITADOR DO CSV: </label>
        <select class='fields' name='delimiter'>
            <option value=','>vírgula</option>
            <option value=';'>ponto-e-vírgula</option>
        </select>
        <br>
        <br>
        <label class='labels'  for='file'>SELECIONAR ARQUIVO: </label>
        <br>
        <input type='file' name='sheet' class='form-control'>
        <br>
        <input class='btn btn-secondary' type='submit' value='IMPORTAR'>
        <br>
    </form>
</div>
@endsection
