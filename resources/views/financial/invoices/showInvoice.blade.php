@extends('layouts/show')

@section('title','FATURAS')

@section('image-top')
{{asset('images/invoice.png')}} 
@endsection

@section('buttons')
<a class='circular-button secondary' href='{{route('invoice.pdf', ['invoice' => $invoice])}}'>
    <i class='fas fa-print'></i>
</a>
<a class='circular-button secondary' href='{{route('invoice.email', ['invoice' => $invoice])}}'>
    <i class='fas fa-envelope'></i>
</a>
{{createButtonBack()}}
{{createButtonTrash($invoice, 'invoice')}}
{{createButtonEdit('invoice', 'invoice', $invoice)}}
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

@section('priority')
@endsection

@section('status')
{{formatShowStatus($invoice)}}
@endsection

@section('fieldsId')
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        CONTATO
    </div>
    <div class='show-label'>
        OPORTUNIDADE
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
    @endsection

<div class='row'>
    <div class='tb col-12 justify-content-start'>
        {!!html_entity_decode($productProposal->product->description)!!}
    </div>
</div>
@endforeach

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

<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        TOTAL DA COMPRA: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
               {{formatCurrencyReal($invoice->proposal->totalPrice)}}
    </div>
</div>
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
                VALOR DESTA FATURA: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        {{formatCurrencyReal($invoice->totalPrice)}}
    </div>
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

    @if($invoice->number_installment > 1)
    <div class='row'>
        <div class='tb col-10 justify-content-start'>
            Parcelamento de serviços
        </div>
        <div class='tb col-2 justify-content-end'>
            {{formatCurrencyReal($invoice->installment_value)}}
        </div>
    </div>
    @else
    @foreach ($invoiceLines as $invoiceLine)
    <div class='row'>
        <div class='tb col-1'>
            {{$invoiceLine->amount}}
        </div>
        <div class='tb col-4'>
            {{$invoiceLine->product->name}}
        </div>
        <div class='tb col-1'>
            {{$invoiceLine->subtotalDeadline}} dia(s)
        </div>
        <div class='tb col-2'>
            {{number_format($invoiceLine->subtotalTax_rate, 2,',','.')}}
        </div>
        <div class='tb col-2'>
            {{formatCurrencyReal($invoiceLine->subtotalPrice / $invoiceLine->amount)}}
        </div>
        <div class='tb col-2'>
            {{formatCurrencyReal($invoiceLine->subtotalPrice)}}
        </div>
    </div>

    <div class='row'>
        <div class='tb col-12 justify-content-start'>
            {!!html_entity_decode($invoiceLine->product->description)!!}
        </div>
    </div>
    @endforeach
    @endif

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
            TOTAL: 
        </div>
        <div   class='tb tb-header col-2 justify-content-end'>
            {{formatCurrencyReal($invoice->installment_value)}}
        </div>
    </div>
    <br>
    <br>
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
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >FINANCEIRO</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-right-style: solid;
             border-right-width: 1px;
             border-radius: 0px 7px 0px 0px;
             border-color: #c28dbf
             '>
            <form  style='display: inline-block;float: right' action='{{route('invoice.edit', ['invoice' => $invoice])}}' method='get'>
                <input class='text-button secondary' type='submit' value='EDITAR'>
            </form>
        </div>
    </div>
</div>
@endforeach
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        PAGO: 
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
@endsection

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($invoice->created_at))}}
    </div>
</div>
@endsection
