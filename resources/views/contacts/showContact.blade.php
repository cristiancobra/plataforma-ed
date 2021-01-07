@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contact.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">
		<b> Nome: </b> {{ $contact->name }}
	</h1>
	<label class="labels" for="" >
		Dono:
	</label>
	{{$contact->first_name}}
	<br>
	<label class="labels"  for="" >
		Origem do contato:
	</label>
	{{$contact->lead_source}}
	<br>
	<br>
	<h2 class="name" for="">PESSOAL</h2>
	<label class="labels"  for="" >Primeiro nome: </label> {{$contact->first_name}}
	<br>
	<label class="labels"  for="" >Sobrenome: </label> {{$contact->last_name}}
	<br>
	<label class="labels"  for="" >Data de nascimento: </label> {{$contact->birth_date}}
	<br>
	<label class="labels"  for="" >CPF: </label> {{$contact->cpf}}
	<br>
	<label class="labels"  for="" >CEP: </label> {{$contact->cep}}
	<br>
	<br>
	<h2 class="name" for="">
		OPORTUNIDADES:
	</h2>
	@foreach ($contact->opportunities as $opportunity)
	<a  class="white" href=" {{route('opportunity.show', ['opportunity' => $opportunity->id])}}">
		<button class="button-round">
			<i class='fa fa-eye'></i>
		</button>
	</a>
	{{ $opportunity->name }}
	<br>
	@endforeach	
	<br>
	<br>
	<h2 class="name" for="">PROFISSIONAL</h2>
	<label class="labels"  for="" >Profissão: </label> {{ $contact->profession }}
	<br>
	<label class="labels"  for="" >Empresa: </label> {{ $contact->company }}
	<br>
	<label class="labels"  for="" >Cargo: </label> {{ $contact->job_position }}
	<br>
	<label class="labels"  for="" >Escolaridade: </label> {{ $contact->schollarity }}
	<br>
	<br>
	<br>
	<h2 class="name" for="">CONTATOS</h2>
	<label class="labels"  for="" >Email: </label> {{ $contact->email}}
	<br>
	<label class="labels"  for="">Telefone: </label> {{ $contact->phone}}
	<br>
	<label class="labels"  for="">Site: </label> {{ $contact->site}}
	<br>
	<label class="labels"  for="">Instagram: </label> {{ $contact->instagram}}
	<br>
	<label class="labels"  for="">Facebook: </label> {{ $contact->facebook}}
	<br>
	<label class="labels"  for="">Linkedin: </label> {{ $contact->linkedin}}
	<br>
	<label class="labels"  for="">Twitter: </label> {{ $contact->twitter}}
	<br>
	<br>
	<br>
	<h2 class="name" for="">LOCALIZAÇÃO</h2>
	<label class="labels" for="">Endereço: </label> {{ $contact->address}}
	<br>
	<label class="labels" for="">Cidade: </label> {{ $contact->city}}
	<br>
	<label class="labels" for="">Bairro: </label> {{ $contact->neighborhood}}
	<br>
	<label class="labels"  for="">Estado: </label> {{ $contact->state}}
	<br>
	<label class="labels"  for="">País: </label> {{ $contact->country}}
	<br>
	<br>
	<br>
	<h2 class="name" for="">PERFIL</h2>
	<label class="labels"  for="">Estado civil:  </label>
	{{ $contact->civil_state}}
	<br>
	<label class="labels"  for="">Naturalidade:  </label>
	{{ $contact->naturality}}
	<br>
	<label class="labels"  for="">Filhos:  </label>
	{{ $contact->kids}}
	<br>
	<label class="labels"  for="">Hobbie:  </label>
	{{ $contact->hobbie}}
	<br>
	<label class="labels"  for="">Renda:  </label>
	{{ $contact->income}}
	<br>
	<label class="labels"  for="">Religião:  </label>
	{{ $contact->religion}}
	<br>
	<label class="labels"  for="">Etinia:  </label>
	{{ $contact->etinicity}}
	<br>
	<label class="labels"  for="">Orientação Sexual::  </label>
	{{ $contact->sexual_orientation}}
	<br>
	<br>
	<label for="">Tipo: </label> {{ $contact->type }}
	<br>
	<label for="">Stituação: </label> {{ $contact->status }}
	<br>
	<br>
	<p class="labels"> <b>Criado em:</b> {{ date('d/m/Y H:i', strtotime($contact->created_at)) }} </p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;display: inline-block" action="{{ route('contact.destroy', ['contact' => $contact->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('contact.edit', ['contact' => $contact->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('contact.index')}}">VOLTAR</a>
	</div>
	<br>
</div>
@endsection