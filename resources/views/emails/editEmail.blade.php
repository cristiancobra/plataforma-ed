@extends('layouts/master')

@section('title','EDITAR EMAIL')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Altere seu email
<a href="/emails/"><br><br>
	<button type="button" class="button">VER EMAILS</button> </a>

@endsection

@section('main')
<form action=" {{ route('user.update', ['user' =>$user->id]) }} " method="post" style="padding: 40px;color: #874983">
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
@endsection