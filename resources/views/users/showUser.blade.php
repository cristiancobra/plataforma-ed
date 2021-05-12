@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='button-secondary'  href='{{route('user.index')}}'>
    <i class='fas fa-arrow-left'></i>
</a>
@endsection

@section('main')
<div class='row'>
    <div class='col-8'>
        <h1 class='name'>
            {{$user->contact->name}}
        </h1>
        <p class='labels' style='margin-top: 20px'>EMPRESAS: </p>
    </div>
    <div class='col-4'>
        <div>
            <img src='{{$user->profile_picture}}'>
        </div>
        <form action='{{route('user.picture')}}' method='post' enctype='multipart/form-data'>
            @csrf
            @method('put')
            <input type='file' name='profile_picture'>
            <input type='hidden' name='account_id' value="{{$user->account_id}}">
            <button type='submit'>
                ENVIAR FOTO
            </button>
        </form>
</div>

@foreach ($user->accounts as $account)
<a  class='white' href=' {{route('account.show', ['account' => $account->id])}}'>
    <button class='button-round'>
        <i class='fa fa-eye'></i>
    </button>
</a>
{{$account->name}}
<br>
@endforeach
<br>
<br>
<p class='labels'>
    EMAIL:<span class='fields'> {{$user->email}} </span>
</p>
<p class='labels'>
    ID PLATAFORMA:<span class='fields'> {{$user->id}} </span>
</p>
<p class='labels'>
    SENHA: <span class='fields'> {{$user->default_password}} </span>
</p>
<p class='labels'>
    PERFIL: <span class='fields'>  {{$user->perfil}} </span>
</p>
<br>
<p class='fields'>Criado em  {{date('d/m/Y H:i', strtotime($user->created_at))}}
</p>

<div style='text-align: right'>
    <div style='text-align:right;color: #874983; display: inline-block'>
        <form action='{{ route('user.destroy', ['user' => $user->id]) }}' method='post'>
            @csrf
            @method('delete')
            <input class='button-secondary' type='submit' value='APAGAR'>
        </form>
    </div>
    <div style='text-align:right;color: #874983;display: inline-block'>
        <a class='button-secondary' href=' {{ route('user.edit', ['user' => $user->id]) }}'>
            <i class='fa fa-edit'>	
            </i>
            EDITAR
        </a>
    </div>
    <a class='circular-button primary'  href='{{route('user.index')}}'>
        <i class='fas fa-arrow-left'></i>
    </a>
</div>
<br>
<p style='text-align: left;margin-left: 30px;color: white;font-size: 14px'>* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>

@endsection