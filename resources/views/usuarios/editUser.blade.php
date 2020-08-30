@extends('layouts/master')

@section('title','EDITAR COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href=" {{ route('user.index') }}">VER COLABORADORES</a>
@endsection

@section('main')
<form action=" {{ route('user.update', ['user' =>$user->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<label for="" >Nome: </label>
	<input type="text" name="name" value="{{ $user->name }}">
	<br>
	<br>
	<label for="" >Empresas: </label>
	@foreach ($user->accounts as $account)
	<button class="button">
		<a href=" {{ route('account.show', ['account' => $account->id]) }} ">
			<i class='fa fa-eye'></i></a>
	</button>
	{{ $account->name }}
	@endforeach
</select>
<br>
<br>
<label for="" >Email: </label>
<input type="text" name="email" value="{{ $user->email }} ">
<br>
<br>
<label for="">Domínio: </label>
<input type="text" name="dominio" value="{{ $user->dominio }} ">   
<br>
<br>
<label class="labels" for="" >Perfil:</label>
<select class="fields" name="perfil">
	<option value="{{ $user->perfil }}">{{ $user->perfil }}</option>
	<option value="cliente">cliente</option>
	<option value="administrador">administrador</option>
</select>
<br>
<br>
<label for="">Senha padrão: </label>
<input type="text" name="default_password" value="{{ $user->default_password }} ">   
<br>
<br>
<label for="">Alterar senha: </label>
<input type="text" name="password" value="">   
<br>
<br>
<input class="btn btn-secondary" type="submit" class="button" value="Atualizar dados">
</form>
</div>     
@endsection