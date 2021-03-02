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
<label class="labels" for="" >VENDEDOR:</label>
<span class="fields">{{$invoice->user->contact->name}}</span>
<br>
<br>
<label class="labels" for="" >OPORTUNIDADE:</label>
@if(isset($invoice->opportunity_id))
<span class="fields">{{$invoice->opportunity->name}}</span>
<button class="button-round">
	<a href=" {{route('opportunity.show', ['opportunity' => $invoice->opportunity])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
@else
não possui
@endif
<br>
<label class="labels" for="" >CONTRATO:</label>
@if(!isset($invoice->contract_id) OR $invoice->contract_id == 0)
Sem contrato
@else
<span class="fields">{{$invoice->contract->name}}</span>
<button class="button-round">
	<a href="{{route('contract.show', ['contract' => $invoice->contract_id])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
@endif
<br>
@if(isset($invoice->opportunity_id))
<label class="labels" for="" >EMPRESA CONTRATANTE:</label>
<span class="fields">{{$invoice->opportunity->company->name}}</span>
<button class="button-round">
	<a href="{{route('company.show', ['company' => $invoice->opportunity->company_id])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
@elseif($invoice->company->name)
<label class="labels" for="" >FORNECEDOR:</label>
<span class="fields">{{$invoice->company->name}}</span>
<button class="button-round">
	<a href="{{route('company.show', ['company' => $invoice->company_id])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
@else
<label class="labels" for="" >CLIENTE / FORNECEDOR:</label>
<span class="fields">{{$invoice->company->name}}</span>
<button class="button-round">
	<a href="{{route('company.show', ['company' => $invoice->company_id])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
@endif
<br>
@if(isset($invoice->opportunity_id))
<label class="labels" for="" >CONTATO:</label>
<span class="fields">{{$invoice->opportunity->contact->name}}</span>
<a href="{{route('contact.show', ['contact' => $invoice->opportunity->contact_id])}}">
	<i class='fa fa-eye' style="color:white"></i>
</a>
@endif
<br>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
<span class="fields">{{date('d/m/Y', strtotime($invoice->date_creation))}}</span>
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
<span class="fields">{{date('d/m/Y', strtotime($invoice->pay_day))}}</span>
<br>
<br>
@if(isset($invoice->opportunity_id))
<label class="labels" for="">DESCRIÇÃO DA OPORTUNIDADE:</label>
<span class="fields">{!!html_entity_decode($invoice->opportunity->description)!!}</span>
<br>
@endif
<div style="display: inline-block">
	<img src="{{asset('imagens/products.png')}}" width="40px" alt="40px">
	<label class="labels" for="" >ITENS DA FATURA:</label>
</div>
<br>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 5%">
			QTDE
		</td>
		<td   class="table-list-header" style="width: 55%">
			NOME
		</td>
		<td   class="table-list-header" style="width: 10%">
			PRAZO
		</td>
		<td   class="table-list-header" style="width: 10%">
			IMPOSTO 
		</td>
		<td   class="table-list-header" style="width: 10%">
			UNITÁRIO
		</td>
		<td   class="table-list-header" style="width: 10%">
			TOTAL
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
		<td   class="table-list-header-right">
			desconto: 
		</td>
		<td   class="table-list-header-right" colspan="2">
			- {{number_format($invoice->discount, 2,",",".")}}
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="3">
		</td>
		<td   class="table-list-header-right">
			TOTAL: 
		</td>
		</td>
		<td   class="table-list-header-right" colspan="2">
			R$ {{number_format($invoice->totalPrice, 2,",",".")}}
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="3">
		</td>
		<td   class="table-list-header-right">
			PARCELAMENTO: 
		</td>

		<td   class="table-list-header-right" colspan="2">
			@if($invoice->number_installment_total == 1)
			À vista
			@else
			{{$invoice->number_installment_total}} x {{formatCurrencyReal($invoice->installment_value)}}
			@endif
		</td>
	</tr>
</table>
<br>
@if($totalInvoices > 1)

@elseif($invoice->status == 'aprovada' OR $invoice->status == 'paga' OR $invoice->number_installment_total == 1)
<p  style="text-align: right">
	<a class="button-secondary" href="{{route('invoice.installment', ['invoice' => $invoice])}}">
		GERAR FATURAS DO PARCELAMENTO
	</a>
</p>
@else
<p  style="text-align: right">
	<a class="button-secondary" href="{{route('invoice.edit', ['invoice' => $invoice])}}">
		APROVAR PARA LIBERAR PARCELAMENTO
	</a>
</p>
@endif
<br>
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
<br>
<br>
<br>
@endif
<div style="display: inline-block">
	<img src="{{asset('imagens/invoice.png')}}" width="40px" alt="40px">
	<label class="labels" for="" >TODAS AS FATURAS:</label>
</div>
<br>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 30%">
			IDENTIFICADOR
		</td>
		<td   class="table-list-header" style="width: 20%">
			DATA CRIAÇÃO 
		</td>
		<td   class="table-list-header" style="width: 20%">
			DATA PAGAMENTO
		</td>
		<td   class="table-list-header" style="width: 10%">
			VALOR TOTAL
		</td>
		<td   class="table-list-header" style="width: 10%">
			VALOR DA PARCELA
		</td>
		<td   class="table-list-header" style="width: 10%">
			SITUAÇÃO
		</td>
	</tr>
	@if($invoices)
	@foreach ($invoices as $invoice)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<button class="button-round">
				<a href=" {{route('invoice.show', ['invoice' => $invoice->id])}}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{route('invoice.edit', ['invoice' => $invoice->id])}}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			FATURA {{$invoice->identifier}}: parcela {{$invoice->number_installment}} de {{$invoice->number_installment_total}}
		</td>
		<td class="table-list-center">
			{{date('d/m/Y', strtotime($invoice->date_creation))}}
		</td>
		<td class="table-list-center">
			{{date('d/m/Y', strtotime($invoice->pay_day))}}
		</td>
		<td class="table-list-right">
			R$ {{number_format($invoice->totalPrice, 2,",",".")}}
		</td>
		<td class="table-list-right">
			R$ {{number_format($invoice->installment_value, 2,",",".")}}
		</td>
		@if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
		<td class="td-late">
			atrasada
		</td>
		@else
		{{formatInvoiceStatus($invoice)}}
		@endif
	</tr>
	@endforeach
	@endif
</table>
<br>
<br>
<label class="labels" for="">OBSERVAÇÕES:</label>
<span class="fields">{!!html_entity_decode($invoice->description)!!}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$invoice->status}}</span>
<br>
<br>
<br>
<div style="display: inline-block">
	<img src="{{asset('imagens/financeiro.png')}}" width="40px" alt="40px">
	<label class="labels" for="" >PAGAMENTOS:</label>
</div>
<br>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 5%">
			DATA
		</td>
		<td   class="table-list-header" style="width: 55%">
			RESPONSÁVEL
		</td>
		<td   class="table-list-header" style="width: 10%">
			CONTA
		</td>
		<td   class="table-list-header" style="width: 10%">
			VALOR
		</td>
	</tr>
	@foreach($transactions as $transaction)
	<tr>
		<td class="table-list-center">
			{{date('d/m/Y', strtotime($transaction->pay_day))}}
		</td>
		<td class="table-list-center">
			{{$transaction->user->contact->name}}
		</td>
		<td class="table-list-center">
			{{$transaction->bankAccount->name}}
		</td>
		<td class="table-list-right">
			R$ {{number_format($transaction->value,2,",",".")}}
		</td>
	</tr>
	@endforeach
	<tr>
		<td   class="table-list-header-right" colspan="1">
		</td>
		<td   class="table-list-header-right"colspan="2">
			SALDO DA FATURA:
		</td>
		</td>
		<td   class="table-list-header-right" colspan="2">
			R$ {{number_format($balance, 2,",",".")}}
		</td>
	</tr>
</table>
<br>
	<a class="button-secondary" href="{{route('transaction.create', [
		'invoiceId' => $invoice->identifier,
		'invoiceType' => $invoice->type,
		'invoiceTotalPrice' => $invoice->totalPrice,
				
	])}}">
		REGISTRAR PAGAMENTO
	</a>
<br>
<br>
<p class="labels">  Criado em:   {{date('d/m/Y H:i', strtotime($invoice->created_at))}} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{route('invoice.destroy', ['invoice' => $invoice])}}" method="post">
		@csrf
		@method('delete')
		<input class="button-delete" type="submit" value="APAGAR">
	</form>
	<a class="button-secondary" href="{{route('invoice.edit', ['invoice' => $invoice->id])}}"  style="display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="button-secondary" href="{{route('invoice.index')}}">VOLTAR</a>
</div>
<br>

@endsection