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
        <a href="{{route('proposal.editInstallment', ['proposal' => $proposal])}}">
        @if($proposal->installment > 1)
            {{$proposal->installment}} vezes
        @else
        À vista
        @endif
        </a>
    </div>
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
@if($proposal->opportunity AND $type == 'receita')
<br>
{!!html_entity_decode($proposal->opportunity->description)!!}
@endif
@endsection


@section('main')

<!--ITENS DA PROPOSTA / FATURA-->

<section class='container frame mt-5 pb-5' id='productProposals'>
    <div class="row">
        <div class='col-6 pt-4 pb-3'>
            <img src='{{asset('images/products.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >
                {{$itensName}}
            </label>
        </div>
        <div class='col-6 pt-4 pb-3'>
            <a  class='text-button secondary' style='display: inline-block;float: right' href='{{route('proposal.edit', [
                                                                                                                                                                                'proposal' => $proposal,
                                                                                                                                                                                'type' => $type,
                                                                                                                                                                                ])}}'>
                EDITAR
            </a>
        </div>
    </div>

    <div class='row table-header mt-3'>
        <div   class='col-4'>
            NOME
        </div>
        <div   class='col-1'>
            PRAZO
        </div>
        <div   class='col-2'>
            IMPOSTO 
        </div>
        <div class='col-1'>
            QTDE
        </div>
        <div   class='col-2'>
            PREÇO UNITÁRIO
        </div>
        <div   class='col-2'>
            PREÇO TOTAL
        </div>
    </div>

    @foreach ($productProposals as $productProposal)
    <div class='row table2 position-relative'  style='
         color: {{$principalColor}};
         border-left-color: {{$complementaryColor}}
         '>
        <div class="row">
            <div class='cel col-4 justify-content-start' style="font-weight: 600">
                {{$productProposal->product->name}}
            </div>
            <div class='cel col-1'>
                {{$productProposal->subtotalDeadline}} dia(s)
            </div>
            <div class='cel col-2'>
                {{number_format($productProposal->subtotalTax_rate, 2,',','.')}}
            </div>
            <div class='cel col-1 justify-content-center' style="font-weight: 600">
                {{$productProposal->amount}}
            </div>
            <div class='cel col-2 justify-content-end pt-3'>
                @if($productProposal->price < 0)
                <p style='color:red'>
                    {{formatCurrencyReal($productProposal->price)}}
                </p>
                @else
                <p style='text-align: right'>
                    {{formatCurrencyReal($productProposal->price)}}
                </p>
                @endif
            </div>
            <div class='cel col-2 justify-content-end pt-3'>
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
            <div class='cel col-6 justify-content-start' style="font-weight: 300;display: inline">
                {!!html_entity_decode($productProposal->product->description)!!}
            </div>
        </div>
    </div>
    @endforeach

    <div class='row mt-1'>
        <div class='cel offset-8 col-2 table-header justify-content-end' style="background-color: {{$oppositeColor}}">
            pontos: 
        </div>
        <div class='cel col-2 justify-content-end' style='font-weight: 600;color:{{$principalColor}}'>
            {{$proposal->totalPoints}}
        </div>
    </div>

    <div class='row mt-1'>
        <div class='cel offset-8 col-2 table-header justify-content-end' style="background-color: {{$oppositeColor}}">
            desconto: 
        </div>
        <div class='cel col-2 justify-content-end' style='font-weight: 600;color:{{$principalColor}}'>
            {{formatCurrencyReal($proposal->discount)}}
        </div>
    </div>
    <div class='row mt-1'>
        <div class='cel offset-8 col-2  table-header justify-content-end'>
            TOTAL: 
        </div>
        <div class='cel col-2 justify-content-end' style='font-weight: 600;color:{{$principalColor}}'>
            {{formatCurrencyReal($proposal->totalPrice)}}
        </div>
    </div>
</section>


<x-sections.invoices :proposal='$proposal' />



@endsection

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($proposal->created_at))}}
    </div>
</div>
@endsection

@section('workflow')
@if($invoicesCount < 1)
<div class='row'>
    <div class='col d-inline-block'>
        <form style='text-decoration: none;color: black;display: inline-block' action="{{route('proposal.generateInstallment', ['proposal' => $proposal])}}" method="post">
            @csrf
            @method('put')
            <button id='' class=' workflow-button-red' title='Gerar faturas dos pagamentos' type='submit'>
                <i class="fas fa-file-invoice-dollar" style="font-size:30px; color:white;padding-bottom: 10px"></i>
                <br>
                GERAR
                <br>
                FATURAS
            </button>
        </form>
    </div>
</div>
            @endif
@endsection