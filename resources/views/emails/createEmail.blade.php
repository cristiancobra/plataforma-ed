@extends('layouts/master')

@section('title','SOLICITAR NOVO EMAIL')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')

Solicite seu email
<a href="/emails/"><br><br>
	<button type="button" class="button-header">VER EMAILS</button> </a>

@endsection

@section('main')
<br>
<br>
<div style="padding-left: 6%">
	<form action=" {{ route('emails.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >EMAIL: </label>
		<input class="fields" type="text" name="email" value="{{ $email->email }} ">
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="user_id">
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="">SENHA PADRÃO: </label>
		<input class="fields"  type="text" name="email_password" value="{{ $email->email_password }} ">   
		<br>
		<label class="labels" for="">ESPAÇO (GB): </label>
		<input class="fields" type="number" name="storage" value="{{ $email->storage }}">   
		<br>
		<br>
		<input class="button-header" type="submit" value="SOLICITAR EMAIL">
		@if ($user->perfil == "administrador")
		<a href="https://acadia.mxroute.com:2096/"><br><br>
			<button type="button" class="button-header">SERVIDOR DE EMAIL</button> </a><br>
		<center>login: solucoes</center>
		@endif
	</form>
</div>     
@endsection