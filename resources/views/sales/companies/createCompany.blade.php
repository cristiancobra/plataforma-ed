@extends('layouts/master')

@if($typeCompanies == 'cliente')
@section('title','EMPRESAS')
@else($typeCompanies == 'fornecedor)
@section('title','FORNECEDORES')
@endif


@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('company.index', ['typeCompanies' => $typeCompanies])}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>

@if(Session::has('failed'))
<div class="alert alert-danger">
	{{ Session::get('failed') }}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{route('company.store')}} " method="post" style="color: #874983">
		@csrf
		@if($typeCompanies == 'cliente')
		<input type="hidden" name="type" value="cliente">
		@else
		<input type="hidden" name="type" value="fornecedor">
		@endif
		<label for="" >DONO: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<br>
		<label for="" >NOME: </label>
		<input type="text" name="name" value="{{old('name')}}">
		@if ($errors->has('name'))
		<span class="text-danger">{{ $errors->first('name') }}</span>
		@endif
		<br>
		<label for="" >CNPJ: </label>
		<input type="text" name="cnpj">
		<br>
		<label for="" >CEP: </label>
		<input type="text" name="zip_code" value="">
		<br>
		<br>
		<label for="" >Email: </label>
		<input type="text" name="email" value="{{old('email')}}">
		@if ($errors->has('email'))
		<span class="text-danger">{{$errors->first('email')}}</span>
		@endif
		<br>
		<label for="" >Email financeiro: </label>
		<input type="text" name="financial_email" value="{{old('financial_email')}}">
		@if ($errors->has('email'))
		<span class="text-danger">{{$errors->first('financial_email')}}</span>
		@endif
		<br>
		<label for="">Telefone: </label>
		<input type="text" name="phone">   
		<br>
		<label for="">Site: </label>
		<input type="text" name="site">   
		<br>
		<label for="">Instagram: </label>
		<input type="text" name="instagram">   
		<br>
		<label for="">Facebook: </label>
		<input type="text" name="facebook">   
		<br>
		<label for="">Linkedin: </label>
		<input type="text" name="linkedin">   
		<br>
		<label for="">Twitter: </label>
		<input type="text" name="twitter">   
		<br>
		<br>
		<br>

		<h2 class="name" for="">LOCALIZAÇÃO</h2>
		<label for="">Endereço: </label>
		<input type="text" name="address">   
		<br>
		<label for="city">Cidade: </label>
		<input type="text" name="city">   
		<br>
		<label for="">Bairro: </label>
		<input type="text" name="neighborhood">   
		<br>
		<label for="">Estado: </label>
		{{createDoubleSelect('state', 'fields', $states)}}
		<br>
		<label for="">País: </label>
		<input type="text" name="country" value="Brasil">   
		<br>
		<br>
		<br>
		<h2 class="name" for="">PERFIL</h2>
		<label for="">Quantidade de empregados: </label>
		<input type="number" name="employees">
		<br>
		<br>
		<br>
		<h2 class="name" for="">FUNCIONÁRIOS</h2>
		@foreach ($contacts as $contact)
		<p class="fields">
			<input type="checkbox" name="contacts[]" value="{{$contact->id}}">
			{{$contact->name}}
		</p>
		@endforeach
		<br>
		<br>
		<label for="status">SITUAÇÃO: </label>
		<select class="fields" name="status">
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			<option value="desativado">desativado</option>
		</select>
		<br>
		<br>
		{{submitFormButton('SALVAR')}}
	</form>
</div>
<br>
<br>
@endsection