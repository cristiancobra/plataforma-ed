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


<div class="row pt-5 pb-5">
    <div class="col-2 pt-5" style="
         background-color: #fff6ff;
         border-radius: 20px 0 0 20px;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-right-style: none;
         ">
        <p class="mt-2 text-center" style="color:#8B2485">
            <i class="fas fa-user-plus" style="font-size:40px; color:#8B2485"></i>
            <br>
            CONTATOS
            <br>
            <br>
            <a class="text-button btn-info" name="new_contacts" href="{{route('contact.index', ['created_at' => date("Y-m-d", strtotime("-7 days"))])}}">
                +{{$contactsNews}} esta semana
            </a>
        </p>
    </div>
    <div class="col-4" style="
         background-color: #fff6ff;
         border-radius: 0 20px 20px 0;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-left-style: none;
         padding: 15px;
         ">
        <canvas id="contactsChart" width="400" height="250"></canvas>
    </div>
    <div class="col-2 pt-5" style="
         background-color: #fff6ff;
         border-radius: 20px 0 0 20px;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-right-style: none;
         ">
        <p class="mt-2 text-center" style="color:#8B2485">
            <i class="fas fa-funnel-dollar" style="font-size:40px; color:#8B2485"></i>
            <br>
            OPORTUNIDADES
                        <br>
            <br>
            <a class="text-button btn-info" name="new_contacts" href="{{route('opportunity.index', ['created_at' => date("Y-m-d", strtotime("-7 days"))])}}">
                +{{$opportunitiesWon}} esta semana
            </a>
            <br>
            <br>
            <a class="text-button btn-danger" name="new_contacts" href="{{route('opportunity.index', ['created_at' => date("Y-m-d", strtotime("-7 days"))])}}">
                +{{$opportunitiesLost}} esta semana
            </a>
        </p>
    </div>
    <div class="col-4" style="
         background-color: #fff6ff;
         border-radius: 0 20px 20px 0;
         border-color: white;
         border-width: 5px;
         border-style: solid;
         border-left-style: none;
         padding: 15px;
         ">
        <canvas id="opportunitiesChart" width="400" height="250"></canvas>
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

@section('js-scripts')
<script>

//Cria o gráfico para contatos
    var ctx = document.getElementById('contactsChart');
    var contactsChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: ['Curiosos', 'Interessados', 'Qualificados'],
                    datasets: [{
                    label: 'FUNIL DE MARKETING',
                            data: {!! json_encode($contacts) !!},
                            backgroundColor: [
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 2,
                    }]
            },
            options: {
            indexAxis: 'y',
            }
    });
//Cria o gráfico para oportunidades
    var ctx = document.getElementById('opportunitiesChart');
    var contactsChart = new Chart(ctx, {
    type: 'bar',
            data: {
            labels: ['Prospectar', 'Apresentar', 'Proposta', 'Contrato', 'Cobrança', 'Produção', 'Concluídas'],
                    datasets: [{
                    label: 'FUNIL DE VENDAS',
                            data: {!! json_encode($opportunities) !!},
                            backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 2,
                    }]
            },
            options: {
            indexAxis: 'y',
            }
    });
</script>
@endsection