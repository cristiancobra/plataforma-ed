@extends('layouts/master')

@section('title','CONTAS BANCÁRIAS')

@section('image-top')
{{ asset('imagens/bankAccount.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('bankAccount.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">
		<b> Nome: </b> {{$bankAccount->name}}
	</h1>
	<label class="labels" for="" >
		Dono:
	</label>
	{{$bankAccount->account->name}}
	<br>
	<br>
	<label class="labels"  for="" >Banco: </label> {{$bankAccount->bank_code}} - {{$bankName}}
	<br>
	<label class="labels"  for="" >Tipo de conta: </label> {{$bankAccount->type}}
	<br>
	<label class="labels"  for="" >Número da agencia: </label> {{$bankAccount->agency}}
	<br>
	<label class="labels"  for="" >Número da conta: </label> {{$bankAccount->account_number}}
	<br>
	<label class="labels"  for="" >Saldo inicial: </label> R$ {{$bankAccount->opening_balance}}
	<br>
	<br>
		<p class="labels">
		DESCRIÇÃO:<span class="fields"> {!!html_entity_decode($bankAccount->observations)!!} </span>
	</p>
	<br>
	<label for="">Stituação: </label> {{$bankAccount->status}}
	<br>
	<br>
	<p class="labels"> <b>Criado em:</b> {{ date('d/m/Y H:i', strtotime($bankAccount->created_at)) }} </p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;display: inline-block" action="{{route('bankAccount.destroy', ['bankAccount' => $bankAccount])}}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href="{{route('bankAccount.edit', ['bankAccount' => $bankAccount])}}"  style="text-decoration: none;color: white;display: inline-block">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('bankAccount.index')}}">VOLTAR</a>
	</div>
	<br>
</div>
@endsection