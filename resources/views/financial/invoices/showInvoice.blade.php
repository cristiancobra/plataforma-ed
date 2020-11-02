@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('invoice.index')}}">VER FATURAS</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $invoice->name }}
</h1>
<label class="labels" for="" >DONO:</label>
<span class="fields">{{$invoice->account->name}}</span>
<br>
<label class="labels" for="" >OPORTUNIDADE:</label>
<span class="fields">{{$invoice->opportunitie->name}}</span>
<br>
<label class="labels" for="" >VENDEDOR:</label>
<span class="fields">{{$invoice->user->name}}</span>
<br>
<br>
<label class="labels" for="" >CONTRATANTE:</label>
<span class="fields">{{ $invoice->contact->name}}</span>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO::</label>
<span class="fields">{{ date('d/m/Y', strtotime($invoice->date_creation)) }}</span>
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
<span class="fields">{{ date('d/m/Y', strtotime($invoice->pay_day)) }}</span>
<br>
<br>
<label class="labels" for="" >PRODUTOS:</label>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome </b></td>
		<td   class="table-list-header"><b>Quantidade </b></td>
		<td   class="table-list-header"><b>Imposto</b></td>
		<td   class="table-list-header"><b>Preço</b></td>
	</tr>

	@while ($invoice->$name != null)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			{{ $invoice->$name }}
		</td>

		<td class="table-list-center">
			{{ $invoice->$amount }}
		</td>

		<td class="table-list-right">
			{{ number_format($invoice->$tax_rate, 2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($invoice->$price,2,",",".") }}
		</td>

		@php
		$name++;
		$amount++;
		$hours++;
		$cost++;
		$tax_rate++;
		$price++;
		@endphp
		@endwhile
	</tr>
	<tr>
		<td   class="table-list-header">
			<b></b>
		</td>
		<td   class="table-list-header">
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($invoice->totalTax_rate, 2,",",".") }}</b>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($invoice->totalPrice, 2,",",".") }}</b>
		</td>
	</tr>
</table>
<br>
<p style="text-align: right">
	<label class="labels" for="">SALDO:</label>
	<span class="fields">R$ {{number_format($invoice->totalBalance, 2,",",".") }}</span>
</p>
<label class="labels" for="">OBSERVAÇÕES:</label>
<span class="fields">{!!html_entity_decode($invoice->description)!!}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$invoice->status }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($invoice->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('invoice.destroy', ['invoice' => $invoice->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('invoice.edit', ['invoice' => $invoice->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('invoice.index')}}">VOLTAR</a>
</div>
<br>

@endsection