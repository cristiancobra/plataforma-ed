@extends('layouts/master')

@section('title','EMPRESAS')

@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('company.index')}}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">
		<b> Nome: </b> {{$company->name}}
	</h1>
	<label class="labels"  for="" >CNPJ: </label> {{$company->cnpj}}
	<br>
	<label class="labels" for="" >
		Dono:
	</label>
	{{$company->account->name}}
	<br>
	<br>
	<br>
	<h2 class="name" for="">CONTATOS</h2>
	<label class="labels"  for="" >Email: </label> {{$company->email}}
	<br>
	<label class="labels"  for="" >Email financeiro: </label> {{$company->financial_email}}
	<br>
	<label class="labels"  for="">Telefone: </label> {{$company->phone}}
	<br>
	<label class="labels"  for="">Site: </label> {{ $company->site}}
	<br>
	<label class="labels"  for="">Instagram: </label> {{$company->instagram}}
	<br>
	<label class="labels"  for="">Facebook: </label> {{$company->facebook}}
	<br>
	<label class="labels"  for="">Linkedin: </label> {{$company->linkedin}}
	<br>
	<label class="labels"  for="">Twitter: </label> {{$company->twitter}}
	<br>
	<br>
	<br>
	<h2 class="name" for="">LOCALIZAÇÃO</h2>
	<label class="labels" for="">Endereço: </label> {{$company->address}}
	<br>
	<label class="labels" for="">Cidade: </label> {{$company->city}}
	<br>
	<label class="labels" for="">Bairro: </label> {{$company->neighborhood}}
	<br>
	<label class="labels"  for="">Estado: </label> {{returnStateName($company->state)}}
	<br>
	<label class="labels"  for="">País: </label> {{$company->country}}
	<br>
	<br>
	<br>
	<h2 class="name" for="">PERFIL</h2>
	<label class="labels" for="">Quantidade de empregados: </label> {{$company->employees}}
	<br>
	<label class="labels" for="">Tipo: </label> {{ $company->type }}
	<br>
	<label class="labels" for="">Stituação: </label> {{$company->status}}
	<br>
	<br>
	<br>
	<h2 class="name" for="">FUNCIONÁRIOS</h2>
	@foreach ($company->contacts as $contact)
	<a  class="white" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank">
		<button class="button-round">
			<i class='fas fa-comment-dots'></i>
		</button>
	</a>

	<a  class="white" href=" {{ route('contact.show', ['contact' => $contact->id]) }}">
		<button class="button-round">
			<i class='fa fa-eye'></i>
		</button>
	</a>
	{{$contact->name}}
	@endforeach	
	<br>
	<br>
	<br>
	<p class="labels"> <b>Criado em:</b> {{ date('d/m/Y H:i', strtotime($company->created_at)) }} </p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;display: inline-block" action="{{ route('company.destroy', ['company' => $company->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('company.edit', ['company' => $company->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('company.index')}}"><i class="fas fa-arrow-left"></i></a>
	</div>
	<br>
</div>
@endsection