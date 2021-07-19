@extends('layouts/show')

@section('title','OPORTUNIDADES')

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonTrash($opportunity, 'opportunity')}}
{{createButtonEdit('opportunity', 'opportunity', $opportunity)}}
{{createButtonList('opportunity')}}
@endsection

@section('name', $opportunity->name)

@section('priority')
{{formatShowStage($opportunity->stage)}}
@endsection

@section('status')
{{formatShowStatus($opportunity)}}
@endsection

@section('fieldsId')
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        CONTATO
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($opportunity->company->name))
        {{$opportunity->company->name}}
        @else
        Pessoa física
        @endif
    </div>
    <div class='show-field-end'>
        @if(isset($opportunity->contact->name))
        {{$opportunity->contact->name}}
        @else
        Não possui
        @endif
    </div>
</div>
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='show-field-end'>
        @if(isset($opportunity->user->contact->name))
        {{$opportunity->user->contact->name}}
        @else
        foi excluído
        @endif
    </div>
@endsection

    @section('date_start')
    <div class='circle-date-start'>
        @if($opportunity->date_start == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($opportunity->date_start))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CRIAÇÃO
    </p>
    @endsection


    @section('date_due')    
    <div class='circle-date-due'>
        @if($opportunity->pay_day == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($opportunity->pay_day))}}
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        PRÓXIMO CONTATO
    </p>
    @endsection


    @section('date_conclusion')
    <div class='circle-date-conclusion'>
        @if($opportunity->date_conclusion == null)
        --
        @else
        <p style='color:white'>
            {{date('d/m/Y', strtotime($opportunity->date_conclusion))}}
        </p>
        @endif
    </div>
    <p class='labels' style='text-align: center'>
        CONCLUSÃO
    </p>
    @endsection


    @section('description')
    {!!html_entity_decode($opportunity->description)!!}
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
            <img src='{{asset('images/vendas.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >PROSPECÇÃO</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-right-style: solid;
             border-top-style: solid;
             border-right-width: 1px;
             border-top-width: 1px;
             border-color: #c28dbf;
             border-radius: 0 10px 0 0;
             '>
            <form  style='display: inline-block;float: right'  action='{{route('task.create')}}' method='post'>
                @csrf
                <input type='hidden' name='task_name' value='ENVIAR MATERIAL:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='company_name' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='company_id' value='{{$opportunity->company->id}}'>
                @endif
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value='ENVIAR MATERIAL'>
            </form>
            <form  style='display: inline-block;float: right' action='{{route('task.create')}}' method='post'>
                @csrf
                <input type='hidden' name='task_name' value='AGENDAR REUNIÃO:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='company_name' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='company_id' value='{{$opportunity->company->id}}'>
                @endif
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value='AGENDAR REUNIÃO'>
            </form>
        </div>
    </div>
    <div class='tb-row'>
        @if(!$opportunity->company)
        <a href='{{route('company.create')}}'>
            adicionar empresa
        </a>
        @else
        <i class="fas fa-store me-2"></i>
        <a href='{{route('company.edit', [
                                                                'company' => $opportunity->company,
                                                                 'typeCompanies' => 'cliente'
                                                                ])}}'>
            <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for='' >
                {{mb_strtoupper($opportunity->company->name)}}
            </label>
        </a>
        @endif
    </div>
    <div class='tb-row'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Proposta de valor: </label>
        @if(!$opportunity->company->value_offer)
        --
        @else
        {!!html_entity_decode($opportunity->company->value_offer)!!}
        @endif
    </div>
    <div class='tb-row'>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Diferencial competitivo: </label>
            @if(!$opportunity->company->competitive_advantage)
            --
            @else

            {{$opportunity->company->competitive_advantage}}

            @endif
        </div>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Modelo de negócio: </label>
            @if(!$opportunity->company->business_model)
            --
            @else

            {{$opportunity->company->business_model}}

            @endif
        </div>
    </div>

    <div class='tb-row'>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Setor: </label>
            @if(!$opportunity->company->sector)
            --
            @else

            {{$opportunity->company->sector}}

            @endif
        </div>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Funcionários: </label>
            @if(!$opportunity->company->employees)
            --
            @else
            <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for='' >
                {{$opportunity->company->employees}}
            </label>
            @endif
        </div>
    </div>

    <div class='tb-row'>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Clientes: </label>
            @if(!$opportunity->company->client_number)
            --
            @else
            {{$opportunity->company->client_number}}
            @endif
        </div>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Faturamento: </label>
            @if(!$opportunity->company->revenues)
            --
            @else

            {{$opportunity->company->revenues}}

            @endif
        </div>
    </div>
    <div class='tb-row pt-5'>
        <i class="fas fa-users me-2"></i>
        @if($opportunity->contact->name)
        <a href='{{route('contact.show', ['contact' => $opportunity->contact])}}'>
            <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for='' >
                {{mb_strtoupper($opportunity->contact->name)}}
            </label>
        </a>
        @else
        <a href='{{route('contact.create')}}'>
            adicionar
        </a>
        @endif
    </div>
    <div class='tb-row'>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Email: </label>
            {{$opportunity->contact->name}}
        </div>
        <div class="col">
            <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Telefone: </label>
            {{$opportunity->contact->phone}}
        </div>
    </div>
    <div class='row'>
        <div class='col-2 tb tb-header'>
            CRIAÇÃO 
        </div>
        <div class='tb tb-header col-3'>
            TAREFA 
        </div>
        <div class='tb tb-header col-4'>
            DESCRIÇÃO 
        </div>
        <div class='tb tb-header col-1'>
            CONCLUSÃO
        </div>
        <div class='tb tb-header col-1'>
            PRIORIDADE
        </div>
        <div class='tb tb-header col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($tasksSales as $task)
    <div class='row'>
        <div class='tb col-2'>
            <button class='button-round'>
                <a href=' {{route('task.show', ['task' => $task->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i>
                </a>
            </button>
            {{date('d/m/Y', strtotime($task->date_start))}}
        </div>
        <div class='tb col-3'>
            {{$task->name}}
        </div>
        <div class='tb col-4'>
            {!!html_entity_decode($task->description)!!}
        </div>
        <div class='tb col-1'>
            @isset($task->date_conclusion)
            {{date('d/m/Y', strtotime($task->date_conclusion))}}
            @else
            em aberto
            @endisset
        </div>
        {{formatPriority($task)}}
        @if($task->status == 'fazer' AND $task->journeys()->exists())
        <div class='tb tb-doing col-1'>
            fazendo
        </div>
        @elseif($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
        <div class='tb tb-late col-1'>
            atrasada
        </div>
        @else
        {{formatStatus($task)}}
        @endif
    </div>
    @endforeach
    <div class='row mb-4'>
        <div class='tb tb-header col-11 justify-content-end'>
            TOTAL
        </div>
        <div class='tb tb-header col-1'>
            {{formatTotalHour($tasksSalesHours)}} horas
        </div>
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
            <img src='{{asset('images/invoice.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >PROPOSTAS</label>
        </div>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-right-style: solid;
             border-right-width: 1px;
             border-radius: 0px 7px 0px 0px;
             border-color: #c28dbf
             '>
              <form  style='display: inline-block;float: right' method='get' action='{{route('proposal.create')}}'>
                @csrf

                <input type='hidden' name='typeInvoices' value='receita'>
                <input type='hidden' name='opportunityName' value='{{$opportunity->name}}'>
                <input type='hidden' name='opportunityId' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunityDescription' value='{{$opportunity->description}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='opportunityCompanyName' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='opportunityCompanyId' value='{{$opportunity->company->id}}'>
                @endif
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                <input type='hidden' name='department' value='vendas'>
                <input type='hidden' name='invoiceStatus' value='orçamento'>
                <input class='text-button secondary' type='submit' value='GERAR PROPOSTA'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-1 tb tb-header'>
            ID
        </div>
        <div class='col-3 tb tb-header'>
            CRIAÇÃO 
        </div>
        <div class='col-3 tb tb-header'>
            VENCIMENTO
        </div>
        <div class='col-2 tb tb-header'>
            A RECEBER
        </div>
        <div class='col-2 tb tb-header'>
            VALOR DA FATURA
        </div>
        <div class='tb tb-header col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($proposals as $proposal)
    <div class='row'>
        <div class='tb col-1'>
            <button class='button-round'>
                <a href=' {{route('proposal.show', ['proposal' => $proposal->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{$proposal->identifier}}
        </div>
        <div class='tb col-3'>
            {{date('d/m/Y', strtotime($proposal->date_creation))}}
        </div>
        @if($proposal->status == 'aprovada' AND $proposal->paid == 0 AND $proposal->pay_day < date('Y-m-d'))
        <div class='tb col-3'>
            {{date('d/m/Y', strtotime($proposal->pay_day))}}
        </div>
        @else
        <div class='tb col-3'>
            {{date('d/m/Y', strtotime($proposal->pay_day))}}
        </div>
        @endif
        <div class='tb col-2 justify-content-end''>
            {{formatCurrencyReal($proposal->balance)}}
        </div>
        <div class='tb col-2 justify-content-end''>
            {{formatCurrencyReal($proposal->installment_value)}}
        </div>
        {{formatInvoiceStatus($proposal)}}
    </div>
    @endforeach
    <div class='row mb-4'>
        <div class='tb tb-header col-7 justify-content-end'>
        </div>

        <div class='tb tb-header col-2 justify-content-end'>
            Pago:  {{formatCurrencyReal($balanceTotal)}}
        </div>
        <div class='tb tb-header col-1'>
        </div>
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
            <form  style='display: inline-block;float: right' action='{{route('task.create')}}' method='post'>
                @csrf
                <input type='hidden' name='task_name' value='FAZER ORÇAMENTO:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='company_name' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='company_id' value='{{$opportunity->company->id}}'>
                @endif

                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>

                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value='FAZER ORÇAMENTO'>
            </form>
            <form  style='display: inline-block;float: right' method='POST' action='{{route('invoice.create')}}'>
                @csrf
                @method('post')
                <input type='hidden' name='typeInvoices' value='receita'>
                <input type='hidden' name='opportunityName' value='{{$opportunity->name}}'>
                <input type='hidden' name='opportunityId' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunityDescription' value='{{$opportunity->description}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='opportunityCompanyName' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='opportunityCompanyId' value='{{$opportunity->company->id}}'>
                @endif
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                <input type='hidden' name='department' value='vendas'>
                <input type='hidden' name='invoiceStatus' value='orçamento'>
                <input class='text-button secondary' type='submit' value='GERAR ORÇAMENTO'>
            </form>
            <form  style='display: inline-block;float: right'  method='POST' action='{{route('invoice.create')}}'>
                @csrf
                @method('post')
                <input type='hidden' name='typeInvoices' value='receita'>
                <input type='hidden' name='opportunityName' value='{{$opportunity->name}}'>
                <input type='hidden' name='opportunityId' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunityDescription' value='{{$opportunity->description}}'>
                <input type='hidden' name='opportunityAccountName' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='opportunityAccountId' value='{{$opportunity->account->id}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='opportunityCompanyName' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='opportunityCompanyId' value='{{$opportunity->company->id}}'>
                @endif
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value='GERAR FATURA'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-1 tb tb-header'>
            ID
        </div>
        <div class='col-3 tb tb-header'>
            CRIAÇÃO 
        </div>
        <div class='col-3 tb tb-header'>
            VENCIMENTO
        </div>
        <div class='col-2 tb tb-header'>
            A RECEBER
        </div>
        <div class='col-2 tb tb-header'>
            VALOR DA FATURA
        </div>
        <div class='tb tb-header col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($invoices as $invoice)
    <div class='row'>
        <div class='tb col-1'>
            <button class='button-round'>
                <a href=' {{route('invoice.show', ['invoice' => $invoice->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{$invoice->identifier}}
        </div>
        <div class='tb col-3'>
            {{date('d/m/Y', strtotime($invoice->date_creation))}}
        </div>
        @if($invoice->status == 'aprovada' AND $invoice->paid == 0 AND $invoice->pay_day < date('Y-m-d'))
        <div class='tb col-3'>
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </div>
        @else
        <div class='tb col-3'>
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </div>
        @endif
        <div class='tb col-2 justify-content-end''>
            {{formatCurrencyReal($invoice->balance)}}
        </div>
        <div class='tb col-2 justify-content-end''>
            {{formatCurrencyReal($invoice->installment_value)}}
        </div>
        {{formatInvoiceStatus($invoice)}}
    </div>
    @foreach($invoice->transactions as $transaction)
    <div class='row'>
        <div class='tb col-1' style='background-color: #d8c2db'>
            <button class='button-round'>
                <a href=' {{route('transaction.show', ['transaction' => $transaction->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i>
                </a>
            </button>
            {{$transaction->id}}
        </div>
        <div class='tb col-3' style='background-color: #d8c2db'>
            {{$transaction->pay_day}}
        </div>
        <div class='tb col-3' style='background-color: #d8c2db'>
            {{$transaction->bankAccount->name}}
        </div>
        <div class='tb col-2' style='background-color: #d8c2db'>
            {{$transaction->observations}}
        </div>
        <div class='tb col-2 justify-content-end' style='background-color: #d8c2db'>
            {{formatCurrencyReal($transaction->value)}}
        </div>
        <div class='tb col-1' style='background-color: #d8c2db'>
        </div>
    </div>
    @endforeach
    @endforeach
    <div class='row mb-4'>
        <div class='tb tb-header col-7 justify-content-end'>
        </div>
        <div class='tb tb-header col-2 justify-content-end'>
            Falta receber:  {{formatCurrencyReal($invoicePaymentsTotal)}}
        </div>
        <div class='tb tb-header col-2 justify-content-end'>
            Pago:  {{formatCurrencyReal($balanceTotal)}}
        </div>
        <div class='tb tb-header col-1'>
        </div>
    </div>


    <div class='row mt-5'>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-left-style: solid;
             border-left-width: 1px;
             border-radius: 7px 0px 0px 0px;
             border-color: #c28dbf
             '>
            <img src='{{asset('images/contract.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >CONTRATOS</label>
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
                <input type='hidden' name='task_name' value='CONTRATO:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='company_name' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='company_id' value='{{$opportunity->company->id}}'>
                @endif
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value='  FAZER CONTRATO'>
            </form>
            <form style='display: inline-block;float: right' action='{{route('contract.create')}}' method='post'>
                @csrf
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                <input type='hidden' name='opportunity_description' value='{{$opportunity->description}}'>
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
                <input type='hidden' name='company_names' value='{{$contactCompanies}}'>
                <input type='hidden' name='company_ids' value='{{$contactCompanies}}'>
                <input type='hidden' name='department' value='vendas'>
                <input type='hidden' name='status' value='pendente'>
                <input class='text-button secondary' type='submit' value='  GERAR CONTRATO'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-1 tb tb-header'>
            ID
        </div>
        <div class='col-2 tb tb-header'>
            TÍTULO
        </div>
        <div class='col-2 tb tb-header'>
            CONTRATADA
        </div>
        <div class='col-2 tb tb-header'>
            CONTRATANTE
        </div>
        <div class='col-2 tb tb-header'>
            RESPONSÁVEL
        </div>
        <div class='col-1 tb tb-header'>
            ÍNICIO
        </div>
        <div class='col-1 tb tb-header'>
            VENCIMENTO
        </div>
        <div class='col-1 tb tb-header'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($contracts as $contract)
    <div class='row mb-5'>
        <div class='tb col-2'>
            <button class='button-round'>
                <a href=' {{route('contract.show', ['contract' => $contract->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{$contract->identifier}}
        </div>
        <div class='tb col-2'>
            {{$contract->name}}
        </div>
        <div class='tb col-2'>
            {{$contract->account->name}}
        </div>
        <div class='tb col-2'>
            {{$contract->company->name}}
        </div>
        <div class='tb col-2'>
            {{$contract->contact->name}}
        </div>
        <div class='tb col-2'>
            {{date('d/m/Y', strtotime($contract->date_start))}}
        </div>
        <div class='tb col-2'>
            {{date('d/m/Y', strtotime($contract->date_due))}}
        </div>
        {{formatInvoiceStatus($contract)}}
    </div>
    @endforeach


    <div class='row mt-5'>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-left-style: solid;
             border-left-width: 1px;
             border-radius: 7px 0px 0px 0px;
             border-color: #c28dbf
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
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='department' value='produção'>
                <input class='text-button secondary' type='submit' value='SOLICITAR  PRODUÇÃO'>
            </form>
            <form  style='display: inline-block;float: right'  action='{{route('task.create')}}' method='post'>
                @csrf
                <input type='hidden' name='task_name' value='ENTREGAR:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value=' REALIZAR ENTREGA'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-2 tb tb-header'>
            CRIAÇÃO 
        </div>
        <div class='col-3 tb tb-header'>
            TAREFA 
        </div>
        <div class='col-4 tb tb-header'>
            DESCRIÇÃO 
        </div>
        <div class='col-1 tb tb-header'>
            CONCLUSÃO
        </div>
        <div class='col-1 tb tb-header'>
            PRIORIDADE
        </div>
        <div class='col-1 tb tb-header'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($tasksOperational as $task)
    <div class='row'>
        <div class='tb col-2'>
            <button class='button-round'>
                <a href=' {{ route('task.show', ['task' => $task->id]) }}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{date('d/m/Y', strtotime($task->date_start))}}
        </div>
        <div class='tb col-3'>
            {{$task->name}}
        </div>
        <div class='tb col-4'>
            {!!html_entity_decode($task->description)!!}
        </div>
        <div class='tb col-1'>
            @isset($task->date_conclusion)
            {{date('d/m/Y', strtotime($task->date_conclusion))}}
            @else
            em aberto
            @endisset
        </div>
        {{formatPriority($task)}}

        {{formatStatus($task)}}
    </div>
    @endforeach
    <div class='row mb-4'>
        <div class='tb tb-header col-11 justify-content-end'>
            TOTAL:
        </div>
        <div class='tb tb-header col-1'>
            {{formatTotalHour($tasksOperationalHours)}} horas
        </div>
    </div>


    <div class='row mt-5'>
        <div class='col-6 pt-4 pb-3' style='
             border-top-style: solid;
             border-top-width: 1px;
             border-left-style: solid;
             border-left-width: 1px;
             border-radius: 7px 0px 0px 0px;
             border-color: #c28dbf
             '>
            <img src='{{asset('images/customer-service.png')}}' width='25px' height='25px'>
            <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >ATENDIMENTO</label>
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
                <input type='hidden' name='task_name' value='ATENDIMENTO:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if(isset($opportunity->company))
                <input type='hidden' name='company_name' value='{{$opportunity->company->name}}'>
                <input type='hidden' name='company_id' value='{{$opportunity->company->id}}'>
                @endif
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='department' value='atendimento'>
                <input class='text-button secondary' type='submit' value='REGISTRAR ATENDIMENTO'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-2 tb tb-header'>
            CRIAÇÃO 
        </div>
        <div class='col-2 tb tb-header'>
            TAREFA 
        </div>
        <div class='col-3 tb tb-header'>
            DESCRIÇÃO 
        </div>
        <div class='col-2 tb tb-header'>
            CONCLUSÃO
        </div>
        <div class='col-2 tb tb-header'>
            PRIORIDADE
        </div>
        <div class='tb tb-header col-1'>
            SITUAÇÃO
        </div>
    </div>

    @foreach ($tasksCustomerServices as $task)
    <div class='row'>
        <div class='tb col-2'>
            <button class='button-round'>
                <a href=' {{route('task.show', ['task' => $task->id])}}'>
                    <i class='fa fa-eye' style='color:white'></i></a>
            </button>
            {{date('d/m/Y', strtotime($task->date_start))}}
        </div>
        <div class='tb col-2'>
            {{$task->name}}
        </div>
        <div class='tb col-2'>
            {!!html_entity_decode($task->description)!!}
        </div>
        <div class='tb col-2'>
            @isset($task->date_conclusion)
            {{date('d/m/Y', strtotime($task->date_conclusion))}}
            @else
            em aberto
            @endisset
        </div>
        {{formatPriority($task)}}

        @if($task->status == 'fazer' AND $task->journeys()->exists())
        <div class='tb col-2'>
            andamento
        </div>
        @elseif($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
        <div class='tb col-2'>
            atrasada
        </div>
        @else
        {{formatStatus($task)}}
        @endif
    </div>
    @endforeach
    <div class='row'>
        <div class='tb tb-header col-11 justify-content-end'>
            TOTAL:
        </div>
        <div class='tb tb-header col-1'>
            {{formatTotalHour($tasksCustomerServicesHours)}} horas
        </div>
    </div>
    @endsection

    @section('deleteButton')
    {{createButtonTrash($opportunity, 'opportunity')}}
    @endsection

    @section('editButton', route('opportunity.edit', ['opportunity' => $opportunity->id]))

    @section('backButton', route('opportunity.index'))

    @section('createdAt')
    <div class='row' style='margin-top: 30px'>
        <div class='col-12'style='padding-top: -10px'>
            Primeiro registro em: {{date('d/m/Y H:i', strtotime($opportunity->created_at))}}
        </div>
    </div>
    @endsection


    @section('js-scripts')
    @endsection
