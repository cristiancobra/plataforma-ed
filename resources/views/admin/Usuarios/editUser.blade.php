@extends('layouts/create')

@section('title','Editar usuário')

@section('content')


<br><br><br><p class="titulo-branco"> Editar usuário</p>
<br>
<form action=" {{ route('user.update', ['user' =>$user->id]) }} " method="post" style="padding: 40px;color: white">
	@csrf
	@method('put')
	<label for="" >Nome: </label>
	<input type="text" name="name" value="{{ $user->name }}">
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
	<input type="submit" value="Atualizar dados do usuário">

</form>
</div>     

<div class="imagem">
	<img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
</div>

@endsection