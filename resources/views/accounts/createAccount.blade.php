@extends('layouts/master')

@section('title','Nova Empresa')

@section('image-top')
{{ asset('imagens/novo-email.png') }} 
@endsection

@section('description')

solicite sua nova empresa
<a href="/accounts"><br><br>
	<button type="button" class="button">VER MINHAS EMPRESAS</button> </a>
@endsection

@section('main')
<form action=" {{ route('accounts.store') }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	<label for="" >Nome: </label>
	<input type="text" name="name">
	<br>
	<br>
	<label for="" >Email: </label>
	<input type="text" name="email">
	<br>
	<br>
	<label for="">Telefone: </label>
	<input type="text" name="phone">   
	<br>
	<br>
	<label for="">Site: </label>
	<input type="text" name="site">   
	<br>
	<br>
	<label for="">Endereço: </label>
	<input type="text" name="address">   
	<br>
	<br>
	<label for="">Cidade: </label>
	<input type="text" name="address_city">   
	<br>
	<br>
	<label for="">Estado: </label>
	<input type="text" name="address_state">   
	<br>
	<br>
	<label for="">País: </label>
	<input type="text" name="address_country">   
	<br>
	<br>
	<label for="">Tipo: </label>
	<input type="text" name="type">   
	<br>
	<br>
	<label for="">Qtde empregados: </label>
	<input type="text" name="employees">   
	<br>
	<br>
	<input type="submit" value="Solicitar empresa">
</form>
@endsection