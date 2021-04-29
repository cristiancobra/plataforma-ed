@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{asset('imagens/financeiro.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('opportunity.index')}}">
    <i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('main')
<br>
<h1 class='name'>
    {{$opportunity->name}}
</h1>
<label class='labels' for='' >CONTA: </label>
<span class='fields'>{{$opportunity->account->name}}</span>
<br>
<label class='labels' for='' >RESPONSÁVEL: </label>
<span class='fields'>{{$opportunity->user->contact->name}}</span>
<br>
<br>
<label class='labels' for='' >EMPRESA: </label>
@if(isset($opportunity->company->name))
<span class='fields'>  {{$opportunity->company->name}}</span>
@else
<span class='fields'> Pessoa física</span>
@endif
<br>
<label class='labels' for='' >CONTATO: </label>
@if(isset($opportunity->contact->name))
<span class='fields'>  {{$opportunity->contact->name}}</span>
@else
<span class='fields'> não possui</span>
@endif
<br>
<br>
<label class='labels' for='' >DATA DE CRIAÇÃO:</label>
@if($opportunity->date_start == null)
indefinida
@else
<span class='fields'>{{date('d/m/Y', strtotime($opportunity->date_start))}}</span>
@endif
<br>
<label class='labels' for='' >PRÓXIMO CONTATO:</label>
@if($opportunity->pay_day == null)
indefinida
@else
<span class='fields'>{{date('d/m/Y', strtotime($opportunity->pay_day))}}</span>
@endif
<br>
<br>
<div style='background-color: #d7bde2 ;padding: 1%'>
    <label class='labels' for='' >ETAPA DA VENDA:</label>
    <span class='fields'>{{$opportunity->stage}}</span>
    <br>
    <label class='labels' for='' >PRÓXIMO CONTATO:</label>
    @if($opportunity->date_conclusion == null)
    indefinido
    @else
    <span class='fields'>{{date('d/m/Y', strtotime($opportunity->date_conclusion))}}</span>
    @endif
</div>
<br>
<label class='labels' for='' >DESCRIÇÃO:</label>
<span class='fields'>{!!html_entity_decode($opportunity->description)!!}</span>
<br>
<br>
<div style='display: inline-block'>
    <img src='{{asset('imagens/tarefas.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >VENDAS:</label>
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

    @foreach ($tasksSales as $task)
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
            {{formatTotalHour($tasksSalesHours)}} horas
        </td>
    </tr>
</table>
<br>
<div id='tarefas' style='text-align:right'>
    <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
        @csrf
        <input type='hidden' name='task_name' value='Enviar material'>
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
    <form  style='display: inline-block' action='{{route('task.create')}}' method='post'>
        @csrf
        <input type='hidden' name='task_name' value='Reunião'>
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
<br>
<br>
<div style='display: inline-block'>
    <img src='{{asset('imagens/invoice.png')}}' width='40px' alt='40px'>
    <label class='labels' for='' >FATURAS:</label>
</div>
<br>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header' style='width: 20%'>
            IDENTIFICADOR
        </td>
        <td   class='table-list-header' style='width: 20%'>
            DATA CRIAÇÃO 
        </td>
        <td   class='table-list-header' style='width: 20%'>
            DATA PAGAMENTO
        </td>
        <td   class='table-list-header' style='width: 15%'>
            VALOR TOTAL
        </td>
        <td   class='table-list-header' style='width: 15%'>
            VALOR DA PARCELA
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
        @if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
        <td class="table-list-center" style="color: red">
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </td>
        @else
        <td class="table-list-center">
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </td>
        @endif
        <td class='table-list-right'>
            {{formatCurrencyReal($invoice->totalPrice)}}
        </td>
        <td class='table-list-right'>
            {{formatCurrencyReal($invoice->installment_value)}}
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
        <td   class="table-list-header-right" colspan="5">
            VALOR TOTAL: 
        </td>
        </td>
        <td   class="table-list-header-right" colspan="1">
            {{formatCurrencyReal($invoiceInstallmentsTotal)}}
        </td>
    </tr>
    <tr>
        <td   class="table-list-header-right" colspan="5">
            PAGO: 
        </td>
        </td>
        <td   class="table-list-header-right" colspan="1">
            {{formatCurrencyReal($invoicePaymentsTotal)}}
        </td>
    </tr>
    <tr>
        <td   class="table-list-header-right"colspan="5">
            SALDO:
        </td>
        </td>
        <td   class="table-list-header-right" colspan="1">
            {{formatCurrencyReal($balance)}}
        </td>
    </tr>
</table>
<br>
<div id='faturas' style='text-align:right'>
    <form  style='display: inline-block' action='{{route('task.create')}}' method='post'>
        @csrf
        <input type='hidden' name='task_name' value='Fazer proposta'>
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
        <input class='text-button secondary' type='submit' value='  FAZER ORÇAMENTO'>
    </form>
    <form  style='display: inline-block' method='POST' action='{{route('invoice.create')}}'>
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
        <input type='hidden' name='department' value='vendas'>
        <input class='text-button secondary' type='submit' value='GERAR FATURA'>
    </form>
</div>
<br>
<br>
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
<br>
<div id='contratos' style='text-align:right'>
    <form  style='display: inline-block'  action='{{route('task.create')}}' method='post'>
        @csrf
        <input type='hidden' name='task_name' value='FAZER CONTRATO:'>
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
<br>
<br>
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
<br>
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
<br>
<br>
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
<br>
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
<br>
<br>
<br>
<br>
<p class='labels'>  Criado em:   {{date('d/m/Y H:i', strtotime($opportunity->created_at))}} </p>

<div style='text-align:right'>
    @if($opportunity->trash == 1)
    <form id="button-delete"  style="text-decoration: none;display: inline-block" action="{{route('opportunity.destroy', ['opportunity' => $opportunity])}}" method="post">
        @csrf
        @method('delete')
        <button class='circular-button delete' onclick="return confirmDelete()" style='border: none;padding-left: 8px;padding-bottom: 5px' type='submit'>
            <i class='fa fa-times'></i>
        </button>
    </form>
    @else
    <a class='circular-button delete' href='{{route('opportunity.trash', ['opportunity' => $opportunity->id])}}'>
        <i class='fas fa-trash'></i>
    </a>
    @endif
    <a class='circular-button secondary' href=' {{route('opportunity.edit', ['opportunity' => $opportunity->id])}}' style='text-decoration: none;display: inline-block'>
        <i class='fa fa-edit'></i>
    </a>
    <a class='circular-button primary' href='{{route('opportunity.index')}}'>
        <i class='fas fa-arrow-left'></i>
    </a>
</div>
<br>
<br>
@endsection

@section('js-scripts')
@endsection
