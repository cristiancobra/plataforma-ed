@extends('layouts/master')

@section('title','USUÁRIOS')

@section('image-top')
{{asset('images/user.png')}}
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('user')}}
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div>
    <form action="{{route('user.store')}}" method="post">
        @csrf
        <label class="labels"'for="" >Contato: </label>
        {{createSelectIdName('contact_id', 'fields', $contacts, null)}}
        {{createButtonAdd('contact.create', 'type', 'funcionário')}}
        <br>
        <label class="labels"for="" >Email (login): </label>
        <input class="fields" type="text" name="email" value="{{old('email')}}">
        @if ($errors->has('email'))
        <span class="text-danger">{{$errors->first('email')}}</span>
        @endif
        <br>
        <br>
        <label class="labels"'for="" >Perfil: </label>
        <select name="perfil">
            <option  class="fields" value="administrador">
                administrador
            </option>
            <option  class="fields" value="funcionario">
                funcionário
            </option>
        </select>
        <br>
        <label class="labels"for="">Senha do usuário: </label>
        <input class="fields" type="password" name="password" value="{{old('password')}}">
        @if ($errors->has('password'))
        <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
        <br>
        <br>
        <input class="btn btn-secondary" type="submit" value="CRIAR">
    </form>
</div>     
@endsection