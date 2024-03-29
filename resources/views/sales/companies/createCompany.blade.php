@extends('layouts/master')

@if($typeCompanies == 'cliente')
@section('title','EMPRESAS')
@elseif($typeCompanies == 'fornecedor')
@section('title','FORNECEDORES')
@elseif($typeCompanies == 'cliente e fornecedor')
@section('title','CLIENTE FORNECEDOR')
@elseif($typeCompanies == 'concorrente')
@section('title','CONCORRENTES')
@endif


@section('image-top')
{{ asset('images/empresa.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')

{{createButtonList('company', 'typeCompanies', $typeCompanies)}}
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
		@elseif($typeCompanies == 'fornecedor')
		<input type="hidden" name="type" value="fornecedor">
		@elseif($typeCompanies == 'concorrente')
		<input type="hidden" name="type" value="concorrente">
		@endif
		<label for="" >NOME: </label>
		<input type="text" name="name" value="{{old('name')}}">
		@if ($errors->has('name'))
		<span class="text-danger">{{ $errors->first('name') }}</span>
		@endif
		<br>
		<label for="" >CNPJ: </label>
		<input type="text" name="cnpj">
		<br>
		<br>
		<h2 class="name" for="">CONTATO</h2>
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
		<h2 class="name" for="">LOCALIZAÇÃO</h2>
		<label for="">Endereço: </label>
		<input type="text" name="address">   
		<br>
		<label for="" >CEP: </label>
		<input type="text" name="zip_code" value="">
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
		<label for="">Quantidade de funcionários: </label>
		<input type="number" name="employees">
		<br>
		<label for="">Quantidade de clientes: </label>
		<input type="number" name="client_number">
		<br>
		<label for="">Faturamento: </label>
		<input type="number" name="revenues">
		<br>
		<label for="">Diferencial Competitivo: </label>
		<input type="text" name="competitive_advantage">
		<br>
		<label for="">Setor: </label>
		<input type="string" name="sector">
		<br>
		<label for="">Modelo de negócios: </label>
		{{createDoubleSelect('business_model', 'fields', $businessModelTypes)}}
		<br>
		<br>
		<label  class="labels" for="">Proposta de valor: </label>
		<br>
		<textarea id="description" name="value_offer" rows="20" cols="90">
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('value_offer');
		</script>
		<br>
		<br>
		@if($typeCompanies != 'concorrente')
		<h2 class="name" for="">FUNCIONÁRIOS</h2>
		@foreach ($contacts as $contact)
		<p class="fields">
			<input type="checkbox" name="contacts[]" value="{{$contact->id}}">
			{{$contact->name}}
		</p>
		@endforeach
		<br>
		<br>
		@endif
		<label for="status">SITUAÇÃO: </label>
		<select class="fields" name="status">
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			<option value="desativado">desativado</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>
<br>
<br>
@endsection
