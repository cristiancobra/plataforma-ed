@extends('layouts/show')

@if($type == 'receita')
@section('title','PROPOSTAS')
@else
@section('title','DESPESAS')
@endif

@section('image-top')
{{asset('images/proposal.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonPdf($proposal, 'proposal')}}
<a class='circular-button secondary' href='{{route('proposal.pdf', ['proposal' => $proposal])}}'>
    <i class='fas fa-envelope'></i>
</a>
{{createButtonTrash($proposal, 'proposal')}}
{{createButtonEdit('proposal', 'proposal', $proposal, 'type', $type)}}
{{createButtonList('proposal', 'type', $type)}}
@endsection

@if($proposal->name)
@section('name', $proposal->name)
@else
@section('name', 'Sem nome')
@endif

@section('priority')
{{formatShowStatus($proposal)}}
@endsection

@section('status')
@if($proposal->totalPrice < 0)
<div style='
     background-color: #FDDBDD;
     border-radius: 30px;
     padding-top: 5px;
     padding-bottom: 7px;
     padding-right: 15px;
     text-align: right
     '>
    {{formatCurrencyReal($proposal->totalPrice)}}
</div>
@else
<div style='
     background-color: lightblue;
     border-radius: 30px;
     padding-top: 5px;
     padding-bottom: 7px;
     padding-right: 15px;
     text-align: right
     '>
    {{formatCurrencyReal($proposal->totalPrice)}}
</div>
@endif
@endsection

@section('fieldsId')
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        CONTATO
    </div>
    @if(isset($proposal->opportunity))
    <div class='show-label'>
        OPORTUNIDADE
    </div>
    @endif
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($proposal->company))
        {{$proposal->company->name}}
        @else
        Pessoa física
        @endif
    </div>
    <div class='show-field-end'>
        @if(isset($proposal->contact->name))
        {{$proposal->contact->name}}
        @else
        Não possui
        @endif
    </div>
    @if(isset($proposal->opportunity))
    <div class='show-field-end'>
        <a href='{{route('opportunity.show', ['opportunity' => $proposal->opportunity_id])}}'>
            {{$proposal->opportunity->name}}
        </a>
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
        PARCELAMENTO
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($proposal->user->contact->name))
        {{$proposal->user->contact->name}}
        @else
        foi excluído
        @endif
    </div>
    <div class='show-field-end'>
        {{$proposal->identifier}}
    </div>
    <div class='show-field-end'>
        @if(!isset($proposal->contract_id) OR $proposal->contract_id == 0)
        Sem contrato
        @else
        <a href='{{route('contract.show', ['contract' => $proposal->contract_id])}}'>
            {{$proposal->contract->name}}
        </a>
        @endif
    </div>
    <div class='show-field-end'>
        @if($proposal->installment > 1)
        {{$proposal->installment}} vezes
        @else
        À vista
        @endif
    </div>
    @endsection


    @section('date_start')
    <div class='circle-date-start'>
        @if($proposal->date_creation == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($proposal->date_creation))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        @if($proposal->pay_day == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($proposal->pay_day))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        VENCIMENTO
    </p>
    @endsection


    @section('date_conclusion')
    <div class='circle-date-due'>
        {{$proposal->expiration_date}}
    </div>
    <p class='labels' style='text-align: center'>
        VALIDADE
    </p>
    @endsection


    @section('description')
    {!!html_entity_decode($proposal->description)!!}
    @if($type == 'receita')
    <br>
    {!!html_entity_decode($proposal->opportunity->description)!!}
    @endif
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
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >{{$itensName}}</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-right-style: solid;
             border-top-style: solid;
             border-right-width: 1px;
             border-top-width: 1px;
             border-color: #c28dbf;
             border-radius: 0 10px 0 0;
             '>
            <a  class='text-button secondary' style='display: inline-block;float: right' href='{{route('proposal.edit', [
                                                                                                                                                                                'proposal' => $proposal,
                                                                                                                                                                                'type' => $type,
                                                                                                                                                                                ])}}'>
                EDITAR
            </a>
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
        <div class='tb col-2 justify-content-end pt-3'>
            @if($productProposal->subtotalPrice < 0)
            <p style='color:red'>
                {{formatCurrencyReal($productProposal->subtotalPrice / $productProposal->amount)}}
            </p>
            @else
            <p style='text-align: right'>
                {{formatCurrencyReal($productProposal->subtotalPrice / $productProposal->amount)}}
            </p>
            @endif
        </div>
        <div class='tb col-2 justify-content-end pt-3'>
            @if($productProposal->subtotalPrice < 0)
            <p style='color:red'>
                {{formatCurrencyReal($productProposal->subtotalPrice)}}
            </p>
            @else
            <p style='text-align: right'>
                {{formatCurrencyReal($productProposal->subtotalPrice)}}
            </p>
            @endif
        </div>
    </div>

    <div class='row'>
        <div class='tb-description col-12 justify-content-start'>
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
           {{formatCurrencyReal($proposal->discount)}}
        </div>
    </div>
    <div class='row'>
        <div   class='tb tb-header col-10 justify-content-end'>
            TOTAL: 
        </div>
        <div   class='tb tb-header col-2 justify-content-end'>
            {{formatCurrencyReal($proposal->totalPrice)}}
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
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >FATURAS</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-right-style: solid;
             border-right-width: 1px;
             border-radius: 0px 7px 0px 0px;
             border-color: #c28dbf
             '>
            @if($invoicesCount <= 1)
            <form  style='display: inline-block;float: right' action='{{route('proposal.generateInstallment', ['proposal' => $proposal])}}'' method='get'>
                <input class='text-button secondary' type='submit' value=' GERAR  FATURAS'>
            </form>
            @endif
            <form  style='display: inline-block;float: right' action='{{route('proposal.editInstallment', ['proposal' => $proposal])}}'' method='get'>
                <input class='text-button secondary' type='submit' value=' EDITAR TODAS'>
            </form>
        </div>
    </div>

    <div class='row'>
        <div   class='tb tb-header col-1'>
            SITUAÇÃO
        </div>
        <div   class='tb tb-header col-5'>
            FATURA
        </div>
        <div   class='tb tb-header col-2'>
            VENCIMENTO
        </div>
        <div   class='tb tb-header col-2'>
            VALOR TOTAL
        </div>
        <div   class='tb tb-header col-2'>
            VALOR RESTANTE
        </div>
    </div>

    @foreach ($invoices as $invoice)
    <div class='row'>
        <div class='tb col-1 text-center'>
            <a href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
                {{faiconInvoiceStatus($invoice->status)}}
            </a>
        </div>
        <div   class='tb col-5 justify-content-start'>
            <a href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
                FATURA {{$invoice->identifier}}: parcela {{$invoice->number_installment}} de {{$proposal->installment}}
            </a>
        </div>
        <div   class='tb col-2'>
            <a href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
                {{date('d/m/Y', strtotime($invoice->pay_day))}}
            </a>
        </div>

        @if($invoice->totalPrice < 0)
        <div   class='tb col-2 justify-content-end'>
            <a href='{{route('invoice.show', ['invoice' => $invoice])}}' style='color: red'>
                {{formatCurrencyReal($invoice->totalPrice)}}
            </a>
        </div>
        @else
        <div   class='tb col-2 justify-content-end'>
            <a href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
                {{formatCurrencyReal($invoice->totalPrice)}}
            </a>
        </div>
        @endif

        @if($invoice->balance < 0)
        <div   class='tb col-2 justify-content-end' style='color:red'>
            {{formatCurrencyReal($invoice->balance)}}
        </div>
        @else
        <div   class='tb col-2 justify-content-end'>
            {{formatCurrencyReal($invoice->balance)}}
        </div>
        @endif
    </div>
    @endforeach

    <div class='row'>
        <div   class='tb tb-header col-10 justify-content-end'>
            {{formatCurrencyReal($invoicesTotal)}}
        </div>
        <div   class='tb tb-header col-2 justify-content-end'>
            {{formatCurrencyReal($balanceTotal)}}
        </div>
    </div>
    @endsection

    @section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{date('d/m/Y H:i', strtotime($proposal->created_at))}}
        </div>
    </div>
    @endsection