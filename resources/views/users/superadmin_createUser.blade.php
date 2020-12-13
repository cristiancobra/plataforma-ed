@extends('layouts/master')

@section('title','NOVO COLABORADOR')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('user.index')}}">
	VOLTAR
</a>
<a class="button-primary"  href="{{route('user.create')}}">
	CRIAR
</a>
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
	{{ Session::get('failed') }}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{ route('user.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels"'for="" >Empresa: </label>
		<select name="accounts[]">
			@foreach($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels"'for="" >Contato: </label>
		<select name="contact_id">
			@foreach($contacts as $contact)
			<option  class="fields" value="{{$contact->id}}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels"for="" >Email (login): </label>
		<input class="fields" type="text" name="email" value="{{old('email')}}">
		@if ($errors->has('email'))
		<span class="text-danger">{{ $errors->first('email') }}</span>
		@endif
		<br>
		<br>
		<label class="labels"'for="" >Perfil: </label>
		<select name="perfil">
			<option  class="fields" value="super administrador">
				super administrador
			</option>
			<option  class="fields" value="administrador">
				administrador
			</option>
			<option  class="fields" value="funcionario">
				funcionário
			</option>
		</select>
		<br>
		<label class="labels"for="">Senha do usuário: </label>
		<input class="fields" type="password" name="password" value="{{old('password')}}">
		@if ($errors->has('password'))
		<span class="text-danger">{{ $errors->first('password') }}</span>
		@endif
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="SOLICITAR USUÁRIO">
		<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
			<a class="btn btn-success" href="https://www.4devs.com.br/gerador_de_senha" target="_blank">
				<i class='fa fa-edit'>	
				</i>
				GERADOR DE SENHA
			</a>
		</div>
	</form>
</div>     
@endsection