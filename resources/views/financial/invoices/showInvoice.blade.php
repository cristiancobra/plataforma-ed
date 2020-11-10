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
			<button class="button">
				<a href=" {{ route('opportunitie.show', ['opportunitie' => $invoice->opportunitie->id]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('opportunitie.edit', ['opportunitie' => $invoice->opportunitie->id]) }}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
<br>
<label class="labels" for="" >VENDEDOR:</label>
<span class="fields">{{$invoice->user->name}}</span>
<br>
<br>
<label class="labels" for="" >CONTRATANTE:</label>
<span class="fields">{{ $invoice->opportunitie->contact->name}}</span>
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
		<td   class="table-list-header" style="width: 5%">
			<b>QTDE
			</b></td>
		<td   class="table-list-header" style="width: 65%">
			<b>NOME</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>IMPOSTO </b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>UNITÁRIO</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>TOTAL</b>
		</td>
	</tr>

	@foreach ($invoiceLines as $invoiceLine)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			{{ $invoiceLine->amount }}
		</td>

		<td class="table-list-left">
			{{ $invoiceLine->product->name}}
		</td>

		<td class="table-list-right">
			{{ number_format($invoiceLine->subtotalTax_rate, 2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($invoiceLine->product->price,2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($invoiceLine->subtotalPrice,2,",",".") }}
		</td>
	</tr>

	<tr style="font-size: 12px">
		<td class="table-list-left" colspan="4">
		{{ $invoiceLine->product->name}}
		</td>
	</tr>
	@endforeach

	<tr>
		<td   class="table-list-header-right" colspan="4">
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