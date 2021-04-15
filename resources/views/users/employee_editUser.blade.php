@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('user.index')}}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<form action=" {{ route('user.update', ['user' =>$user->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<label for="" >Nome: </label>
	<input type="text" name="name" value="{{ $user->name }}">
	<br>
	<label for="" >Email: </label>
	<input type="text" name="email" value="{{ $user->email }} ">
	<br>
	<br>
	<label for="">Senha padrão: </label>
	<span class="fields"> {{ $user->default_password }}</span>
	<br>
	<label for="">Alterar senha: </label>
	<input type="text" name="password" value="">   
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" class="button" value="Atualizar dados">
</form>
</div>     
@endsection