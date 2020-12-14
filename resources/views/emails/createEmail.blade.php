@extends('layouts/master')

@section('title','NOVO EMAIL')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('email.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('email.store') }} " method="post" style="color: #874983">
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
		<input class="btn btn-secondary" type="submit" value="SOLICITAR EMAIL">
	</form>
</div>     
@endsection