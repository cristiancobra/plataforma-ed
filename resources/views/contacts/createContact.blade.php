@extends('layouts/master')

@section('title','NOVO CONTATO')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('contact.index')}}">VER CONTATOS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('contact.store') }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	<label class="labels" for="" >DONO: </label>
	<select name="account_id">
		@foreach ($accounts as $account)
		<option  class="fields" value="{{ $account->id }}">
			{{ $account->name }}
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
	<label for="address_city">Cidade: </label>
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