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
{{createButtonTrash($invoice, 'invoice')}}
{{createButtonEdit('invoice', 'invoice', $invoice)}}
{{createButtonList('invoice', 'typeInvoices', $typeInvoices)}}
@endsection

@if($invoice->opportunity)
@section('name', $invoice->proposal->name)
@else
@section('name', 'sem oportunidade')
@endif


@section('priority', $priority)


@section('status', $status)


@section('fieldsId')
<div class='col-lg-2 col-xs-6 pe-0' style='text-align: center'>
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
    <div class='show-label'>
        SALDO
    </div>
</div>
<div class='col-lg-4 col-xs-6 ps-0' style='text-align: center'>
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
        <a href='{{route('opportunity.show', ['opportunity' => $invoice->proposal->opportunity])}}'>
            {{$invoice->proposal->opportunity->name}}
        </a>
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
    @if($invoice->totalBalance < 0)
    <div class='show-field-end'>
        {{$invoice->totalBalance}}
    </div>
    @else
    <div class='show-field-end'>
        0,00
    </div>
    @endif
</div>

<div class='col-lg-2 col-xs-6 pe-0' style='text-align: center'>
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
    <div class='show-label'>
        VALOR
    </div>
</div>
<div class='col-lg-4 col-xs-6 ps-0' style='text-align: center'>
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
    <div class='show-field-end'>
        {{$invoice->totalPrice}}
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
    <x-sections.transactions :invoice='$invoice' />
    
    <p class='labels'>  Criado em:   {{date('d/m/Y H:i', strtotime($invoice->created_at))}} </p>
    @endsection