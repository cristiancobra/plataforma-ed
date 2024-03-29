@extends('layouts/show')

@section('title', $title)

@section('image-top')
{{asset('images/financeiro.png')}}
@endsection

@section('buttons')
{{createButtonTrash($opportunity, 'opportunity')}}
{{createButtonEdit('opportunity', 'opportunity', $opportunity, 'department', $opportunity->department)}}
{{createButtonList('opportunity', 'department',  $opportunity->department)}}
@endsection

@section('name', $opportunity->name)


@section('status', $priority)


@section('status', $status)


@section('fieldsId')
<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        CONTATO
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    @if(empty($companyName))
    <div class='show-field-end'>
        Pessoa física
    </div>
    @else
    <a href='{{route('company.show', ['company' => $opportunity->company])}}'>
        <div class='show-field-end'>
            {{$companyName}}
        </div>
    </a>
    @endif

    @if($opportunity->contact)
    <a href='{{route('contact.show', ['contact' => $opportunity->contact])}}'>
        <div class='show-field-end'>
            {{$opportunity->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif
    
</div>

<div class='col-2 pe-0' style='text-align: center'>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-4 ps-0' style='text-align: center'>
    @if(isset($opportunity->user->contact->name))
    <a href='{{route('user.show', ['user' => $opportunity->user])}}'>
        <div class='show-field-end'>
            {{$opportunity->user->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        foi excluído
    </div>
</div>
@endif
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
    {{$dateDue}}
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
@if(Session::has('failed'))
<div class="alert alert-danger">
    {{Session::get('failed')}}
    @php
    Session::forget('failed');
    @endphp
</div>
@endif
<div class='row mt-5'>
    <div class='col-6 pt-4 pb-3' style='
         border-left-style: solid;
         border-top-style: solid;
         border-left-width: 1px;
         border-top-width: 1px;
         border-color: {{$principalColor}};
         border-radius: 10px 0 0 0;
         '>
        <img src='{{asset('images/vendas.png')}}' width='25px' height='25px'>
        <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >
            PROSPECÇÃO
        </label>
    </div>
    <div class='col-6 pt-4 pb-3' style='
         border-right-style: solid;
         border-top-style: solid;
         border-right-width: 1px;
         border-top-width: 1px;
         border-color: {{$principalColor}};
         border-radius: 0 10px 0 0;
         '>
        <form  style='display: inline-block;float: right'  action='{{route('task.create')}}' method='post'>
            @csrf
            <input type='hidden' name='task_name' value='ENVIAR MATERIAL:'>
            <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
            <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
            <input type='hidden' name='company_name' value='{{$companyName}}'>
            <input type='hidden' name='company_id' value='{{$companyId}}'>
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
            <input type='hidden' name='company_name' value='{{$companyName}}'>
            <input type='hidden' name='company_id' value='{{$companyId}}'>
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

    @empty($companyName)
    <a href='{{route('company.create')}}'>
        adicionar empresa
    </a>
    @else
    <i class='fas fa-store me-2'></i>
    <a href='{{route('company.edit', [
                                                                'company' => $opportunity->company,
                                                                 'typeCompanies' => 'cliente'
                                                                ])}}'>
        <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for='' >
            {{mb_strtoupper($companyName)}}
        </label>
    </a>
</div>
<div class='tb-row'>
    <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Proposta de valor: </label>
    @if(isset($opportunity->company->value_offer))
    {!!html_entity_decode($opportunity->company->value_offer)!!}
    @else
    --
    @endif
</div>
<div class='tb-row'>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Diferencial competitivo: </label>
        @if(isset($opportunity->company->competitive_advantage))
        {{$opportunity->company->competitive_advantage}}
        @else
        --
        @endif
    </div>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Modelo de negócio: </label>
        @if(isset($opportunity->company->business_model))
        {{$opportunity->company->business_model}}
        @else
        --
        @endif
    </div>
</div>

<div class='tb-row'>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Setor: </label>
        @if(isset($opportunity->company->sector))
        {{$opportunity->company->sector}}
        @else
        --
        @endif
    </div>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Funcionários: </label>
        <label class='labels' style='font-size: 15px;padding-top: 5px;margin-right: 3px' for='' >
            @if(isset($opportunity->company->employees))
            {{$opportunity->company->employees}}
            @else
            --
            @endif
        </label>
    </div>
</div>

<div class='tb-row'>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Clientes: </label>
        @if(isset($opportunity->company->client_number))
        {{$opportunity->company->client_number}}
        @else
        --
        @endif
    </div>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >Faturamento: </label>
        @if(isset($opportunity->company->revenues))
        {{$opportunity->company->revenues}}
        @else
        --
        @endif
    </div>
</div>
@endempty
</div>


<div class='tb-row pt-5'>
    <i class='fas fa-users me-2'></i>
    @if($opportunity->contact)
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
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >
            Email: 
        </label>
        @if($opportunity->contact)
        {{$opportunity->contact->name}}
        @else
        --
        @endif
    </div>
    <div class='col'>
        <label class='labels' style='font-size: 13px;padding-top: 5px;margin-right: 3px' for='' >
            Telefone: 
        </label>
        @if($opportunity->contact)
        {{$opportunity->contact->phone}}
        @else
        --
        @endif
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


<section class='container frame mt-5 p-3' id='invoices' style="border-color:{{$principalColor}}">
    <div class="row">
        <div class='col-11 pt-4 pb-3' style='font-size: 24px;padding-left: 5px;font-weight:600;color:{{$principalColor}}'>
            <i class="fa fa-receipt"></i>
            PROPOSTAS
        </div>
        <div class='col-1 pt-3 pb-3'>
            @if($proposalWon == 0)
            <a class='circular-button primary' style='display: inline-block;float: right' href='{{route('proposal.create', [
            'type' => 'receita',
            'opportunity' => $opportunity,
        ])}}'>
                <i class='fa fa-plus' aria-hidden='true'></i>
            </a>
            @else
            <div class='circular-button primary' style='display: inline-block;float: right'>
                <i class='fa fa-check' aria-hidden='true'></i>
                </>
            </div>
        </div>
        @endif
    </div>
    <div class='container p-3'>
    <div class='row table-header mt-3'>
        <div class='col-1'>
            ID
        </div>
        <div class='col-4'>
            NOME 
        </div>
        <div class='col-1'>
            CRIAÇÃO 
        </div>
        <div class='col-1'>
            VENCIMENTO
        </div>
        <div class='col-2'>
            RECEBER
        </div>
        <div class='col-2'>
            VALOR
        </div>
        <div class='col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($proposals as $proposal)
    <div class='row table2 position-relative'  style='
         color: {{$principalColor}};
         border-left-color: {{$complementaryColor}};
         background-color: white;
         '>
        <a class="stretched-link "href=' {{route('proposal.show', ['proposal' => $proposal->id])}}'>
        </a>
        <div class='cel col-1'>
            {{$proposal->identifier}}
        </div>
        <div class='cel col-4 justify-content-start'>
            {{$proposal->name}}
        </div>
        <div class='cel col-1'>
            {{date('d/m/Y', strtotime($proposal->date_creation))}}
        </div>
        @if($proposal->status == 'aprovada' AND $proposal->paid == 0 AND $proposal->pay_day < date('Y-m-d'))
        <div class='cel col-1'>
            {{date('d/m/Y', strtotime($proposal->pay_day))}}
        </div>
        @else
        <div class='cel col-1'>
            {{date('d/m/Y', strtotime($proposal->pay_day))}}
        </div>
        @endif
        <div class='cel col-2 justify-content-end''>
            {{formatCurrencyReal($proposal->balance)}}
        </div>
        <div class='cel col-2 justify-content-end''>
            {{formatCurrencyReal($proposal->totalPrice)}}
        </div>
        {{formatInvoiceStatus($proposal)}}
    </div>
    @endforeach
    </div>
</section>




<x-sections.invoices :proposal='$proposalApproved' />


<div class='row mt-5'>
    <div class='col-6 pt-4 pb-3' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-left-style: solid;
         border-left-width: 1px;
         border-radius: 7px 0px 0px 0px;
         border-color: {{$principalColor}}
         '>
        <img src='{{asset('images/contract.png')}}' width='25px' height='25px'>
        <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >
            CONTRATOS
        </label>
    </div>
    <div class='col-6 pt-4 pb-3' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-right-style: solid;
         border-right-width: 1px;
         border-radius: 0px 7px 0px 0px;
         border-color: {{$principalColor}}
         '>
        <form  style='display: inline-block;float: right'  action='{{route('task.create')}}' method='post'>
            @csrf
            <input type='hidden' name='task_name' value='CONTRATO:'>
            <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
            <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
            <input type='hidden' name='company_name' value='{{$companyName}}'>
            <input type='hidden' name='company_id' value='{{$companyId}}'>
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
         border-color: {{$principalColor}}
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
         border-color: {{$principalColor}}
         '>
        <form  style='display: inline-block;float: right'  action='{{route('task.create')}}' method='post'>
            @csrf
            <input type='hidden' name='task_name' value='PRODUZIR:'>
            <input type='hidden' name='opportunity_id' value='{{$opportunity->id}}'>
            <input type='hidden' name='opportunity_name' value='{{$opportunity->name}}'>
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
            <input type='hidden' name='department' value='produção'>
            <input class='text-button secondary' type='submit' value=' REALIZAR ENTREGA'>
        </form>
        <a class='text-button secondary'  style='display: inline-block;float: right'  href='{{route('opportunity.pdfProduction', ['opportunity' => $opportunity])}}'>
            RELATÓRIO PDF
        </a>
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
    <div class='tb-description col-4'>
        {!!html_entity_decode($task->description)!!}
    </div>

    {{formatDateDue($task)}}

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
         border-color: {{$principalColor}}
         '>
        <img src='{{asset('images/customer-service.png')}}' width='25px' height='25px'>
        <label class='labels' style='font-size: 24px;padding-left: 5px' for='' >
            ATENDIMENTO
        </label>
    </div>
    <div class='col-6 pt-4 pb-3' style='
         border-top-style: solid;
         border-top-width: 1px;
         border-right-style: solid;
         border-right-width: 1px;
         border-radius: 0px 7px 0px 0px;
         border-color: {{$principalColor}}
         '>
        <a class='circular-button primary' style='display: inline-block;float: right' href='{{route('task.create', ['opportunity' => $opportunity])}}'>
            <i class='fa fa-plus' aria-hidden='true'></i>
        </a>
    </div>
</div>
<div class='row'>
    <div class='col-1 tb tb-header'>
        CRIAÇÃO 
    </div>
    <div class='col-2 tb tb-header'>
        TAREFA 
    </div>
    <div class='col-4 tb tb-header'>
        DESCRIÇÃO 
    </div>
    <div class='col-2 tb tb-header'>
        RESPONSÁVEL
    </div>
    <div class='col-1 tb tb-header'>
        CONCLUSÃO
    </div>
    <div class='col-1 tb tb-header'>
        PRIORIDADE
    </div>
    <div class='tb tb-header col-1'>
        SITUAÇÃO
    </div>
</div>

@foreach ($tasksCustomerServices as $task)
<div class='row'>
    <div class='tb col-1'>
        <button class='button-round'>
            <a href=' {{route('task.show', ['task' => $task->id])}}'>
                <i class='fa fa-eye' style='color:white'></i></a>
        </button>
        {{date('d/m/Y', strtotime($task->date_start))}}
    </div>
    <div class='tb col-2'>
        {{$task->name}}
    </div>
    <div class='tb-description col-4'>
        {!!html_entity_decode($task->description)!!}
    </div>
    <div class='tb col-2'>
        @if(isset($task->user->image))
        <div class='profile-picture-small'>
            <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
                <img src='{{asset($task->user->image->path)}}' width='100%' height='100%'>
            </a>
        </div>
        @elseif($task->user->contact)
        <a  class='white' href=' {{route('user.show', ['user' => $task->user->id])}}'>
            {{$task->user->contact->name}}
        </a>
        @else
        funcionário excluído
        @endif
    </div>
    <div class='tb col-1'>
        @isset($task->date_conclusion)
        {{dateBr($task->date_conclusion)}}
        @else
        em aberto
        @endisset
    </div>
    {{formatPriority($task)}}

    {{formatStatus($task)}}
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
<script>
    // botão do filtro
    $(document).ready(function () {
    console.log('filter button')
            //botao de exibir filtro
//            $('#invoicePaymentButtonOnOff').click(function () {
//    $('#stageRow').slideToggle(600);
//    $('#buttonOnOff').toggleClass('plus minus');
//    });
//            $('#taskButtonOnOff').click(function () {
//    $('#taskRow').slideToggle(600);
//    });
//    @php
//            $counterJs = 1;
//    foreach($invoices as $invoice) {
//    echo "
//            $('#invoicePaymentButtonOnOff_$counterJs').click(function () {
//    $('#paymentRow_$counterJs').slideToggle(600);
//    });
//    ";
//            $counterJs++;
//    }
//    @endphp

    });
</script>
@endsection
