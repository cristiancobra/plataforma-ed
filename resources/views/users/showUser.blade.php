@extends('layouts/master')

@section('title','COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href=" {{ route('user.index') }}">VER COLABORADORES</a>

@endsection

@section('main')
<div>
	<h1 class="name">{{ $user->name }} </h1>
	<br>
	<p class="labels">EMPRESAS: </p>

	@foreach ($user->accounts as $account)
	<a  class="white" href=" {{ route('user.show', ['user' => $user->id]) }}">
		<button class="button">
			<i class='fa fa-eye'></i>
		</button>
	</a>
	{{ $account->name }} 
	<br>
	@endforeach
	<br>
	<br>
	<p class="labels"> EMAIL:<span class="fields"> {{ $user->email }} </span></p>
	<p class="labels"> ID PLATAFORMA:<span class="fields"> {{ $user->id }} </span></p>
	<p class="labels"> SENHA: <span class="fields"> {{ $user->default_password }} </span></p>
	<p class="labels"> PERFIL: <span class="fields">  {{ $user->perfil }} </span></p>
	<br>
	<p class="fields">Criado em  {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

	<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
		<a class="btn btn-secondary" href=" {{ route('user.edit', ['user' => $user->id]) }}">
			<i class='fa fa-edit'>	
			</i>
			EDITAR
		</a>
	</div>
	<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
		<form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
	</div>
	<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
		<a class="btn btn-success" href="https://www.4devs.com.br/gerador_de_senha"  target="_blank">
			<i class='fa fa-edit'>	
			</i>
			GERADOR DE SENHA
		</a>
	</div>
	<br>
	<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>

@endsection