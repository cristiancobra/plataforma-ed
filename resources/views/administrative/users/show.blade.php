@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{asset('images/user.png')}}
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
    <div class='col-3'>
        <div class='profile-picture'>
            @if($user->image)
            <img src='{{asset($user->image->path)}}' width='100%' height='100%'>
            @else
            <img src='{{asset('images/user.png')}}' width='100%' height='100%'>
            @endif
        </div>
    </div>
    <div class='col-9'>
        <h1 class='name' style="margin-top: 20px">
            {{$user->contact->name}}
        </h1>
    <br>
    <p class='labels'>
        EMAIL:<span class='fields'> {{$user->email}} </span>
    </p>
    <p class='labels'>
        ID PLATAFORMA:<span class='fields'> {{$user->id}} </span>
    </p>
    <p class='labels'>
        PERFIL: <span class='fields'>  {{$user->perfil}} </span>
    </p>
    <br>
    <p class='fields'>Criado em  {{date('d/m/Y H:i', strtotime($user->created_at))}}
    </p>
</div>

<div style='text-align: right'>
    <div style='text-align:right;color: #874983; display: inline-block'>
        <form action='{{ route('user.destroy', ['user' => $user->id]) }}' method='post'>
            @csrf
            @method('delete')
            <button id='' class='circular-button delete' style='border:none;padding-left:7px;padding-top: -2px' "type='submit'>
                <i class='fa fa-trash'></i>
            </button>
        </form>
    </div>
    <div style='text-align:right;color: #874983;display: inline-block'>
        <a class='circular-button secondary' href=' {{ route('user.edit', ['user' => $user->id]) }}'>
            <i class='fa fa-edit'></i>
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