@extends('layouts/create')

@section('title','Adicionar emal')

@section('content')


<br><br><br><p class="titulo-branco"> Solicitar novo Email</p>
<br>
<form action=" {{ route('emails.store') }} " method="post" style="padding: 40px;color: white">
	@csrf
	<label for="" >Email completo: </label>
	<input type="text" name="email">
	<br>
	<br>
	<label for="" >Usuario: </label>
	<input type="text" name="user_id">
	<br>
	<br>
	<label for="" >Empresa: </label>
	<select name="account_id">
	@foreach ($users_id as $user_id)
	<option value="{{ $user_id->id }}">
		nome
			</option>
	@endforeach
	</select>
<!--<input type="text" name="account_id">-->
	<br>
	<br>
	<label for="" >Perfil: </label>
	<input type="text" name="perfil_id">
	<br>
	<br>
	<label for="">Senha do email: </label>
	<input type="password" name="password" value="">   
	<br>
	<br>
	<input type="submit" value="Solicitar email">

</form>
</div>     

<div class="imagem">
	<img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
</div>

@endsection