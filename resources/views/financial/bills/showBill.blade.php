@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/bill.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('bill.index')}}">VER FATURAS</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $bill->name }}
</h1>
<label class="labels" for="" >DONO:</label>
<span class="fields">{{$bill->account->name}}</span>
<br>
<label class="labels" for="" >OPORTUNIDADE:</label>
<span class="fields">{{$bill->opportunitie->name}}</span>
<br>
<br>
<label class="labels" for="" >CONTRATANTE:</label>
<span class="fields">{{ $bill->contact->name}}</span>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO::</label>
<span class="fields">{{ date('d/m/Y', strtotime($bill->date_creation)) }}</span>
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
<span class="fields">{{ date('d/m/Y', strtotime($bill->pay_day)) }}</span>
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

	@while ($bill->$name != null)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			{{ $bill->$name }}
		</td>

		<td class="table-list-center">
			{{ $bill->$amount }}
		</td>

		<td class="table-list-right">
			{{ number_format($bill->$tax_rate, 2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($bill->$price,2,",",".") }}
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
			<b>R$ {{number_format($bill->totalTax_rate, 2,",",".") }}</b>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($bill->totalPrice, 2,",",".") }}</b>
		</td>
	</tr>
</table>
<br>
<p style="text-align: right">
	<label class="labels" for="">SALDO:</label>
	<span class="fields">R$ {{number_format($bill->totalBalance, 2,",",".") }}</span>
</p>
<label class="labels" for="">OBSERVAÇÕES:</label>
<span class="fields">{!!html_entity_decode($bill->description)!!}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$bill->status }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($bill->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('bill.destroy', ['bill' => $bill->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('bill.edit', ['bill' => $bill->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('bill.index')}}">VOLTAR</a>
</div>
<br>

@endsection