@extends('layouts/master')

@section('title','NOVO CONTATO')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('contact.index')}}">VER EMAILS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('contact.store') }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	<label class="labels" for="" >DONO: </label>
	<select name="user_id">
		@foreach ($users as $user)
		<option  class="fields" value="{{ $user->id }}">
			{{ $user->name }}
		</option>
		@endforeach
	</select>
	<br>
	<br>
	<label for="" >Primeiro nome: </label>
	<input type="text" name="first_name">
	<br>
	<label for="" >Sobrenome: </label>
	<input type="text" name="last_name">
	<br>
	<label for="" >Email: </label>
	<input type="text" name="email">
	<br>
	<label for="">Telefone: </label>
	<input type="text" name="phone">   
	<br>
	<label for="">Site: </label>
	<input type="text" name="site">   
	<br>
	<br>
	<label for="">Endereço: </label>
	<input type="text" name="address">   
	<br>
	<label for="">Cidade: </label>
	<input type="text" name="address_city">   
	<br>
	<label for="">Estado: </label>
	<input type="text" name="address_state">   
	<br>
	<label for="">País: </label>
	<input type="text" name="address_country" value="Brasil">   
	<br>
	<br>
	<label for="">Tipo: </label>
	<input type="text" name="type">   
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" value="Criar contato">
</form>
</div>     
@endsection