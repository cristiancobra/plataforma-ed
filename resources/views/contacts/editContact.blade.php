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
		<label class="labels" for="" >EMAIL: </label>
		<input class="fields" type="text" name="email" value="{{ $contact->contact }} ">
		<br>
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
		<label class="labels" for="">SENHA PADRÃO: </label>
		<input class="fields"  type="text" name="contact_password" value="{{ $contact->contact_password }}">
		<br>
		<label class="labels" for="">ESPAÇO (GB): </label>
		<input class="fields" type="number" name="storage" value="{{ $contact->storage }}">   
		<br>
		<label class="labels" for="status">SITUAÇÃO: </label>
		<select class="fields" name="status">
			<option value="{{ $contact->status }}">{{ $contact->status}}</option>
			@if ($contact->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($contact->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($contact->status == "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR EMAIL">

		@auth
		<a class="btn btn-secondary" style="display:inline-block" href=" https://acadia.mxroute.com:2083/" target="_blank">
			<i class='fa fa-edit'></i>ALTERAR NO SERVIDOR
		</a>
		@endauth
	</form>
</div>
<br>
<br>
@endsection