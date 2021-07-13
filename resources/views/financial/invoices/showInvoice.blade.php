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
{{createButtonList('invoice', 'typeInvoices', $typeInvoices)}}
@endsection

@section('name', $invoice->opportunity->name)

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
        @if(isset($invoice->company->name))
        {{$invoice->company->name}}
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
    <div class='show-field-end'>
        @if(isset($invoice->opportunity))
        <a href='{{route('opportunity.show', ['opportunity' => $invoice->opportunity_id])}}'>
            {{$invoice->opportunity->name}}
        </a>
        @else
        Sem oportunidade
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
        @if(isset($invoice->user->contact->name))
        {{$invoice->user->contact->name}}
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
            {{$invoice->contract->name}}
        </a>
        @endif
    </div>
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


    @section('date_conclusion')

    @endsection


    @section('description')
    {!!html_entity_decode($invoice->description)!!}
    <br>
    {!!html_entity_decode($invoice->opportunity->description)!!}
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
            <form  style='display: inline-block;float: right' action='{{route('invoice.edit', ['invoice' => $invoice])}}' method='post'>
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

    @if($invoice->number_installment > 1)
    <div class='row'>
        <div class='tb col-10 justify-content-start'>
            Parcelamento de serviços anteriores
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
    @if($totalInvoices <= 1 AND $invoice->number_installment_total > 1)
    <p  style='text-align: right'>
        <a class='text-button secondary' href='{{route('invoice.installment', ['invoice' => $invoice])}}'>
            GERAR FATURAS DO PARCELAMENTO
        </a>
    </p>
    @endif
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
            <form  style='display: inline-block;float: right' action='{{route('invoice.edit', ['invoice' => $invoice])}}' method='post'>
                <input class='text-button secondary' type='submit' value='EDITAR'>
            </form>
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
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >PARCELAMENTO</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-right-style: solid;
             border-right-width: 1px;
             border-radius: 0px 7px 0px 0px;
             border-color: #c28dbf
             '>
            <form  style='display: inline-block;float: right' action='{{route('invoice.edit', ['invoice' => $invoice])}}' method='post'>
                <input class='text-button secondary' type='submit' value='EDITAR'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div   class='tb tb-header col-3'>
            IDENTIFICADOR
        </div>
        <div   class='tb tb-header col-2'>
            DATA CRIAÇÃO 
        </div>
        <div   class='tb tb-header col-2'>
            DATA PAGAMENTO
        </div>
        <div   class='tb tb-header col-2'>
            VALOR TOTAL
        </div>
        <div   class='tb tb-header col-2'>
            VALOR DA PARCELA
        </div>
        <div   class='tb tb-header col-1'>
            SITUAÇÃO
        </div>
    </div>
    @if($invoices)
    @foreach ($invoices as $invoice2)
    <div class='row'>
        <div   class='tb col-3'>
            <button class='button-round'>
                <a href=' {{route('invoice.show', ['invoice' => $invoice2->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i>
                </a>
            </button>
            <button class='button-round'>
                <a href=' {{route('invoice.edit', ['invoice' => $invoice2->id])}}'>
                    <i class='fa fa-edit' style='color:white'></i>
                </a>
            </button>
            FATURA {{$invoice2->identifier}}: parcela {{$invoice2->number_installment}} de {{$invoice2->number_installment_total}}
        </div>
        <div   class='tb col-2'>
            {{date('d/m/Y', strtotime($invoice2->date_creation))}}
        </div>
        <div   class='tb col-2'>
            {{date('d/m/Y', strtotime($invoice2->pay_day))}}
        </div>
        <div   class='tb col-2'>
            {{formatCurrencyReal($invoice2->totalPrice)}}
        </div>
        <div   class='tb col-2'>
            {{formatCurrencyReal($invoice2->installment_value)}}
        </div>

        {{formatInvoiceStatus($invoice2)}}
    </div>
    @endforeach
    @endif
</div>
<div class='row mt-5'>
    <div class='col-6 pt-4 pb-3' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-left-style: solid;
         border-left-width: 1px;
         border-radius: 7px 0px 0px 0px;
         border-color: #c28dbf;
         '>
        <img src='{{asset('images/production.png')}}' width='25px' height='25px'>
        <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >PRODUÇÃO</label>
    </div>
    <div class='col-6 pt-4 pb-3' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-right-style: solid;
         border-right-width: 1px;
         border-radius: 0px 7px 0px 0px;
         border-color: #c28dbf
         '>
        <form  style='display: inline-block;float: right'  action='{{route('task.create')}}' method='post'>
            @csrf
            <input type='hidden' name='task_name' value='PRODUZIR:'>
            <input type='hidden' name='opportunity_id' value='{{$invoice->opportunity_id}}'>
            <input type='hidden' name='opportunity_name' value='{{$invoice->opportunity->name}}'>
            @if($invoice->opportunity->contact)
            <input type='hidden' name='contact_name' value='{{$invoice->opportunity->contact->name}}'>
            <input type='hidden' name='contact_id' value='{{$invoice->opportunity->contact->id}}'>
            @endif
            <input type='hidden' name='account_name' value='{{$invoice->account->name}}'>
            <input type='hidden' name='account_id' value='{{$invoice->account->id}}'>
            <input type='hidden' name='department' value='produção'>
            <input class='text-button secondary' type='submit' value='SOLICITAR  PRODUÇÃO'>
        </form>
    </div>
</div>
<div class='row mt-2'>
    <div class='tb tb-header col-3'>
        NOME
    </div>
    <div class='tb tb-header col-2'>
        CONTATO
    </div>
    <div class='tb tb-header col-2'>
        EMPRESA
    </div>
    <div class='tb tb-header col-2'>
        RESPONSÁVEL
    </div>
    <div class='tb tb-header col-1'>
        PRAZO
    </div>
    <div class='tb tb-header col-1'>
        PRIORIDADE
    </div>
    <div class='tb tb-header col-1'>
        SITUAÇÃO
    </div>
</div>

@foreach ($tasksOperational as $task)
<div class='row'>
    <div class='tb col-3 justify-content-start' style='font-weight: 600'>
        <a class='white' href=' {{ route('task.show', ['task' => $task->id]) }}'>
            <button class='button-round'>
                <i class='fa fa-eye'></i>
            </button>
        </a>
        {{$task->name}}
    </div>
    <div class='tb col-2'>
        <a  class='white' href=' {{ route('contact.show', ['contact' => $task->contact_id]) }}'>
            @if(isset($task->contact->name))
            {{$task->contact->name}}
            @else
            contato excluído
            @endif
        </a>
    </div>
    <div class='tb col-2'>
        @if(isset($task->company->name))
        {{$task->company->name}}
        @else
        não possui
        @endif
    </div>
    <div class='tb col-2'>
        @if($task->user->profile_picture)
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' =>$task->user->id])}}'>
                <img src='{{asset($task->user->profile_picture)}}' width='100%' height='100%'>
            </a>
        </div>
        @elseif(isset($task->user->contact->name))
        {{$task->user->contact->name}}
        @else
        funcionário excluído
        @endif
    </div>
    <div class='tb col-1'>
        @if($task->date_due == date('Y-m-d'))
        hoje
        @elseif($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
        <p style='color: red'>
            {{dateBr($task->date_due)}}
        </p>
        @else
        {{dateBr($task->date_due)}}
        @endif
    </div>
    {{formatPriority($task)}}

    @php
    if($task->status == 'fazer' AND $task->journeys()->exists()) {
    $task->status == 'fazendo';
    }
    @endphp
    {{formatStatus($task)}}

</div>

@foreach($task->journeys as $journey)
<div class='row'>        
    <div class='tb col-2 justify-content-start' style='background-color:#d8c2db'>
        <button class='button-round'>
            <a href=' {{route('journey.show', ['journey' => $journey->id])}}'>
                <i class='fas fa-clock' style='color:white'></i>
            </a>
        </button>
        {{dateBr($journey->date)}}
    </div>
    <div class='tb col-7 justify-content-start' colspan='3' style='background-color:#d8c2db'>
        {!!html_entity_decode($journey->description)!!}
    </div>
    <div class='tb col-2' style='background-color:#d8c2db'>
        @if($task->user->profile_picture)
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' =>$task->user->id])}}'>
                <img src='{{asset($task->user->profile_picture)}}' width='100%' height='100%'>
            </a>
        </div>
        @elseif(isset($task->user->contact->name))
        {{$journey->user->contact->name}}
        @else
        funcionário excluído
        @endif
    </div>
    <div class='tb col-1' style='background-color:#d8c2db'>
        {{formatTotalHour($journey->duration)}} horas
    </div>
</div>
@endforeach
<div class='row'>
    <div class="col-12 pt-5">
    </div>
</div>
@endforeach
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        TOTAL:
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        {{formatTotalHour($tasksOperationalHours)}} horas
    </div>
</div>
<br>
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