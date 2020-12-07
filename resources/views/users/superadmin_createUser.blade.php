@extends('layouts/master')

@section('title','NOVO COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('user.index')}}">
	VOLTAR
</a>
<a class="button-primary"  href="{{route('user.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('user.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels"'for="" >Empresa: </label>
		<select name="account[]">
			@foreach($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >Primeiro nome: </label>
		<input class="fields" type="text" name="novo_nome">
		<br>
		<label class="labels"for="" >Último nome: </label>
		<input class="fields" type="text" name="novo_sobrenome">
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