@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{asset('imagens/invoice.png')}} 
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
<span class='fields'>{{$invoice->user->contact->name}}</span>
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
<label class='labels' for='' >DATA DE PAGAMENTO:</label>
<span class='fields'>{{date('d/m/Y', strtotime($invoice->pay_day))}}</span>
<br>
<br>
@if(isset($invoice->opportunity_id))
<label class='labels' for=''>DESCRIÇÃO DA OPORTUNIDADE:</label>
<span class='fields'>{!!html_entity_decode($invoice->opportunity->description)!!}</span>
<br>
@endif
<label class='labels' for=''>OBSERVAÇÕES:</label>
<span class='fields'>{!!html_entity_decode($invoice->description)!!}</span>
<br>
<div style='display: inline-block'>
    <img src='{{asset('imagens/products.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >ITENS DA FATURA:</label>
</div>
<br>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header' style='width: 5%'>
            QTDE
        </td>
        <td   class='table-list-header' style='width: 55%'>
            NOME
        </td>
        <td   class='table-list-header' style='width: 10%'>
            PRAZO
        </td>
        <td   class='table-list-header' style='width: 10%'>
            IMPOSTO 
        </td>
        <td   class='table-list-header' style='width: 10%'>
            UNITÁRIO
        </td>
        <td   class='table-list-header' style='width: 10%'>
            TOTAL
        </td>
    </tr>

    @foreach ($invoiceLines as $invoiceLine)
    <tr style='font-size: 14px'>
        <td class='table-list-center'>
            {{$invoiceLine->amount}}
        </td>
        <td class='table-list-left'>
            {{$invoiceLine->product->name}}
        </td>
        <td class='table-list-center'>
            {{$invoiceLine->subtotalDeadline}} dia(s)
        </td>
        <td class='table-list-right'>
            {{number_format($invoiceLine->subtotalTax_rate, 2,',','.')}}
        </td>
        <td class='table-list-right'>
            {{formatCurrencyReal($invoiceLine->subtotalPrice / $invoiceLine->amount)}}
        </td>
        <td class='table-list-right'>
            {{formatCurrencyReal($invoiceLine->subtotalPrice)}}
        </td>
    </tr>

    <tr style='font-size: 12px'>
        <td class='table-list-left' colspan='6'>
            {!!html_entity_decode($invoiceLine->product->description)!!}
        </td>
    </tr>
    @endforeach


    <tr>
        <td   class='table-list-header-right' colspan='4'>
            pontos: 
        </td>
        <td   class='table-list-header-right' colspan='2'>
            {{$invoice->totalPoints}}
        </td>
    </tr>

    <tr>
        <td   class='table-list-header-right' colspan='4'>
            desconto: 
        </td>
        <td   class='table-list-header-right' colspan='2'>
            - {{formatCurrencyReal($invoice->discount)}}
        </td>
    </tr>
    <tr>
        <td   class='table-list-header-right' colspan='4'>
            TOTAL: 
        </td>
        </td>
        <td   class='table-list-header-right' colspan='2'>
            {{formatCurrencyReal($invoice->installment_value)}}
        </td>
    </tr>
    <tr>
        <td   class='table-list-header-right' colspan='4'>
            PARCELAMENTO: 
        </td>
        <td   class='table-list-header-right' colspan='2'>
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
<p  style='text-align: right'>
    <a class='text-button secondary' href='{{route('invoice.installment', ['invoice' => $invoice])}}'>
        GERAR FATURAS DO PARCELAMENTO
    </a>
</p>
@else
<p  style='text-align: right'>
    <a class='text-button secondary' href='{{route('invoice.edit', ['invoice' => $invoice])}}'>
        APROVAR PARA LIBERAR PARCELAMENTO
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
    <img src='{{asset('imagens/financeiro.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >PAGAMENTOS:</label>
</div>
<br>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header' style='width: 10%'>
            DATA
        </td>
        <td   class='table-list-header' style='width: 50%'>
            RESPONSÁVEL
        </td>
        <td   class='table-list-header' style='width: 10%'>
            CONTA
        </td>
        <td   class='table-list-header' style='width: 10%'>
            VALOR
        </td>
    </tr>
    @foreach($transactions as $transaction)
    <tr>
        <td class='table-list-center'>
            <button class='button-round'>
                <a href=' {{route('transaction.show', ['transaction' => $transaction->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{date('d/m/Y', strtotime($transaction->pay_day))}}
        </td>
        <td class='table-list-center'>
            {{$transaction->user->contact->name}}
        </td>
        <td class='table-list-center'>
            {{$transaction->bankAccount->name}}
        </td>
        <td class='table-list-right'>
            {{formatCurrencyReal($transaction->value)}}
        </td>
    </tr>
    @endforeach
    <tr>
        <td   class='table-list-header-right' colspan='3'>
            VALOR TOTAL: 
        </td>
        </td>
        <td   class='table-list-header-right' colspan='2'>
            {{formatCurrencyReal($invoice->installment_value)}}
        </td>
    </tr>
    <tr>
        <td   class='table-list-header-right' colspan='3'>
            PAGO: 
        </td>
        </td>
        <td   class='table-list-header-right' colspan='2'>
            - {{formatCurrencyReal($invoicePaymentsTotal)}}
        </td>
    </tr>
    <tr>
        <td   class='table-list-header-right'colspan='3'>
            SALDO:
        </td>
        </td>
        <td   class='table-list-header-right' colspan='2'>
            {{formatCurrencyReal($balance)}}
        </td>
    </tr>
</table>
<br>
<p style='text-align: right'>
    @if($typeInvoices == 'receita')
    <a class='text-button secondary' href='{{route('transaction.create', [
		'invoiceId' => $invoice->id,
		'invoiceIdentifier' => $invoice->identifier,
		'accountId' => $invoice->account_id,
		'accountName' => $invoice->account->name,
		'typeTransactions' => 'receita',
		'invoiceTotalPrice' => $invoice->installment_value,
				
	])}}'>
        REGISTRAR ENTRADA
    </a>
    @elseif($typeInvoices == 'despesa')
    <a class='text-button secondary' href='{{route('transaction.create', [
		'invoiceId' => $invoice->id,
		'invoiceIdentifier' => $invoice->identifier,
		'accountId' => $invoice->account_id,
		'accountName' => $invoice->account->name,
		'typeTransactions' => 'despesa',
		'invoiceTotalPrice' => $invoice->installment_value,
	])}}'>
        REGISTRAR SAÍDA
    </a>
    @endif
</p>
<br>
<br>
@if($invoice->type == 'receita')
<div style='display: inline-block'>
    <img src='{{asset('imagens/invoice.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >PARCELAMENTO:</label>
</div>
<br>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header' style='width: 30%'>
            IDENTIFICADOR
        </td>
        <td   class='table-list-header' style='width: 20%'>
            DATA CRIAÇÃO 
        </td>
        <td   class='table-list-header' style='width: 20%'>
            DATA PAGAMENTO
        </td>
        <td   class='table-list-header' style='width: 10%'>
            VALOR TOTAL
        </td>
        <td   class='table-list-header' style='width: 10%'>
            VALOR DA PARCELA
        </td>
        <td   class='table-list-header' style='width: 10%'>
            SITUAÇÃO
        </td>
    </tr>
    @if($invoices)
    @foreach ($invoices as $invoice)
    <tr style='font-size: 14px'>
        <td class='table-list-left'>
            <button class='button-round'>
                <a href=' {{route('invoice.show', ['invoice' => $invoice->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            <button class='button-round'>
                <a href=' {{route('invoice.edit', ['invoice' => $invoice->id])}}'>
                    <i class='fa fa-edit' style='color:white'></i></a>
            </button>
            FATURA {{$invoice->identifier}}: parcela {{$invoice->number_installment}} de {{$invoice->number_installment_total}}
        </td>
        <td class='table-list-center'>
            {{date('d/m/Y', strtotime($invoice->date_creation))}}
        </td>
        <td class='table-list-center'>
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </td>
        <td class='table-list-right'>
            {{formatCurrencyReal($invoice->totalPrice)}}
        </td>
        <td class='table-list-right'>
            {{formatCurrencyReal($invoice->installment_value)}}
        </td>
        @if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
        <td class='td-late'>
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
<br>
<div style='display: inline-block'>
    <img src='{{asset('imagens/production.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >PRODUÇÃO:</label>
</div>
<br>
<br>
<div class='row mt-2'>
    <div class='tb tb-header-start col-3'>
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
    <div class='tb tb-header-end col-1'>
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
        <div   class='table-list-header-right'colspan='6'>
            TOTAL:
        </div>
        <div   class='table-list-header-right' colspan='1'>
            {{formatTotalHour($tasksOperationalHours)}} horas
        </div>
    </div>
<br>
<div id='produção' style='text-align:right'>
    <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
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
<br>
<br>
@endif
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