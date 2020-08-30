@extends('layouts/master')

@section('title','Nova Empresa')

@section('image-top')
{{ asset('imagens/novo-email.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('account.index')}}">VER EMPRESAS</a>
@endsection

@section('main')
<form action=" {{ route('account.store') }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	<label for="" >Nome: </label>
	<input type="text" name="name">
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
	<input type="text" name="address_country">   
	<br>
	<br>
	<label for="">Tipo: </label>
	<input type="text" name="type">   
	<br>
	<label for="">Qtde empregados: </label>
	<input type="text" name="employees">   
	<br>
	<label class="labels" for="" >Colaboradores: </label>
	<br>
	@foreach ($users as $user)
	<p class="fields">
		<input type="checkbox" name="users[]" value="{{ $user->id }}">
		{{ $user->name }}
	</p>
	@endforeach
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" value="Solicitar empresa">
</form>
@endsection