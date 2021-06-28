@extends('layouts/master')

@section('title','NOVO COLABORADOR')

@section('image-top')
{{asset('images/colaborador.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
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
        <label for="" >Empresas: </label>
        @foreach ($accounts as $account)
        <p class="fields">
            <input type="checkbox" name="accounts[]" value="{{$account->id}}"
                   @if (in_array($account->id, $accountsChecked))
            checked
            @endif
            >
            {{$account->name}}
        </p>
        @endforeach
        <br>
        <label class="labels"'for="" >Contato: </label>
        <select name="contact_id">
            @foreach($contacts as $contact)
            <option  class="fields" value="{{$contact->id}}">
                {{$contact->name}}
            </option>
            @endforeach
        </select>
        {{createButtonAdd('contact.create')}}
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
        <input class="btn btn-secondary" type="submit" value="SOLICITAR USUÁRIO">
        <div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
            <a class="btn btn-success" href="https://www.4devs.com.br/gerador_de_senha" target="_blank">
                <i class='fa fa-edit'>	
                </i>
                GERADOR DE SENHA
            </a>
        </div>
    </form>
</div>     
@endsection