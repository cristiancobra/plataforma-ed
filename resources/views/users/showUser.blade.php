@extends('layouts/master')

@section('title','COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('user.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<h1 class="name">{{ $user->contact->name }} </h1>
	<br>
	<p class="labels">EMPRESAS: </p>

	@foreach ($user->accounts as $account)
	<a  class="white" href=" {{ route('user.show', ['user' => $user->id]) }}">
		<button class="button-round">
			<i class='fa fa-eye'></i>
		</button>
	</a>
	{{$account->name}}
	<br>
	@endforeach
	<br>
	<br>
	<p class="labels">
		EMAIL:<span class="fields"> {{$user->email}} </span>
	</p>
	<p class="labels">
		ID PLATAFORMA:<span class="fields"> {{$user->id}} </span>
	</p>
	<p class="labels">
		SENHA: <span class="fields"> {{$user->default_password}} </span>
	</p>
	<p class="labels">
		PERFIL: <span class="fields">  {{$user->perfil}} </span>
	</p>
	<br>
	<p class="fields">Criado em  {{date('d/m/Y H:i', strtotime($user->created_at))}}
	</p>

	<div style="text-align: right">
		<div style="text-align:right;color: #874983; display: inline-block">
			<form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
				@csrf
				@method('delete')
				<input class="button-secondary" type="submit" value="APAGAR">
			</form>
		</div>
		<div style="text-align:right;color: #874983;display: inline-block">
			<a class="button-secondary" href=" {{ route('user.edit', ['user' => $user->id]) }}">
				<i class='fa fa-edit'>	
				</i>
				EDITAR
			</a>
		</div>
		<a class="button-primary"  href="{{route('user.index')}}">
			VOLTAR
		</a>
	</div>
	<br>
	<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>

@endsection