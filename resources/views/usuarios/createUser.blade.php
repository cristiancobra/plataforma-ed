@extends('layouts/master')

@section('title','ADICIONAR COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('user.index')}}">VER COLABORADORES</a>
@endsection

@section('main')
<br>
<br>
<div style="padding-left: 6%">
	<form action=" {{ route('user.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >Primeiro nome: </label>
		<input class="fields" type="text" name="novo_nome">
		<br>
		<br>
		<label class="labels"for="" >Último nome: </label>
		<input class="fields" type="text" name="novo_sobrenome">
		<br>
		<br>
		<label class="labels"'for="" >Perfil: </label>
		<select name="user_id">
			<option  class="fields" value="cliente">
				cliente
			</option>
			<option  class="fields" value="cliente">
				administrador
			</option>
		</select>
		<br>
		<br>
		<label class="labels"for="">Senha do usuário: </label>
		<input class="fields" type="password" name="password" value="{{ $user->gerarSenha(8, true, true, true, true) }}">   
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR PLATAFORMA">
	</form>
</div>     
@endsection