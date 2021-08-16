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

@if($invoice->opportunity)
@section('name', $invoice->opportunity->name)
@else
@section('name', 'sem oportunidade')
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
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($invoice->opportunity->company->name))
        {{$invoice->opportunity->company->name}}
        @else
        Pessoa física
        @endif
    </div>
    <div class='show-field-end'>
        @if(isset($invoice->opportunity->contact->name))
        {{$invoice->opportunity->contact->name}}
        @else
        Não possui
        @endif
    </div>
    <div class='show-field-end'>
        @if(isset($invoice->opportunity->name))
        {{$invoice->opportunity->name}}
        @else
        Não possui
        @endif
    </div>
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
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($invoice->opportunity->user->contact->name))
        {{$invoice->opportunity->user->contact->name}}
        @else
        foi excluído
        @endif
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
             border-left-style: solid;
             border-top-style: solid;
             border-left-width: 1px;
             border-top-width: 1px;
             border-color: #c28dbf;
             border-radius: 10px 0 0 0;
             '>
            <img src='{{asset('images/products.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >ITENS FATURADOS</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-right-style: solid;
             border-top-style: solid;
             border-right-width: 1px;
             border-top-width: 1px;
             border-color: #c28dbf;
             border-radius: 0 10px 0 0;
             '>
            <form  style='display: inline-block;float: right' action='{{route('proposal.edit', ['proposal' => $invoice->proposal_id])}}' method='get'>
                <input class='text-button secondary' type='submit' value='EDITAR'>
            </form>
        </div>
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
        <div class='tb col-2'>
            {{formatCurrencyReal($transaction->value)}}
        </div>
    </div>
    @endforeach
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
    @endsection