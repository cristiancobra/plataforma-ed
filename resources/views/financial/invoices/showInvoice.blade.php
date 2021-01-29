@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{asset('imagens/invoice.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary" href="{{route('invoice.pdf', ['invoice' => $invoice])}}">
	PDF
</a>
<a class="button-secondary" href="{{route('invoice.email', ['invoice' => $invoice])}}">
	EMAIL
</a>
<a class="button-secondary"  href="{{route('invoice.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<label class="labels" for="" >IDENTIFICADOR:</label>
<span class="fields">{{$invoice->identifier}}</span>
<br>
<label class="labels" for="" >PARCELA:</label>
@if($invoice->status == 'rascunho')
<span class="fields">rascunho</span>
@elseif($invoice->status == 'orçamento')
<span class="fields">orçamento</span>
@else
<span class="fields">{{$invoice->number_installment}} de {{$invoice->number_installment_total}}</span>
@endif
<br>
<label class="labels" for="" >DONO:</label>
<span class="fields">{{$invoice->account->name}}</span>
<br>
<label class="labels" for="" >OPORTUNIDADE:</label>
<span class="fields">{{$invoice->opportunity->name}}</span>
<button class="button-round">
	<a href=" {{route('opportunity.show', ['opportunity' => $invoice->opportunity])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
<button class="button-round">
	<a href=" {{route('opportunity.edit', ['opportunity' => $invoice->opportunity])}}">
		<i class='fa fa-edit' style="color:white"></i>
	</a>
</button>
<br>
<label class="labels" for="" >VENDEDOR:</label>
<span class="fields">{{$invoice->user->contact->name}}</span>
<br>
<br>
<label class="labels" for="" >CONTRATANTE:</label>
<span class="fields">{{ $invoice->opportunity->contact->name}}</span>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
<span class="fields">{{ date('d/m/Y', strtotime($invoice->date_creation)) }}</span>
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
<span class="fields">{{ date('d/m/Y', strtotime($invoice->pay_day)) }}</span>
<br>
<br>
<label class="labels" for="">DESCRIÇÃO DA OPORTUNIDADE:</label>
<span class="fields">{!!html_entity_decode($invoice->opportunity->description)!!}</span>
<br>
<label class="labels" for="" >PRODUTOS:</label>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 5%">
			<b>QTDE
			</b></td>
		<td   class="table-list-header" style="width: 55%">
			<b>NOME</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>PRAZO</b>
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
			{{$invoiceLine->amount}}
		</td>
		<td class="table-list-left">
			{{$invoiceLine->product->name}}
		</td>
		<td class="table-list-center">
			{{$invoiceLine->subtotalDeadline}} dia(s)
		</td>
		<td class="table-list-right">
			{{number_format($invoiceLine->subtotalTax_rate, 2,",",".")}}
		</td>
		<td class="table-list-right">
			{{number_format($invoiceLine->product->price,2,",",".")}}
		</td>
		<td class="table-list-right">
			{{number_format($invoiceLine->subtotalPrice,2,",",".")}}
		</td>
	</tr>

	<tr style="font-size: 12px">
		<td class="table-list-left" colspan="5">
			{!!html_entity_decode($invoiceLine->product->description)!!}
		</td>
	</tr>
	@endforeach

	<tr>
		<td   class="table-list-header-right" colspan="3">
		</td>
		<td   class="table-list-header-right"
			  desconto: 
			  </td>
		<td   class="table-list-header-right" colspan="2">
			<b>- {{number_format($invoice->discount, 2,",",".")}}</b>
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="3">

		<td   class="table-list-header-right">
			TOTAL: 
		</td>
		</td>
		<td   class="table-list-header-right" colspan="2">
			<b>R$ {{number_format($invoice->totalPrice, 2,",",".")}}</b>
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="3">

		<td   class="table-list-header-right">
			PARCELAMENTO: 
		</td>
		</td>
		<td   class="table-list-header-right" colspan="2">
			@if($invoice->number_installment_total == 1)
			À vista
			@else
			{{$invoice->number_installment_total}} x R$ {{number_format($invoice->installment_value, 2,",",".")}}
			@endif
		</td>
	</tr>
</table>
@if($invoice->status == 'rascunho' OR $invoice->status == 'rascunho')
<br>
<label class="labels" for="" >OPÇÕES DE PARCELAMENTO: </label>
<br>
@php
$counter = 1;
while($counter <= $invoice->number_installment_total) {
echo "$counter x = R$ ".number_format($invoice->totalPrice / $counter, 2,",",".");
echo "<br>";
$counter++;
}
@endphp
@endif
<br>
<br>
<label class="labels" for="" >MEIO DE PAGAMENTO: </label>
<span class="fields">{{$invoice->payment_method}}</span>
<br>
<br>
<label class="labels" for="">OBSERVAÇÕES:</label>
<span class="fields">{!!html_entity_decode($invoice->description)!!}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$invoice->status}}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($invoice->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('invoice.destroy', ['invoice' => $invoice]) }}" method="post">
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