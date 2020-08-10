@extends('layouts/master')

@section('title','ADICIONAR COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')

Solicite seu email
<a href="/emails/"><br><br>
	<button type="button" class="button-header">VER EMAILS</button> </a>

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
	<input class="fields"  type="text" name="perfil">
	<br>
	<br>
	<label class="labels"for="">Senha do usuário: </label>
	<input class="fields" type="password" name="password" value="{{ $newUser->gerarSenha(8, true, true, true, true) }}">   
	<br>
	<br>
	<input class="button-header" type="submit" value="CRIAR PLATAFORMA">
</form>
</div>     
@endsection