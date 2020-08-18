@extends('layouts/master')

@section('title','COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href=" {{ route('user.index') }}">VER COLABORADORES</a>

@endsection

@section('main')
<br>
<br>
<div style="padding-left: 6%">
<h1 class="name">{{ $user->name }} </h1>
<br>
<p class="labels">EMPRESAS: </p>
	
	@foreach ($accounts as $account)
	<p class="fields">{{ $account->name }}  </p>
	@endforeach
	
	<p class="labels"> EMAIL:<span class="fields"> {{ $user->email }} </span></p>
<p class="labels"> DOMÍNIO:<span class="fields">  {{ $user->dominio }} </span></p>
<p class="labels"> ID PLATAFORMA:<span class="fields"> {{ $user->id }} </span></p>
<p class="labels"> ID CRM:<span class="fields">  {{ $user->idcrm }} </span></p>
<p class="labels"> SENHA: <span class="fields"> {{ $user->default_password }} </span></p>
<p class="labels"> PERFIL: <span class="fields">  {{ $user->perfil }} </span></p>
<br>
<p class="fields">Criado em  {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
	<button class="btn btn-secondary"><a href=" {{ route('user.edit', ['user' => $user->id]) }} "  style="text-decoration: none;color: black"><i class='fa fa-edit'></i>Editar informações</a></button>
</div>
<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
	<form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
</div>
<br>
<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>

@endsection