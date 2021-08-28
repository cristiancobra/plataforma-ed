@extends('layouts/show')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('images/transaction.png') }} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonTrash($transaction, 'transaction')}}
{{createButtonEdit('transaction', 'transaction', $transaction, 'typeTransactions', $transaction->type)}}
{{createButtonList('transaction')}}
@endsection

@section('name')
{{$transaction->type}}  por  {{strtoupper($transaction->payment_method)}}  em  {{strtoupper($transaction->bankAccount->name)}}
@endsection

@section('priority')
<div class='pb-2 pt-1' style='background-color: #c28dbf; border-radius:30px'>
    {{date('d/m/Y', strtotime($transaction->pay_day))}}
</div>
@endsection

@section('status')
@if($transaction->value < 0)
<div class='pe-4 pb-2 pt-1' style='background-color: #FDDBDD;border-radius:30px;text-align: right'>
    {{formatCurrencyReal($transaction->value)}}
</div>
@else
<div class='pe-4 pb-2 pt-1'  style='background-color: lightblue;border-radius:30px;text-align: right'>
    {{formatCurrencyReal($transaction->value)}}
</div>
@endif
@endsection

@section('description')
{!!html_entity_decode($transaction->observations)!!}
@endsection


@section('fieldsId')
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        OPORTUNIDADE
    </div>
    <div class='show-label'>
        FATURA
    </div>
    <div class='show-label'>
        @if($type == 'débito')
        DESPESA
        @else
        PROPOSTA
        @endif
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    @if(isset($transaction->invoice->proposal->company->name))
    <a href='{{route('company.show', ['company' => $transaction->invoice->proposal->company_id])}}'>
        <div class='show-field-end'>
            {{$transaction->invoice->proposal->company->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Pessoa física
    </div>
    @endif
    
    @if(isset($transaction->invoice->proposal->opportunity->name))
    <a href='{{route('opportunity.show', ['opportunity' => $transaction->invoice->proposal->opportunity_id])}}'>
        <div class='show-field-end'>
            {{$transaction->invoice->proposal->opportunity->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif
    
    @if(isset($transaction->invoice))
    <a href='{{route('invoice.show', ['invoice' => $transaction->invoice_id])}}'>
        <div class='show-field-end'>
            {{$transaction->invoice->identifier}}
        </div>
    </a>
    @else
        <div class='show-field-end'>
            Não possui
        </div>
    @endif
    
            @if(isset($transaction->invoice->proposal))
    <a href='{{route('proposal.show', ['proposal' => $transaction->invoice->proposal_id])}}'>
        <div class='show-field-end'>
            {{$transaction->invoice->proposal->name}}
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
        CONTA
    </div>
    <div class='show-label'>
        MÉTODO
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <a href='{{route('user.show', ['user' => $transaction->user_id])}}'>
    </a>
    <div class='show-field-end'>
        {{$transaction->user->contact->name}}
    </div>
    <a href='{{route('bankAccount.show', ['bankAccount' => $transaction->bank_account_id])}}'>
        <div class='show-field-end'>
            {{$transaction->bankAccount->name}}
        </div>
    </a>
    <div class='show-field-end'>
        {{$transaction->payment_method}}
    </div>
</div>
@endsection

@section('main')
<br>
<p class='fields'>Criado em:  {{date('d/m/Y H:i', strtotime($transaction->created_at))}}
    @endsection