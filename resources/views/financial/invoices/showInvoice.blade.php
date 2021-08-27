@extends('layouts/show')

@section('title','FATURAS')

@section('image-top')
{{asset('images/invoice.png')}} 
@endsection

@section('buttons')
{{createButtonPdf($invoice, 'invoice')}}
<a class='circular-button secondary' href='{{route('invoice.email', ['invoice' => $invoice])}}'>
    <i class='fas fa-envelope'></i>
</a>
{{createButtonBack()}}
{{createButtonTrash($invoice, 'invoice')}}
{{createButtonEdit('invoice', 'invoice', $invoice)}}
{{createButtonList('invoice', 'typeInvoices', $typeInvoices)}}
@endsection

@if($invoice->opportunity)
@section('name', $invoice->proposal->name)
@else
@section('name', 'sem oportunidade')
@endif

@section('priority')
{{formatShowStatus($invoice)}}
@endsection

@section('status')
<div style="
                    background-color: lightblue;
                    border-radius: 30px;
                    padding-top: 5px;
                    padding-bottom: 7px;
                    padding-right: 15px;
                    text-align: right
                    ">
    {{formatCurrencyReal($invoice->totalPrice)}}
</div>
@endsection

@section('fieldsId')
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        CONTATO
    </div>
    @if(isset($invoice->proposal->opportunity))
    <div class='show-label'>
        OPORTUNIDADE
    </div>
    @endif
    <div class='show-label'>
        @if($variation == 'débito')
        DESPESA
        @else
        PROPOSTA
        @endif
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($invoice->proposal->company))
        {{$invoice->proposal->company->name}}
        @else
        Pessoa física
        @endif
    </div>
    <div class='show-field-end'>
        @if(isset($invoice->contact->name))
        {{$invoice->contact->name}}
        @else
        Não possui
        @endif
    </div>
    @if(isset($invoice->proposal->opportunity))
    <div class='show-field-end'>
        {{$invoice->proposal->opportunity->name}}
    </div>
    @endif
    @if(isset($invoice->proposal))
    <a href='{{route('proposal.show', ['proposal' => $invoice->proposal_id])}}'>
        <div class='show-field-end'>
            {{$invoice->proposal->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif
</div>

<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
    <div class='show-label'>
        IDENTIFICADOR
    </div>
    <div class='show-label'>
        CONTRATO
    </div>
    <div class='show-label'>
        PARCELA
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        {{$invoice->user->contact->name}}
    </div>
    <div class='show-field-end'>
        {{$invoice->identifier}}
    </div>
    <div class='show-field-end'>
        @if(!isset($invoice->contract_id) OR $invoice->contract_id == 0)
        Sem contrato
        @else
        <a href='{{route('contract.show', ['contract' => $invoice->contract_id])}}'>
            <span class='fields'>{{$invoice->contract->name}}</span>

        </a>
        @endif
    </div>
    <div class='show-field-end'>
        {{$invoice->number_installment}}
        @if($invoice->proposal)
        de {{$invoice->proposal->installment}}
        @endif
    </div>
    @endsection

    @section('description')
    {!!html_entity_decode($invoice->description)!!}
    @endsection

    @section('date_start')
    <div class='circle-date-start'>
        @if($invoice->date_creation == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($invoice->date_creation))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
    @endsection

    @section('date_due')
    <div class='circle-date-due'>
        @if($invoice->expiration_date == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($invoice->expiration_date))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        VALIDADE
    </p>
    @endsection

    @section('date_conclusion')
    <div class='circle-date-conclusion'>
        @if($invoice->pay_day == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($invoice->pay_day))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        VENCIMENTO
    </p>
    @endsection

    @section('main')
    <div class='row mt-5'>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-left-style: solid;
             border-left-width: 1px;
             border-radius: 7px 0px 0px 0px;
             border-color: #c28dbf;
             '>
            <img src='{{asset('images/invoice.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >PAGAMENTOS</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-right-style: solid;
             border-right-width: 1px;
             border-radius: 0px 7px 0px 0px;
             border-color: #c28dbf
             '>

        </div>
    </div>
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
        <div class='tb col-2 justify-content-end'>
            {{formatCurrencyReal($transaction->value)}}
        </div>
    </div>
    @endforeach
    <div class='row'>
        <div   class='tb tb-header col-10 justify-content-end'>
            PAGO: 
        </div>
        <div   class='tb tb-header col-2 justify-content-end'>
            {{formatCurrencyReal($invoicePaymentsTotal)}}
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
		'pay_day' => $invoice->pay_day,
		'typeTransactions' => 'crédito',
		'invoiceTotalPrice' => $invoice->totalPrice,
				
	])}}'>
            <i class='fa fa-plus'></i>
        </a>
        @elseif($typeInvoices == 'despesa')
        <a class='circular-button primary' href='{{route('transaction.create', [
		'invoiceId' => $invoice->id,
		'invoiceIdentifier' => $invoice->identifier,
		'accountId' => $invoice->account_id,
		'accountName' => $invoice->account->name,
                		'pay_day' => $invoice->pay_day,
		'typeTransactions' => 'débito',
		'invoiceTotalPrice' => $balance,
	])}}'>
            <i class='fa fa-plus'></i>
        </a>
        @endif
    </p>
    <p class='labels'>  Criado em:   {{date('d/m/Y H:i', strtotime($invoice->created_at))}} </p>
    @endsection