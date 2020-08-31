@extends('layouts/master')

@section('title','EDITAR EMAIL')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('email.index')}}">VER EMAILS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('email.update', ['email' =>$email->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
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
		<label class="labels" for="">SENHA PADRÃO: </label>
		<input class="fields"  type="text" name="email_password" value="{{ $email->email_password }}">
		<br>
		<label class="labels" for="">ESPAÇO (GB): </label>
		<input class="fields" type="number" name="storage" value="{{ $email->storage }}">   
		<br>
		<label class="labels" for="status">SITUAÇÃO: </label>
		<select class="fields" name="status">
			<option value="{{ $email->status }}">{{ $email->status}}</option>
			@if ($email->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($email->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($email->status == "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR EMAIL">
	</form>
	<a class="btn btn-secondary" href=" https://acadia.mxroute.com:2083/" target="_blank">
		<i class='fa fa-edit'></i>EDITAR
	</a>
</div>
<br>
<br>
@endsection