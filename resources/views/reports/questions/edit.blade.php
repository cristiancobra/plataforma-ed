@extends('layouts/master')

@section('title','EMAIL')

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
	<form action=" {{ route('email.update', ['email' =>$email->id]) }} " method="post" style="color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >EMPRESA:</label>
		<select name="account_id">
			<option  class="fields" value="{{$email->account_id}}">
				{{$email->account->name}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >QUEM ESCREVEU: </label>
		<select name="user_id">
			<option  class="fields" value="{{$email->user_id}}">
				{{$email->user->contact->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->id}}">
				{{$user->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >TÍTULO:</label>
		<input type='text' class='fields' name='title' size='50' value='{{$email->title}}'>
		<br>
		<label class="labels" for="" >MENSAGEM:</label>
		<br>
		@if ($errors->has('message'))
		<span class="text-danger">{{ $errors->first('message') }}</span>
		@endif
		<textarea id="description" name="message" rows="10" cols="90" >
{{$email->message}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('message');
		</script>
		<br>
		<br>
		<br>
		<br>
		<br>
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
		<div>
			<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">
			</form>
			<a class="btn btn-secondary" style="display:inline-block" href=" https://acadia.mxroute.com:2083/" target="_blank">
				<i class='fa fa-edit'></i>EDITAR
			</a>
		</div>
</div>
<br>
<br>
@endsection