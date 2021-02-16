@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('imagens/transaction.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('transaction.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>
<div>
	<p class="labels">
		DONO:<span class="fields">{{$transaction->account->name}}</span>
	</p>
	<p class="labels">
		RESPONSÁVEL:<span class="fields">{{$transaction->user->contact->name}}</span>
	</p>
	<br>
	<p class="labels">
		DATA:<span class="fields">  {{date('d/m/Y', strtotime($transaction->pay_day))}} </span>
	</p>
	<p class="labels">
		CONTA:<span class="fields">{{$transaction->bankAccount->name}}</span>
	</p>
	<p class="labels">
		FATURA:<span class="fields">{{$transaction->invoice_id}}</span>
	</p>
	<p class="labels">
		VALOR:<span class="fields">{{formatCurrencyReal($transaction->value)}}</span>
	</p>
	<br>
	<p class="labels">
		SITUAÇAO:<span class="fields">  {{$transaction->status}} </span>
	</p>
	<br>
	<p class="fields">Criado em:  {{date('d/m/Y H:i', strtotime($transaction->created_at))}}
	</p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{route('transaction.destroy', ['transaction' => $transaction->id])}}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('transaction.edit', ['transaction' => $transaction->id]) }}">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('transaction.index')}}">VOLTAR</a>
	</div>
</div>
@endsection