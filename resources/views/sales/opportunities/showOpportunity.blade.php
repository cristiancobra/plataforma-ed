@extends('layouts/show')

@section('title','OPORTUNIDADES')

@section('image-top')
{{asset('imagens/financeiro.png')}}
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('opportunity')}}
@endsection

@section('name', $opportunity->name)

@section('priority')
{{formatShowStage($opportunity->stage)}}
@endsection

@section('status')
{{formatShowOpportunityStatus($opportunity->status)}}
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
        @if(isset($task->user->contact->name))
        {{$opportunity->user->contact->name}}
        @else
        foi excluído
        @endif
    </div>
    @endsection

    @section('date_start')
    <div class="circle-date-start">
        @if($opportunity->date_start == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($opportunity->date_start))}}
        @endif
    </div>
    <p class="labels" style="text-align: center">
        CRIAÇÃO
    </p>
    @endsection


    @section('date_due')    
    <div class="circle-date-due">
        @if($opportunity->pay_day == null)
        indefinida
        @else
        {{date('d/m/Y', strtotime($opportunity->pay_day))}}
        @endif
    </div>
    <p class="labels" style="text-align: center">
        PRÓXIMO CONTATO
    </p>
    @endsection


    @section('date_conclusion')
    <div class="circle-date-conclusion">
        @if($opportunity->date_conclusion == null)
        --
        @else
        <p style="color:white">
            {{date('d/m/Y', strtotime($opportunity->date_conclusion))}}
        </p>
        @endif
    </div>
    <p class="labels" style="text-align: center">
        CONCLUSÃO
    </p>
    @endsection


    @section('description')
    {!!html_entity_decode($opportunity->description)!!}
    @endsection





    @section('execution')
    <div class='row'>
        <div class='col-6 pt-3 pb-2' style="
             border-left-style: solid;
             border-left-width: 1px;
             border-color: #c28dbf
             ">
            <img src='{{asset('imagens/tarefas.png')}}' width='25px' alt='25px'>
            <label class='labels' style="font-size: 22px;padding-left: 5px" for='' >VENDAS</label>
        </div>
        <div class='col-6 pt-2 pb-2' style="
             border-right-style: solid;
             border-right-width: 1px;
             border-color: #c28dbf
             ">
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
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
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
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value='AGENDAR REUNIÃO'>
            </form>
        </div>
    </div>
    <div class='row'>
        <div class='col-2 tb tb-header'>
            DATA CRIAÇÃO 
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
    <div class='row'>
        <div class='tb tb-header col-11 justify-content-right'>
            TOTAL:
        </div>
        <div class='tb tb-header col-1'>
            {{formatTotalHour($tasksSalesHours)}} horas
        </div>
    </div>
    <div class='row mb-5 mt-3'>
        <div id='tarefas' style='text-align:right'>

        </div>
    </div>
       <div class='row'>
        <div class='col-6 pt-3 pb-2' style="
             border-left-style: solid;
             border-left-width: 1px;
             border-color: #c28dbf
             ">
            <img src='{{asset('imagens/invoice.png')}}' width='25px' alt='25px'>
            <label class='labels' style="font-size: 22px;padding-left: 5px" for='' >FINANCEIRO</label>
        </div>
        <div class='col-6 pt-2 pb-2' style="
             border-right-style: solid;
             border-right-width: 1px;
             border-color: #c28dbf
             ">
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

                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
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
                <input type='hidden' name='opportunityAccountName' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='opportunityAccountId' value='{{$opportunity->account->id}}'>
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
            <form  style='display: inline-block'  method='POST' action='{{route('invoice.create')}}'>
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
    <table class='table-list'>
        <tr>
            <td   class='table-list-header' style='width: 5%'>
                IDENTIFICADOR
            </td>
            <td   class='table-list-header' style='width: 20%'>
                DATA CRIAÇÃO 
            </td>
            <td   class='table-list-header' style='width: 20%'>
                DATA PAGAMENTO
            </td>
            <td   class='table-list-header' style='width: 15%'>
                VALOR DA FATURA
            </td>
            <td   class='table-list-header' style='width: 15%'>
                PAGO
            </td>
            <td   class='table-list-header' style='width: 15%'>
                A RECEBER
            </td>
            <td   class='table-list-header' style='width: 10%'>
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($invoices as $invoice)
        <tr style='font-size: 14px'>
            <td class='table-list-left'>
                <button class='button-round'>
                    <a href=' {{route('invoice.show', ['invoice' => $invoice->id])}}'>
                        <i class='fa fa-eye' style='color:white'></i></a>
                </button>
                {{$invoice->identifier}}
            </td>
            <td class='table-list-center'>
                {{date('d/m/Y', strtotime($invoice->date_creation))}}
            </td>
            @if($invoice->status == 'aprovada' AND $invoice->paid == 0 AND $invoice->pay_day < date('Y-m-d'))
            <td class="table-list-center" style="color: red">
                {{date('d/m/Y', strtotime($invoice->pay_day))}}
            </td>
            @else
            <td class="table-list-center">
                {{date('d/m/Y', strtotime($invoice->pay_day))}}
            </td>
            @endif
            <td class='table-list-right'>
                {{formatCurrencyReal($invoice->installment_value)}}
            </td>
            <td class='table-list-right'>
                {{formatCurrencyReal($invoice->paid)}}
            </td>
            <td class='table-list-right'>
                {{formatCurrencyReal($invoice->installment_value - $invoice->paid)}}
            </td>
            @if($invoice->paid >= $invoice->installment_value)
            <td class="td-paid">
                paga
            </td>
            @elseif($invoice->paid > 0 AND $invoice->paid <= $invoice->installment_value)
            <td class="td-paid-partial">
                parcial
            </td>
            @else
            {{formatInvoiceStatus($invoice)}}
            @endif
        </tr>
        @endforeach
        <tr>
            <td   class="table-list-header-right" colspan="3">
                TOTAIS: 
            </td>
            <td   class="table-list-header-right" colspan="1">
                {{formatCurrencyReal($invoiceInstallmentsTotal)}}
            </td>

            </td>
            <td   class="table-list-header-right" colspan="1">
                {{formatCurrencyReal($invoicePaymentsTotal)}}
            </td>

            </td>
            <td   class="table-list-header-right" colspan="1">
                {{formatCurrencyReal($balance)}}
            </td>
            <td   class="table-list-header-right" colspan="1">
            </td>
        </tr>
    </table>

    <div style='display: inline-block'>
        <img src='{{asset('imagens/contract.png')}}' width='40px' alt='40px'>
        <label class='labels' for='' >CONTRATOS:</label>
    </div>
    <br>
    <br>
    <table class='table-list'>
        <tr>
            <td   class='table-list-header' style='width: 5%'>
                IDENTIFICADOR
            </td>
            <td   class='table-list-header' style='width: 20%'>
                TÍTULO
            </td>
            <td   class='table-list-header' style='width: 15%'>
                CONTRATADA
            </td>
            <td   class='table-list-header' style='width: 15%'>
                CONTRATANTE
            </td>
            <td   class='table-list-header' style='width: 15%'>
                RESPONSÁVEL
            </td>
            <td   class='table-list-header' style='width: 10%'>
                DATA DE ÍNICIO
            </td>
            <td   class='table-list-header' style='width: 10%'>
                DATA DE VENCIMENTO
            </td>
            <td   class='table-list-header' style='width: 10%'>
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($contracts as $contract)
        <tr style='font-size: 14px'>
            <td class='table-list-left'>
                <button class='button-round'>
                    <a href=' {{route('contract.show', ['contract' => $contract->id])}}'>
                        <i class='fa fa-eye' style='color:white'></i></a>
                </button>
                {{$contract->identifier}}
            </td>
            <td class='table-list-center'>
                {{$contract->name}}
            </td>
            <td class='table-list-center'>
                {{$contract->account->name}}
            </td>
            <td class='table-list-center'>
                {{$contract->company->name}}
            </td>
            <td class='table-list-center'>
                {{$contract->contact->name}}
            </td>
            <td class='table-list-center'>
                {{date('d/m/Y', strtotime($contract->date_start))}}
            </td>
            <td class='table-list-center'>
                {{date('d/m/Y', strtotime($contract->date_due))}}
            </td>
            {{formatInvoiceStatus($contract)}}
        </tr>
        @endforeach
    </table>
    <div class='row mb-5 mt-3'>
        <div id='contratos' style='text-align:right'>
            <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
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
            <form style='display: inline-block' action='{{route('contract.create')}}' method='post'>
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
    <div style='display: inline-block'>
        <img src='{{asset('imagens/production.png')}}' width='40px' alt='40px'>
        <label class='labels' for='' >PRODUÇÃO:</label>
    </div>
    <br>
    <br>
    <table class='table-list'>
        <tr>
            <td   class='table-list-header' style='width: 20%'>
                DATA CRIAÇÃO 
            </td>
            <td   class='table-list-header' style='width: 20%'>
                TAREFA 
            </td>
            <td   class='table-list-header' style='width: 35%'>
                DESCRIÇÃO 
            </td>
            <td   class='table-list-header' style='width: 5%'>
                CONCLUSÃO
            </td>
            <td   class='table-list-header' style='width: 5%'>
                PRIORIDADE
            </td>
            <td   class='table-list-header' style='width: 5%'>
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($tasksOperational as $task)
        <tr style='font-size: 14px'>
            <td class='table-list-left'>
                <button class='button-round'>
                    <a href=' {{ route('task.show', ['task' => $task->id]) }}'>
                        <i class='fa fa-eye' style='color:white'></i></a>
                </button>
                {{date('d/m/Y', strtotime($task->date_start))}}
            </td>
            <td class='table-list-left'>
                {{$task->name}}
            </td>
            <td class='table-list-left'>
                {!!html_entity_decode($task->description)!!}
            </td>
            <td class='table-list-center'>
                @isset($task->date_conclusion)
                {{date('d/m/Y', strtotime($task->date_conclusion))}}
                @else
                em aberto
                @endisset
            </td>
            {{formatPriority($task)}}

            @if($task->status == 'fazer' AND $task->journeys()->exists())
            <td class='td-doing'>
                andamento
            </td>
            @elseif($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
            <td class='td-late'>
                atrasada
            </td>
            @else
            {{formatStatus($task)}}
            @endif
        </tr>
        @endforeach
        <tr>
            <td   class="table-list-header-right"colspan="5">
                TOTAL:
            </td>
            <td   class="table-list-header-right" colspan="1">
                {{formatTotalHour($tasksOperationalHours)}} horas
            </td>
        </tr>
    </table>
    <div class='row mb-5 mt-3'>
        <div id='produção' style='text-align:right'>
            <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
                @csrf
                <input type='hidden' name='task_name' value='PRODUZIR:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
                <input type='hidden' name='department' value='produção'>
                <input class='text-button secondary' type='submit' value='SOLICITAR  PRODUÇÃO'>
            </form>
            <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
                @csrf
                <input type='hidden' name='task_name' value='ENTREGAR:'>
                <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
                <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
                @if($opportunity->contact)
                <input type='hidden' name='contact_name' value='{{$opportunity->contact->name}}'>
                <input type='hidden' name='contact_id' value='{{$opportunity->contact->id}}'>
                @endif
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
                <input type='hidden' name='department' value='vendas'>
                <input class='text-button secondary' type='submit' value=' REALIZAR ENTREGA'>
            </form>
        </div>
    </div>
    <div style='display: inline-block'>
        <img src='{{asset('imagens/customer-service.png')}}' width='40px' alt='40px'>
        <label class='labels' for='' >ATENDIMENTO:</label>
    </div>
    <br>
    <br>
    <table class='table-list'>
        <tr>
            <td   class='table-list-header' style='width: 20%'>
                DATA CRIAÇÃO 
            </td>
            <td   class='table-list-header' style='width: 20%'>
                TAREFA 
            </td>
            <td   class='table-list-header' style='width: 35%'>
                DESCRIÇÃO 
            </td>
            <td   class='table-list-header' style='width: 5%'>
                CONCLUSÃO
            </td>
            <td   class='table-list-header' style='width: 5%'>
                PRIORIDADE
            </td>
            <td   class='table-list-header' style='width: 5%'>
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($tasksCustomerServices as $task)
        <tr style='font-size: 14px'>
            <td class='table-list-left'>
                <button class='button-round'>
                    <a href=' {{route('task.show', ['task' => $task->id])}}'>
                        <i class='fa fa-eye' style='color:white'></i></a>
                </button>
                {{date('d/m/Y', strtotime($task->date_start))}}
            </td>
            <td class='table-list-left'>
                {{$task->name}}
            </td>
            <td class='table-list-left'>
                {!!html_entity_decode($task->description)!!}
            </td>
            <td class='table-list-center'>
                @isset($task->date_conclusion)
                {{date('d/m/Y', strtotime($task->date_conclusion))}}
                @else
                em aberto
                @endisset
            </td>
            {{formatPriority($task)}}

            @if($task->status == 'fazer' AND $task->journeys()->exists())
            <td class='td-doing'>
                andamento
            </td>
            @elseif($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
            <td class='td-late'>
                atrasada
            </td>
            @else
            {{formatStatus($task)}}
            @endif
        </tr>
        @endforeach
        <tr>
            <td   class="table-list-header-right"colspan="5">
                TOTAL:
            </td>
            <td   class="table-list-header-right" colspan="1">
                {{formatTotalHour($tasksCustomerServicesHours)}} horas
            </td>
        </tr>
    </table>
    <div class='row mb-5 mt-3'>
        <div id='tarefas' style='text-align:right'>
            <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
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
                <input type='hidden' name='account_name' value='{{$opportunity->account->name}}'>
                <input type='hidden' name='account_id' value='{{$opportunity->account->id}}'>
                <input type='hidden' name='department' value='atendimento'>
                <input class='text-button secondary' type='submit' value='REGISTRAR ATENDIMENTO'>
            </form>
        </div>
    </div>
    @endsection

    @section('deleteButton')
    @if($opportunity->trash != 1)
    {{route('opportunity.destroy', ['opportunity' => $opportunity])}}
    @else
    {{route('opportunity.trash', ['opportunity' => $opportunity->id])}}
    @endif
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
