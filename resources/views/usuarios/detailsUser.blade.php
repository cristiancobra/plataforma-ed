@extends('layouts/master')

@section('title','COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')

Dados do colaborador
<a href=" {{ route('user.index') }}"><br><br>
	<button type="button" class="button">VER COLABORADORES</button> </a>

@endsection

@section('main')
<br>
<br>
<h1 style="text-align:left;color: #874983;padding-left: 30px"><b> Nome: </b> {{ $user->name }} </h1>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Empresas: </b><br></p>
	@foreach ($accounts as $account)
	<p style="text-align:left;color: #874983;padding-left: 30px">{{ $account->name }}  </p>
	@endforeach
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Email: </b> {{ $user->email }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Domínio: </b> {{ $user->dominio }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  ID da Plataforma: </b> {{ $user->id }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  ID do CRM: </b> {{ $user->idcrm }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Senha: </b> {{ $user->default_password }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Perfil: </b> {{ $user->perfil }} </p>
<br>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
	<button class="button"><a href=" {{ route('user.edit', ['user' => $user->id]) }} "  style="text-decoration: none;color: black"><i class='fa fa-edit'></i>Editar informações</a></button>
</div>
<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
	<form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="button-delete" type="submit" value="APAGAR">
	</form>
</div>
<br>
<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>


@endsection