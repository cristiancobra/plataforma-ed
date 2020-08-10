@extends('layouts/master')

@section('title','EDITAR COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')

Altere seu email
<a href=" {{ route('user.index') }}"><br><br>
	<button type="button" class="button">VER COLABORADORES</button> </a>

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
		@foreach ($accounts as $account)
		
			<button class="button">
				<a href=" {{ route('accounts.show', ['account' => $account->id]) }} "  style="text-decoration: none;color: black">
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
	<label for="">Perfil: </label>
	<input type="text" name="perfil" value="{{ $user->perfil }} ">   
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
	<input type="submit" class="button" value="Atualizar dados">
</form>
</div>     
@endsection