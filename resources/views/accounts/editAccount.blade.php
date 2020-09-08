@extends('layouts/master')

@section('title','EDITAR EMPRESA')

@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('account.index')}}">VER EMPRESAS</a>
@endsection

@section('main')
<form action=" {{ route('account.update', ['account' =>$account->id]) }} " method="post" style="padding: 40px;color: white">
	@csrf
	@method('put')
	<label class="labels" for="">Nome: </label>
	<input type="text" name="name"  value="{{ $account->name }}">
	<br>
	<br>
	<label class="labels" for="">Email: </label>
	<input type="text" name="email" value="{{ $account->email }}">
	<br>
	<label class="labels" for="">Telefone: </label>
	<input type="text" name="phone" value="{{ $account->phone }}">   
	<br>
	<label class="labels" for="">Site: </label>
	<input type="text" name="site" value="{{ $account->site }}">   
	<br>
	<br>
	<label class="labels" for="">Endereço: </label>
	<input type="text" name="address"  value="{{ $account->address }}">   
	<br>
	<label class="labels" for="">Cidade: </label>
	<input type="text" name="address_city" value="{{ $account->address_city }}">   
	<br>
	<label class="labels" for="">Estado: </label>
	<input type="text" name="address_state" value="{{ $account->address_state }}">   
	<br>
	<label class="labels" for="">País: </label>
	<input type="text" name="address_country" value="{{ $account->address_country }}">   
	<br>
	<br>
	<label class="labels" for="">Tipo: </label>
	<input type="text" name="type" value="{{ $account->type }}">   
	<br>
	<label class="labels" for="">Qtde empregados: </label>
	<input type="text" name="employees" value="{{ $account->employees }}">
	<br>
	<br>
	<label class="labels" for="" >DESCRIÇÃO:</label>
	<textarea id="description" name="description" rows="20" cols="90">
		{{ $account->description }}
	</textarea>
	<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
	<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script>
CKEDITOR.replace('description');
	</script>
	<br>
	<label class="labels" for="status">SITUAÇÃO: </label>
	<select class="fields" name="status">
		<option value="{{ $account->status }}">{{ $account->status}}</option>
		@if ($account->status == "desativado")
		<option value="ativo">ativo</option>
		<option value="pendente">pendente</option>
		@elseif  ($account->status == "ativo")
		<option value="desativado">desativado</option>
		<option value="pendente">pendente</option>
		@elseif  ($account->status == "pendente")
		<option value="ativo">ativo</option>
		<option value="desativado">desativado</option>
		@endif
	</select>
	<br>
	<br>
	<label class="labels" for="" >Colaboradores: </label>
	<br>
	@foreach ($users as $user)
	<p class="fields">
		<input type="checkbox" name="users[]" value="{{ $user->id }}">	{{ $user->name }}
	</p>
	@endforeach
	<br>
	<br>
	<input class="btn btn-secondary" type="submit" value="ATUALIZAR">

</form>
@endsection