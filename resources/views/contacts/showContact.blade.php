@extends('layouts/master')

@section('title','CONTATOS')

@section('image-top')
{{ asset('imagens/contact.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('contact.index')}}">VER CONTATOS</a>
@endsection

@section('main')
<br>
<h1 class="name">
	<b> Nome: </b> {{ $contact->name }}
</h1>
<label for="" >Primeiro nome: </label> {{ $contact->first_name }}
	<br>
	<label for="" >Sobrenome: </label> {{ $contact->last_name }}
	<br>
	<label for="" >Email: </label> {{ $contact->email }}
	<br>
	<label for="">Telefone: </label> {{ $contact->phone }}
	<br>
	<label for="">Site: </label> {{ $contact->site }}
	<br>
	<br>
	<label for="">Endereço: </label> {{ $contact->address }}
	<br>
	<label for="">Cidade: </label> {{ $contact->address_city }}
	<br>
	<label for="">Estado: </label> {{ $contact->address_state }}
	<br>
	<label for="">País: </label> {{ $contact->address_country }}
	<br>
	<br>
	<label for="">Tipo: </label> {{ $contact->type }}
	<br>
	<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($contact->created_at)) }} </p>

@endsection