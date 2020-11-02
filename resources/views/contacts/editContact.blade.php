@extends('layouts/master')

@section('title','EDITAR CONTATO')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('contact.index')}}">VER CONTATOS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('contact.update', ['contact' =>$contact->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $contact->account->id }}">
				{{ $contact->account->name }}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >Primeiro nome: </label>
		<input type="text" name="first_name" value="{{ $contact->first_name }}">
		<br>
	<label class="labels" for="" >Sobrenome: </label>
	<input type="text" name="last_name" value="{{ $contact->last_name }}">
	<br>
	<label class="labels" for="" >Email: </label>
	<input type="text" name="email" value="{{ $contact->email }}">
	<br>
	<label class="labels" for="">Telefone: </label> 
	<input type="text" name="phone" value="{{ $contact->phone }}">
	<br>
	<label class="labels" for="">Site: </label>
	<input type="text" name="site" value="{{ $contact->site }}">
	<br>
	<br>
	<label class="labels" for="">Endereço: </label>
	<input type="text" name="address" value="{{ $contact->address }}">   
	<br>
	<label class="labels" for="address_city">Cidade: </label>
	<input type="text" name="address_city" value="{{ $contact->address_city }}">
	<br>
	<label class="labels" for="">Estado: </label>
	<input type="text" name="address_state"  value="{{ $contact->address_state }}">
	<br>
	<label class="labels" for="">País: </label>
	<input type="text" name="address_country" value="{{ $contact->address_country }}">
	<br>
	<br>
	<label class="labels" for="">Tipo: </label>
	<input type="text" name="type" value="{{ $contact->type }}">
	<br>
	<br>
		<label class="labels" for="status">SITUAÇÃO: </label>
		<select class="fields" name="status">
			<option value="{{ $contact->status }}">{{ $contact->status}}</option>
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			<option value="desativado">desativado</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection