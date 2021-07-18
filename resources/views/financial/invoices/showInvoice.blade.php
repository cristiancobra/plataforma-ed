@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{asset('images/invoice.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button secondary' href='{{route('invoice.pdf', ['invoice' => $invoice])}}'>
    <i class='fas fa-print'></i>
</a>
<a class='circular-button secondary' href='{{route('invoice.email', ['invoice' => $invoice])}}'>
    <i class='fas fa-envelope'></i>
</a>
{{createButtonBack()}}
{{createButtonList('invoice', 'typeInvoices', $typeInvoices)}}
@endsection

@section('main')
<label class='labels' for='' >IDENTIFICADOR:</label>
<span class='fields'>{{$invoice->identifier}}</span>
<br>
<label class='labels' for='' >PARCELA:</label>
@if($invoice->status == 'rascunho')
<span class='fields'>rascunho</span>
@elseif($invoice->status == 'orçamento')
<span class='fields'>orçamento</span>
@else
<span class='fields'>{{$invoice->number_installment}} de {{$invoice->number_installment_total}}</span>
@endif
<br>
<label class='labels' for='' >VENDEDOR:</label>
<span class='fields'>{{$invoice->proposal->user->contact->name}}</span>
<br>
<br>
<label class='labels' for='' >OPORTUNIDADE:</label>
@if(isset($invoice->opportunity_id))
<span class='fields'>{{$invoice->opportunity->name}}</span>
<button class='button-round'>
    <a href=' {{route('opportunity.show', ['opportunity' => $invoice->opportunity])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@else
não possui
@endif
<br>
<label class='labels' for='' >CONTRATO:</label>
@if(!isset($invoice->contract_id) OR $invoice->contract_id == 0)
Sem contrato
@else
<span class='fields'>{{$invoice->contract->name}}</span>
<button class='button-round'>
    <a href='{{route('contract.show', ['contract' => $invoice->contract_id])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@endif
<br>
@if($invoice->status == 'receita')
<label class='labels' for='' >EMPRESA:</label>
@else
<label class='labels' for='' >FORNECEDOR:</label>
@endif
@if(isset($invoice->company->name))
<span class='fields'>{{$invoice->company->name}}</span>
<button class='button-round'>
    <a href='{{route('company.show', ['company' => $invoice->company_id])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@else
Não possui
@endif
<br>
<label class='labels' for='' >CONTATO:</label>
@if(isset($invoice->contact_id))
<span class='fields'>{{$invoice->contact->name}}</span>
<button class='button-round'>
    <a href='{{route('contact.show', ['contact' => $invoice->contact_id])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@else
Não possui
@endif
<br>
<br>
<label class='labels' for='' >DATA DE CRIAÇÃO:</label>
<span class='fields'>{{date('d/m/Y', strtotime($invoice->date_creation))}}</span>
<br>
<label class='labels' for='' >VALIDADE DA PROPOSTA:</label>
<span class='fields'>{{$invoice->expiration_date}}</span>
<br>
<label class='labels' for='' >DATA DE PAGAMENTO:</label>
<span class='fields'>{{date('d/m/Y', strtotime($invoice->pay_day))}}</span>
<br>
<br>
<br>
@if(isset($invoice->opportunity_id))
<label class='labels' for=''>DESCRIÇÃO DA OPORTUNIDADE:</label>
<span class='fields'>{!!html_entity_decode($invoice->opportunity->description)!!}</span>
<br>
<br>
<br>
@endif

<label class='labels' for=''>OBSERVAÇÕES:</label>
@if(isset($invoice->description))
<span class='fields'>{!!html_entity_decode($invoice->description)!!}</span>
@else
Não possui
@endif
<br>
<br>
<br>
<div style='display: inline-block'>
    <img src='{{asset('images/products.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >ITENS DA FATURA:</label>
</div>
<br>
<br>
<div class='row'>
    <div   class='tb tb-header col-1'>
        QTDE
    </div>
    <div   class='tb tb-header col-4'>
        NOME
    </div>
    <div   class='tb tb-header col-1'>
        PRAZO
    </div>
    <div   class='tb tb-header col-2'>
        IMPOSTO 
    </div>
    <div   class='tb tb-header col-2'>
        UNITÁRIO
    </div>
    <div   class='tb tb-header col-2'>
        TOTAL
    </div>
</div>

@foreach ($productProposals as $productProposal)
<div class='row'>
    <div class='tb col-1'>
        {{$productProposal->amount}}
    </div>
    <div class='tb col-4'>
        {{$productProposal->product->name}}
    </div>
    <div class='tb col-1'>
        {{$productProposal->subtotalDeadline}} dia(s)
    </div>
    <div class='tb col-2'>
        {{number_format($productProposal->subtotalTax_rate, 2,',','.')}}
    </div>
    <div class='tb col-2'>
        {{formatCurrencyReal($productProposal->subtotalPrice / $productProposal->amount)}}
    </div>
    <div class='tb col-2'>
        {{formatCurrencyReal($productProposal->subtotalPrice)}}
    </div>
</div>

<div class='row'>
    <div class='tb col-12 justify-content-start'>
        {!!html_entity_decode($productProposal->product->description)!!}
    </div>
</div>
@endforeach

<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        pontos: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        {{$invoice->totalPoints}}
    </div>
</div>

<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        desconto: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        - {{formatCurrencyReal($invoice->discount)}}
    </div>
</div>
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
                TOTAL DESTA FATURA: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        {{formatCurrencyReal($invoice->totalPrice)}}
    </div>
</div>
<br>
@if($totalInvoices <= 1 AND $invoice->number_installment_total > 1)
<p  style='text-align: right'>
    <a class='text-button secondary' href='{{route('invoice.installment', ['invoice' => $invoice])}}'>
        GERAR FATURAS DO PARCELAMENTO
    </a>
</p>
@endif
<br>
@if($invoice->status == 'rascunho' OR $invoice->status == 'rascunho')
<br>
<label class='labels' for='' >OPÇÕES DE PARCELAMENTO: </label>
<br>
@php
$counter = 1;
while($counter <= $invoice->number_installment_total) {
echo '$counter x = R$ '.number_format($invoice->totalPrice / $counter, 2,',','.');
echo '<br>';
$counter++;
}
@endphp
<br>
<br>
<br>
@endif
<br>
<div style='display: inline-block'>
    <img src='{{asset('images/financeiro.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >PAGAMENTOS:</label>
</div>
<br>
<br>
<div class='row'>
    <div   class='tb tb-header col-2'>
        DATA
    </div>
    <div   class='tb tb-header col-4'>
        RESPONSÁVEL
    </div>
    <div   class='tb tb-header col-4'>
        CONTA
    </div>
    <div   class='tb tb-header col-2'>
        VALOR
    </div>
</div>
@foreach($transactions as $transaction)
<div class='row'>
    <div class='tb col-2'>
        <button class='button-round'>
            <a href=' {{route('transaction.show', ['transaction' => $transaction->id])}}'>
                <i class='fa fa-eye' style='color:white'></i></a>
        </button>
        {{date('d/m/Y', strtotime($transaction->pay_day))}}
    </div>
    <div class='tb col-4'>
        {{$transaction->user->contact->name}}
    </div>
    <div class='tb col-4'>
        {{$transaction->bankAccount->name}}
    </div>
    <div class='tb col-2'>
        {{formatCurrencyReal($transaction->value)}}
    </div>
</div>
@endforeach
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        VALOR TOTAL: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        {{formatCurrencyReal($invoice->totalPrice)}}
    </div>
</div>
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        PAGO: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        - {{formatCurrencyReal($invoicePaymentsTotal)}}
    </div>
</div>
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        SALDO:
    </div>        
    <div   class='tb tb-header col-2 justify-content-end'>
        {{formatCurrencyReal($balance)}}
    </div>
</div>
<br>
<p style='text-align: right'>
    @if($typeInvoices == 'receita')
    <a class='circular-button primary' href='{{route('transaction.create', [
		'invoiceId' => $invoice->id,
		'invoiceIdentifier' => $invoice->identifier,
		'accountId' => $invoice->account_id,
		'accountName' => $invoice->account->name,
		'typeTransactions' => 'receita',
		'invoiceTotalPrice' => $invoice->installment_value,
				
	])}}'>
        <i class='fa fa-plus'></i>
    </a>
    @elseif($typeInvoices == 'despesa')
    <a class='circular-button primary' href='{{route('transaction.create', [
		'invoiceId' => $invoice->id,
		'invoiceIdentifier' => $invoice->identifier,
		'accountId' => $invoice->account_id,
		'accountName' => $invoice->account->name,
		'typeTransactions' => 'despesa',
		'invoiceTotalPrice' => $invoice->installment_value,
	])}}'>
        <i class='fa fa-plus'></i>
    </a>
    @endif
</p>
<br>
<br>
<label class='labels' for=''>SITUAÇÃO:</label>
<span class='fields'>{{$invoice->status}}</span>
<br>
<br>
<br>
<p class='labels'>  Criado em:   {{date('d/m/Y H:i', strtotime($invoice->created_at))}} </p>

<div style='text-align:right;padding: 2%'>
    <form   style='text-decoration: none;display: inline-block' action='{{route('invoice.destroy', ['invoice' => $invoice])}}' method='post'>
        @csrf
        @method('delete')
        <button class='circular-button delete' style='border: none;padding-left: 8px;padding-bottom: 5px' type='submit'>
            <i class='fa fa-trash'></i>
        </button>
    </form>
    <a class='circular-button secondary' href='{{route('invoice.edit', ['invoice' => $invoice->id])}}'  style='display: inline-block'>
        <i class='fa fa-edit'></i>
    </a>
    <a class='circular-button primary'  href='{{route('invoice.index')}}'>
        <i class='fas fa-arrow-left'></i>
    </a>
</div>
<br>

@endsection