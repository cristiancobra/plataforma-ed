@extends('layouts/master')

@section('title','EDITAR EMAIL')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Altere seu email
<a href="/emails/"><br><br>
	<button type="button" class="button-header">VER EMAILS</button> </a>

@endsection

@section('main')
<div style="padding-left: 6%">
<form action=" {{ route('emails.update', ['email' =>$email->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<label class="labels" for="" >EMAIL: </label>
	<input class="fields" type="text" name="email" value="{{ $email->email }} ">
	<br>
	<label class="labels" for="" >DONO: </label>
	<input class="fields" type="text" name="name" value="">
	<br>
	<label class="labels" for="">SENHA PADRÃO: </label>
	<input class="fields"  type="text" name="email_password" value="{{ $email->email_password }} ">   
	<br>
	<label class="labels" for="">ESPAÇO (GB): </label>
	<input class="fields" type="number" name="storage" value="{{ $email->storage }}">   
	<br>
	<label class="labels" for="status">SITUAÇÃO: </label>
	<select class="fields" name="status">
		<option value="{{ $email->status }}">{{ $email->status}}</option>
		@if ($email->status == "desativado")
		<option value="ativo">ativo</option>
		@else
		<option value="desativado">desativado</option>
		@endif
		
	
	
	</select>
	<br>
	<br>
	<input class="button-header" type="submit" value="ATUALIZAR EMAIL">
</form>
</div>     
@endsection
