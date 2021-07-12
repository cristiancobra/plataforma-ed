@extends('layouts/master')

@section('title','MEU PAINEL')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
@if(isset($openJourney))
<a class='circular-button secondary'  href='{{route('journey.show', ['journey' => $openJourney])}}'>
    <i class="fas fa-step-forward" style="color:#8B2485"></i>
</a>
@endif
@if(isset($journey->task))
<a class='circular-button secondary'  href='{{route('journey.create', ['taskName' => $journey->task->name, 'taskId' => $journey->task_id])}}'>
    <i class="fas fa-mug-hot" style="color:#8B2485"></i>
</a>
@endif
<a class='circular-button secondary'  href='{{route('task.create')}}'>
    <i class="fas fa-calendar-check" style="color:#8B2485"></i>
</a>
@endsection

@section('main')
<div class='row mt-2 mb-3 ms-2 me-2'>

    <div class='col-2 text-center mx-auto mt-auto mb-auto'>
        <i class="fas fa-money-bill" style="font-size:42px; color:#8B2485"></i>
        <p class="mt-2" style="color:#8B2485">
            FINANCEIRO
        </p>
    </div>
    <div class='financial-display col-lg-3'>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/financial-planning.png')}}">
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                VENDIDO:
                <br>
                COMPROMETIDO:
                <br>
                SALDO:
            </p>
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                {{formatCurrency($estimatedRevenueMonthly)}}
                <br>
                {{formatCurrency($estimatedExpenseMonthly)}}
                <br>
                {{formatCurrency($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
        </div>
    </div>

    <div class='financial-display col-lg-3'>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/invoice.png')}}" style='width:100%'>
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                <a href='{{route('transaction.index')}}' style="color:white">
                    ENTRADAS:
                </a>
                <br>
                SAÍDAS:
                <br>
                SALDO:
            </p>
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                {{formatCurrency($revenueMonthly)}}
                <br>
                {{formatCurrency($expenseMonthly)}}
                <br>
                {{formatCurrency($revenueMonthly + $expenseMonthly)}}
            </p>
        </div>
    </div>

    <div class='financial-display col-lg-3'>
        <div style='display: inline-block;float: left;width: 20%'>
            <img class='financial-image' src="{{asset('images/financeiro.png')}}" style='width:100%'>
        </div>
        <div style='display: inline-block;float:left;width: 40%;padding-left: 10px'>
            <p style="color:white;font-size: 15px;text-align: left">
                @foreach($bankAccounts as $bankAccount)
                <a href="{{route('bankAccount.show', ['bankAccount' => $bankAccount])}}" style="color: white">
                    {{$bankAccount->name}}
                </a>
                <br>
                @endforeach
        </div>
        <div style='display: inline-block;float:right;width: 30%'>
            <p style="color:white;font-size: 15px;text-align: right">
                @foreach($bankAccounts as $bankAccount)
                <a href="{{route('bankAccount.show', ['bankAccount' => $bankAccount])}}" style="color: white">
                    {{formatCurrency($bankAccount->balance)}}
                </a>
                <br>
                @endforeach
            </p>
        </div>
    </div>
</div>

<div class='row mt-4 mb-3 ms-2 me-2'>
    <div class='col-lg-2 text-center mx-auto mt-auto mb-auto'>
        <i class="fas fa-calendar-check" style="font-size:42px; color:#8B2485"></i>
        <p class="mt-2" style="color:#8B2485">
            TAREFAS
        </p>
    </div>

    <div class='col-lg-3 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
            <p class='panel-number'>
                {{$tasks_pending}}
            </p>
            <p class='panel-text'>
                equipe
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block tasks-my'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'contact_id' => '',
				'user_id' => Auth::user()->id,
				])}}'>
            <p class='panel-number'>
                {{$tasks_my}}
            </p>
            <p class='panel-text'>
                minhas
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block text-center tasks-now'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'feito',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
            <p class='panel-number'>
                {{$tasksDone}}
            </p>
            <p class='panel-text'>
                feitas
            </p>
        </a>
    </div>
</div>


<div class='row mt-5 mb-5 ms-2 me-2'>
        <div class='col-lg-2 text-center mx-auto mt-auto mb-auto'>
        <i class="fas fa-funnel-dollar" style="font-size:42px; color:#8B2485"></i>
        <p class="mt-2" style="color:#8B2485">
            OPORTUNIDADES
        </p>
    </div>
    <div class='col-lg-7 d-inline-block opportunities-funnel ps-5'>
        <div class='funnel-bar-prospecting'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'prospecção',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                PROSPECTAR: {{$opportunitiesProspecting}}
            </a>
        </div>
        <div class='funnel-bar-presentation'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'apresentação',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                APRESENTAR: {{$opportunitiesPresentation}}
            </a>
        </div>
        <div class='funnel-bar-proposal'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'proposta',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                PROPOSTA: {{$opportunitiesProposal}}
            </a>
        </div>
        <div class='funnel-bar-contract'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'contract',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                CONTRATO: {{$opportunitiesContract}}
            </a>
        </div>
        <div class='funnel-bar-bill'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'cobrança',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                COBRANÇA: {{$opportunitiesBill}}
            </a>
        </div>
        <div class='funnel-bar-production'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'produção',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                PRODUÇÃO: {{$opportunitiesProduction}}
            </a>
        </div>
        <div class='funnel-bar-concluded'>
            <a style='text-decoration:none;color:white' href='{{route('opportunity.index', [
				'stage' =>'concluída',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                CONCLUÍDAS: {{$opportunitiesConcluded}}
            </a>
        </div>
    </div>

    <div class='col-3 d-inline-block triangle-text' style='display: inline-block;position: relative'>
        <div class='balance-won mx-auto'>
            <a style='text-decoration:none' href='{{route('opportunity.index', [
				'stage' =>'ganhamos',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                <p class='balance_number' style="margin-left: -100px">
                    {{$opportunitiesWon}}
                </p>
                <p class='balance_label_won' style="margin-left: -100px;margin-top: -10px">
                    ganhamos
                </p>
            </a>
        </div>
        <div id='triangle-text'  style='display: inline-block;position: relative'>
            <div class='balance-lost  mx-auto'>
                <a style='text-decoration:none' href='{{route('opportunity.index', [
				'stage' =>'perdemos',
				'contact_id' => '',
				'user_id' => '',
				])}}'>
                    <p class='balance_number' style='margin-left: -20px'>
                        {{$opportunitiesLost}}
                    </p>
                    <p class='balance_label_lost'>
                        perdemos
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>

<div class='row mt-2 mb-3 ms-2 me-2'>
    <div class='col-lg-2 text-center mx-auto mt-auto mb-auto'>
        <i class="fas fa-mug-hot" style="font-size:42px; color:#8B2485"></i>
        <p class="mt-2" style="color:#8B2485">
            JORNADAS
        </p>
    </div>
    <div class='col-lg-10 d-inline-block  ps-5'>
        <table class='table-list'>
            <tr>
                <td   class='table-list-header' style='width: 40%'>
                    FUNCIONÁRIO 
                </td>
                <td   class='table-list-header' style='width: 10%'>
                    HOJE					
                </td>
                <td   class='table-list-header' style='width: 10%'>
                    {{strtoupper($month)}}
                </td>
            </tr>

            @foreach ($users as $user)
            <tr style='font-size: 14px'>
                <td class='table-list-left'>
                    <a class='white' href=' {{route('user.show', ['user' => $user->id])}}'>
                        <button class='button-round'>
                            <i class='fa fa-eye'></i>
                        </button>
                    </a>
                    {{$user->name}}
                </td>
                <td class='table-list-center'>
                    <a class='white' href=' {{route('journey.index', [
                                                                                            'user_id' => $user->id,
                                                                                            'date_start' => date('Y-m-d'),
                                                                                            'date_end' => date('Y-m-d'),
                                                                                            ])}}'>
                        {{formatTotalHour($user->hoursToday)}}
                    </a>
                </td>
                <td class='table-list-center'>
                    <a class='white' href=' {{route('journey.index', [
                                                                                            'user_id' => $user->id,
                                                                                            'date_start' => date('Y-m-1'),
                                                                                            'date_end' => date('Y-m-31'),
                                                                                            ])}}'>
                        {{formatTotalHour($user->hoursMonthly)}}
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<br>
<br>
@endsection