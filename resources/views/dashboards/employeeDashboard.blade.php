@extends('layouts/master')

@section('title','FUNCIONÁRIO')

@section('image-top')
{{asset('images/control-panel.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('task.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div class='row mt-4 mb-3 ms-2 me-2'>
    <div class='col-lg-2 text-center mx-auto mt-auto mb-auto'>
        <i class="fas fa-calendar-check" style="font-size:42px; color:#8B2485"></i>
        <p class="mt-2" style="color:#8B2485">
            TAREFAS
        </p>
    </div>

    <div class='col-lg-3 d-inline-block tasks-toDo'>
        <a style="text-decoration:none" href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
            <p class="panel-number">
                {{$tasks_pending}}
            </p>
            <p class='panel-text'>
                atrasadas
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block tasks-my'>
        <a href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
            <p class="panel-number">
                {{$tasks_my}}
            </p>
            <p class='panel-text'>
                minhas
            </p>
        </a>
    </div>

    <div class='col-lg-3 d-inline-block text-center tasks-now'>
        <a href="{{route('task.index', [
				'status' =>"feito",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
            <p class="panel-number">
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
                <td   class="table-list-header" style="width: 50%">
                    <b>DEPARTAMENTOS </b>
                </td>
                <td   class="table-list-header" style="width: 10%">
                    HOJE					
                </td>
                <td   class="table-list-header" style="width: 10%">
                    {{strtoupper($month)}}
                </td>
            </tr>

            @foreach ($departments as $department)
            <tr style="font-size: 14px">
                <td class="table-list-left">
                    <a class="white" href=" ">
                        <button class="button-round">
                            <i class='fa fa-eye'></i>
                        </button>
                    </a>
                    {{$department}}
                </td>
                <td class="table-list-center">
                    {{number_format($departmentsToday[$department] / 3600, 1, ',','.')}}
                </td>
                <td class="table-list-center">
                    {{number_format($departmentsMonthly[$department] / 3600, 1, ',','.')}}
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