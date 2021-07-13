@extends('layouts/master')

@section('title','PROPOSTAS')

@section('image-top')
{{asset('images/proposal.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class='circular-button secondary' href='{{route('proposal.pdf', ['proposal' => $proposal])}}'>
    <i class='fas fa-print'></i>
</a>
<a class='circular-button secondary' href='{{route('proposal.pdf', ['proposal' => $proposal])}}'>
    <i class='fas fa-envelope'></i>
</a>
{{createButtonBack()}}
{{createButtonList('proposal', 'typeInvoices', $proposalType)}}
@endsection

@section('main')
<label class='labels' for='' >IDENTIFICADOR:</label>
<span class='fields'>{{$proposal->identifier}}</span>
<br>
<label class='labels' for='' >PARCELA:</label>
@if($proposal->status == 'rascunho')
<span class='fields'>rascunho</span>
@elseif($proposal->status == 'orçamento')
<span class='fields'>orçamento</span>
@else
<span class='fields'>{{$proposal->number_installment}} de {{$proposal->number_installment_total}}</span>
@endif
<br>
<label class='labels' for='' >VENDEDOR:</label>
<span class='fields'>{{$proposal->user->contact->name}}</span>
<br>
<br>
<label class='labels' for='' >OPORTUNIDADE:</label>
@if(isset($proposal->opportunity_id))
<span class='fields'>{{$proposal->opportunity->name}}</span>
<button class='button-round'>
    <a href=' {{route('opportunity.show', ['opportunity' => $proposal->opportunity])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@else
não possui
@endif
<br>
<label class='labels' for='' >CONTRATO:</label>
@if(!isset($proposal->contract_id) OR $proposal->contract_id == 0)
Sem contrato
@else
<span class='fields'>{{$proposal->contract->name}}</span>
<button class='button-round'>
    <a href='{{route('contract.show', ['contract' => $proposal->contract_id])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@endif
<br>
@if($proposal->status == 'receita')
<label class='labels' for='' >EMPRESA:</label>
@else
<label class='labels' for='' >FORNECEDOR:</label>
@endif
@if(isset($proposal->company->name))
<span class='fields'>{{$proposal->company->name}}</span>
<button class='button-round'>
    <a href='{{route('company.show', ['company' => $proposal->company_id])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@else
Não possui
@endif
<br>
<label class='labels' for='' >CONTATO:</label>
@if(isset($proposal->contact_id))
<span class='fields'>{{$proposal->contact->name}}</span>
<button class='button-round'>
    <a href='{{route('contact.show', ['contact' => $proposal->contact_id])}}'>
        <i class='fa fa-eye' style='color:white'></i>
    </a>
</button>
@else
Não possui
@endif
<br>
<br>
<label class='labels' for='' >DATA DE CRIAÇÃO:</label>
<span class='fields'>{{date('d/m/Y', strtotime($proposal->date_creation))}}</span>
<br>
<label class='labels' for='' >VALIDADE DA PROPOSTA:</label>
<span class='fields'>{{$proposal->expiration_date}}</span>
<br>
<label class='labels' for='' >DATA DE PAGAMENTO:</label>
<span class='fields'>{{date('d/m/Y', strtotime($proposal->pay_day))}}</span>
<br>
<br>
<br>
@if(isset($proposal->opportunity_id))
<label class='labels' for=''>DESCRIÇÃO DA OPORTUNIDADE:</label>
<span class='fields'>{!!html_entity_decode($proposal->opportunity->description)!!}</span>
<br>
<br>
<br>
@endif

<label class='labels' for=''>OBSERVAÇÕES:</label>
@if(isset($proposal->description))
<span class='fields'>{!!html_entity_decode($proposal->description)!!}</span>
@else
Não possui
@endif
<br>
<br>
<br>
<div style='display: inline-block'>
    <img src='{{asset('images/products.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >ITENS DA PROPOSTA:</label>
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
        {{$proposal->totalPoints}}
    </div>
</div>

<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        desconto: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        - {{formatCurrencyReal($proposal->discount)}}
    </div>
</div>
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        TOTAL: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        {{formatCurrencyReal($proposal->installment_value)}}
    </div>
</div>
<br>

@if($proposal->status == 'rascunho' OR $proposal->status == 'rascunho')
<br>
<label class='labels' for='' >OPÇÕES DE PARCELAMENTO: </label>
<br>
@php
$counter = 1;
while($counter <= $proposal->number_installment_total) {
echo '$counter x = R$ '.number_format($proposal->totalPrice / $counter, 2,',','.');
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
        {{formatCurrencyReal($proposal->totalPrice)}}
    </div>
</div>
<div class='row'>
    <div   class='tb tb-header col-10 justify-content-end'>
        PAGO: 
    </div>
    <div   class='tb tb-header col-2 justify-content-end'>
        - {{formatCurrencyReal($proposalPaymentsTotal)}}
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
    @if($proposalType == 'receita')
    <a class='circular-button primary' href='{{route('transaction.create', [
		'proposalId' => $proposal->id,
		'proposalIdentifier' => $proposal->identifier,
		'accountId' => $proposal->account_id,
		'accountName' => $proposal->account->name,
		'typeTransactions' => 'receita',
		'proposalTotalPrice' => $proposal->installment_value,
				
	])}}'>
        <i class='fa fa-plus'></i>
    </a>
    @elseif($proposalType == 'despesa')
    <a class='circular-button primary' href='{{route('transaction.create', [
		'proposalId' => $proposal->id,
		'proposalIdentifier' => $proposal->identifier,
		'accountId' => $proposal->account_id,
		'accountName' => $proposal->account->name,
		'typeTransactions' => 'despesa',
		'proposalTotalPrice' => $proposal->installment_value,
	])}}'>
        <i class='fa fa-plus'></i>
    </a>
    @endif
</p>
<br>
<br>
@if($proposal->type == 'receita')
<div style='display: inline-block'>
    <img src='{{asset('images/proposal.png')}}' width='40px' height='40px'>
    <label class='labels' for='' >PARCELAMENTO:</label>
</div>
<br>
<br>
<div class='row'>
    <div   class='tb tb-header-start col-3'>
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
    <div   class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>
@foreach ($invoices as $invoice)
<div class='row'>
    <div   class='tb col-3'>
        <button class='button-round'>
            <a href=' {{route('invoice.show', ['invoice' => $invoice->id])}}'>
                <i class='fa fa-eye' style='color:white'></i>
            </a>
        </button>
        <button class='button-round'>
            <a href=' {{route('invoice.edit', ['invoice' => $invoice->id])}}'>
                <i class='fa fa-edit' style='color:white'></i>
            </a>
        </button>
        FATURA {{$invoice->identifier}}: parcela {{$invoice->number_installment}} de {{$invoice->number_installment_total}}
    </div>
    <div   class='tb col-2'>
        {{date('d/m/Y', strtotime($invoice->date_creation))}}
    </div>
    <div   class='tb col-2'>
        {{date('d/m/Y', strtotime($invoice->pay_day))}}
    </div>
    <div   class='tb col-2'>
        {{formatCurrencyReal($invoice->totalPrice)}}
    </div>
    <div   class='tb col-2'>
        {{formatCurrencyReal($invoice->installment_value)}}
    </div>

    {{formatInvoiceStatus($invoice)}}
</div>
@endforeach
@endif
<div class="row mt-3 mb-4">
    <div class='col justify-content-end'>
        <p  style='text-align: right'>
            <a class='text-button secondary' href='{{route('proposal.pdf', ['proposal' => $proposal])}}'>
                GERAR FATURAS
            </a>
        </p>
    </div>
</div>
<div style='display: inline-block'>
    <img src='{{asset('images/production.png')}}' width='40px' height='40px'>
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
        @if($task->user->image_id == null)
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' =>$task->user->id])}}'>
                <img src='{{asset($task->user->image_id)}}' width='100%' height='100%'>
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
<div id='produção' style='text-align:right'>
    <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
        @csrf
        <input type='hidden' name='task_name' value='PRODUZIR:'>
        <input type='hidden' name='opportunity_id' value='{{$proposal->opportunity_id}}'>
        <input type='hidden' name='opportunity_name' value='{{$proposal->opportunity->name}}'>
        @if($proposal->opportunity->contact)
        <input type='hidden' name='contact_name' value='{{$proposal->opportunity->contact->name}}'>
        <input type='hidden' name='contact_id' value='{{$proposal->opportunity->contact->id}}'>
        @endif
        <input type='hidden' name='account_name' value='{{$proposal->account->name}}'>
        <input type='hidden' name='account_id' value='{{$proposal->account->id}}'>
        <input type='hidden' name='department' value='produção'>
        <input class='text-button secondary' type='submit' value='SOLICITAR  PRODUÇÃO'>
    </form>
</div>
<br>
<br>

<label class='labels' for=''>SITUAÇÃO:</label>
<span class='fields'>{{$proposal->status}}</span>
<br>
<br>
<br>
<p class='labels'>  Criado em:   {{date('d/m/Y H:i', strtotime($proposal->created_at))}} </p>

<div style='text-align:right;padding: 2%'>
    <form   style='text-decoration: none;display: inline-block' action='{{route('proposal.destroy', ['proposal' => $proposal])}}' method='post'>
        @csrf
        @method('delete')
        <button class='circular-button delete' style='border: none;padding-left: 8px;padding-bottom: 5px' type='submit'>
            <i class='fa fa-trash'></i>
        </button>
    </form>
    <a class='circular-button secondary' href='{{route('proposal.edit', ['proposal' => $proposal->id])}}'  style='display: inline-block'>
        <i class='fa fa-edit'></i>
    </a>
    <a class='circular-button primary'  href='{{route('proposal.index')}}'>
        <i class='fas fa-arrow-left'></i>
    </a>
</div>
<br>

@endsection