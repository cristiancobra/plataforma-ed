@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{asset('imagens/bill.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('bill.index')}}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<label class="labels" for="" >IDENTIFICADOR:</label>
<span class="fields">{{$bill->identifier}}</span>
<br>
<label class="labels" for="" >PARCELA:</label>
@if($bill->status == 'rascunho')
<span class="fields">rascunho</span>
@elseif($bill->status == 'orçamento')
<span class="fields">orçamento</span>
@else
<span class="fields">{{$bill->number_installment}} de {{$bill->number_installment_total}}</span>
@endif
<br>
<label class="labels" for="" >DONO:</label>
<span class="fields">{{$bill->account->name}}</span>
<br>
<label class="labels" for="" >VENDEDOR:</label>
<span class="fields">{{$bill->user->contact->name}}</span>
<br>
<br>
<label class="labels" for="" >CONTRATO:</label>
@if(!isset($bill->contract_id) OR $bill->contract_id == 0)
Sem contrato
@else
<span class="fields">{{$bill->contract->name}}</span>
<button class="button-round">
	<a href="{{route('contract.show', ['contract' => $bill->contract_id])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
@endif
<br>
<label class="labels" for="" >EMPRESA CONTRATANTE:</label>
<span class="fields">{{$bill->company->name}}</span>
<button class="button-round">
	<a href="{{route('company.show', ['company' => $bill->company_id])}}">
		<i class='fa fa-eye' style="color:white"></i>
	</a>
</button>
<br>
<label class="labels" for="" >CONTATO:</label>
<span class="fields">{{$bill->contact->name}}</span>
<a href="{{route('contact.show', ['contact' => $bill->contact_id])}}">
	<i class='fa fa-eye' style="color:white"></i>
</a>
<br>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
<span class="fields">{{date('d/m/Y', strtotime($bill->date_creation))}}</span>
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
<span class="fields">{{date('d/m/Y', strtotime($bill->pay_day))}}</span>
<br>
<br>
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

	@foreach ($billLines as $billLine)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			{{$billLine->amount}}
		</td>
		<td class="table-list-left">
			{{$billLine->product->name}}
		</td>
		<td class="table-list-center">
			{{$billLine->subtotalDeadline}} dia(s)
		</td>
		<td class="table-list-right">
			{{number_format($billLine->subtotalTax_rate, 2,",",".")}}
		</td>
		<td class="table-list-right">
			{{number_format($billLine->product->price,2,",",".")}}
		</td>
		<td class="table-list-right">
			{{number_format($billLine->subtotalPrice,2,",",".")}}
		</td>
	</tr>

	<tr style="font-size: 12px">
		<td class="table-list-left" colspan="5">
			{!!html_entity_decode($billLine->product->description)!!}
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
			- {{number_format($bill->discount, 2,",",".")}}
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
			R$ {{number_format($bill->totalPrice, 2,",",".")}}
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="3">
		</td>
		<td   class="table-list-header-right">
			PARCELAMENTO: 
		</td>

		<td   class="table-list-header-right" colspan="2">
			@if($bill->number_installment_total == 1)
			À vista
			@else
			{{$bill->number_installment_total}} x {{formatCurrencyReal($bill->installment_value)}}
			@endif
		</td>
	</tr>
</table>
<br>
@if($totalInvoices > 1)

@elseif($bill->status == 'aprovada' OR $bill->status == 'paga')
<p  style="text-align: right">
	<a class="button-secondary" href="{{route('bill.installment', ['bill' => $bill])}}">
		GERAR FATURAS DO PARCELAMENTO
	</a>
</p>
@else
<p  style="text-align: right">
	<a class="button-secondary" href="{{route('bill.edit', ['bill' => $bill])}}">
		APROVAR PARA LIBERAR PARCELAMENTO
	</a>
</p>
@endif
<br>
@if($bill->status == 'rascunho' OR $bill->status == 'rascunho')
<br>
<label class="labels" for="" >OPÇÕES DE PARCELAMENTO: </label>
<br>
@php
$counter = 1;
while($counter <= $bill->number_installment_total) {
echo "$counter x = R$ ".number_format($bill->totalPrice / $counter, 2,",",".");
echo "<br>";
$counter++;
}
@endphp
<br>
<br>
<br>
@endif
<div style="display: inline-block">
	<img src="{{asset('imagens/bill.png')}}" width="40px" alt="40px">
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
	@if($bills)
	@foreach ($bills as $bill)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<button class="button-round">
				<a href=" {{route('bill.show', ['bill' => $bill->id])}}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{route('bill.edit', ['bill' => $bill->id])}}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			FATURA {{$bill->identifier}}: parcela {{$bill->number_installment}} de {{$bill->number_installment_total}}
		</td>
		<td class="table-list-center">
			{{date('d/m/Y', strtotime($bill->date_creation))}}
		</td>
		<td class="table-list-center">
			{{date('d/m/Y', strtotime($bill->pay_day))}}
		</td>
		<td class="table-list-right">
			R$ {{number_format($bill->totalPrice, 2,",",".")}}
		</td>
		<td class="table-list-right">
			R$ {{number_format($bill->installment_value, 2,",",".")}}
		</td>
		@if($bill->status == 'aprovada' AND $bill->pay_day < date('Y-m-d'))
		<td class="td-late">
			atrasada
		</td>
		@else
		{{formatInvoiceStatus($bill)}}
		@endif
	</tr>
	@endforeach
	@endif
</table>
<br>
<br>
<label class="labels" for="" >MEIO DE PAGAMENTO: </label>
<span class="fields">{{$bill->payment_method}}</span>
<br>
<br>
<label class="labels" for="">OBSERVAÇÕES:</label>
<span class="fields">{!!html_entity_decode($bill->description)!!}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$bill->status}}</span>
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
<br>
<p class="labels">  Criado em:   {{date('d/m/Y H:i', strtotime($bill->created_at))}} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{route('bill.destroy', ['bill' => $bill])}}" method="post">
		@csrf
		@method('delete')
		<input class="button-delete" type="submit" value="APAGAR">
	</form>
	<a class="button-secondary" href="{{route('bill.edit', ['bill' => $bill->id])}}"  style="display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="button-secondary" href="{{route('bill.index')}}"><i class="fas fa-arrow-left"></i></a>
</div>
<br>

@endsection