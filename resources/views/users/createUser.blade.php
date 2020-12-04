@extends('layouts/master')

@section('title','NOVO COLABORADOR')

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
		<label class="labels"for="" >Email (login): </label>
		<input class="fields" type="text" name="email">
		<br>
		<br>
		<label class="labels"'for="" >Perfil: </label>
		<select name="perfil">
			<option  class="fields" value="cliente">
				super administrador
			</option>
			<option  class="fields" value="administrador">
				administrador
			</option>
			<option  class="fields" value="administrador">
				funcionário
			</option>
		</select>
		<br>
		<br>
		<label class="labels"for="">Senha do usuário: </label>
		<input class="fields" type="password" name="password">   
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