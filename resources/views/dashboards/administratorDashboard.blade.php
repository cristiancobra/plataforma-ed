@extends('layouts/master')

@section('title','MEU PAINEL')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3'>
    <div class='col-4'>
        <div class='row'>
            <p style='color: #52004d;font-weight: 600;text-align: center;font-size: 22px'>
                HOJE
            </p>
        </div>
        @if($myTasksToday->isEmpty())
        <div class='row'>
            <img class='align-items-center' src='{{asset('imagens/cao-astronaut.png')}}' width='150px' height='150px'>
        </div>
        <div class='row mt-2'>
            <p class='text-center'>
                Sem tarefas hoje.
            </p>
        </div>
        @else
        @foreach($myTasksToday as $task)
        <a style='text-decoration:none' href='{{route('task.show', ['task' => $task->id])}}'>
            <div class='row mb-3'>
                <div class='col-2 text-end fs-5 my-auto' style='color: #c28dbf;font-weight: 600'>
                    {{date('H:i', strtotime($task->date_due))}}
                </div>

                <div class='col-9 justify-content-start task d-block'>
                    <p>
                        <span  style='font-weight: 600'>{{$task->name}}</span>
                        <br>
                        {{$task->department}}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
        @endif
    </div>

    <div class='col-4'>
        <p style='color: #8b0000;font-weight: 600;text-align: center;font-size: 22px'>
            {{$myTasksEmergenciesAmount}} emergências
        </p>
        @foreach($myTasksEmergencies as $task)
        <a style='text-decoration:none' href='{{route('task.show', ['task' => $task->id])}}'>
            <div class='row mb-3'>
                <div class='col-2 text-end  my-auto' style='color: #8b0000;font-weight: 600;font-size: 18px'>
                    {{date('d/m', strtotime($task->date_due))}}
                </div>

                <div class='col-9 justify-content-start task-emergency d-block'>
                    <p>
                        <span  style='font-weight: 600'>{{$task->name}}</span>
                        <br>
                        {{$task->department}}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class='col-4'>
        <div class='journey-display'>
            <div class='row pt-0 mb-1'>
                <p class='panel-text pt-2'>
                    <i class='fas fa-mug-hot' style='font-size:42px; color:white'></i>
                </p>
            </div>
            <div class='row'>
                <div class='col'>
                    <a class='white' href=' {{route('journey.index', [
                                                                                            'user_id' => auth()->user()->id,
                                                                                            'date_start' => date('Y-m-d'),
                                                                                            'date_end' => date('Y-m-d'),
                                                                                            ])}}'>
                        <p class='panel-text pt-2'>
                            HOJE
                            <br>
                            {{formatTotalHour($hoursToday)}}
                        </p>
                    </a>
                </div>

                <div class='col'>
                    <a class='white' href=' {{route('journey.index', [
                                                                                            'user_id' => auth()->user()->id,
                                                                                            'date_start' => date('Y-m-1'),
                                                                                            'date_end' => date('Y-m-31'),
                                                                                            ])}}'>
                        <p class='panel-text pt-2 pb-4'>
                            MÊS
                            <br>
                            {{formatTotalHour($hoursMonthly)}}
                        </p>
                    </a>
                </div>
            </div>
            @foreach($lastJourneys as $journey)
            <div class='row ms-0 me-0 pt-2 pb-0 mb-3 mt-0' style="background-color:rgba(255,255,255, 0.3);border-radius:20px;max-height: 36px">
                <div class='col-4'>
                    <a class='white' href=' {{route('journey.show', ['journey' => $journey])}}'>
                        <p class='ps-3' style='color:white;font-weight:600;font-size: 15px'>
                            <i class='fas fa-clock' style='font-size:14px'></i>
                            {{date('d/m', strtotime($journey->start))}}
                        </p>
                    </a>
                </div>
                <div class='col-6'>
                    <a class='white' href=' {{route('journey.show', ['journey' => $journey])}}'>
                    <p style='color:white;font-weight:600;font-size: 14px;text-align: center'>
                        [ {{date('H:m', strtotime($journey->start))}}                
                        @if($journey->end == null)
                        - fazendo ]
                        @else
                        - {{date('H:m', strtotime($journey->end))}} ]
                        @endif
                    </p>
                    </a>
                </div>
                <div class='col-2'>
                    <a class='white' href=' {{route('journey.show', ['journey' => $journey])}}'>
                    <p style='color:white;font-weight:600;font-size: 14px'>
                         {{number_format($journey->duration / 3600, 1, ',','.')}}
                    </p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class='row mt-3 ps-3 pe-3'>
            <div class='col tasks-toDo'>
                <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				])}}'>
                    <p class='panel-number mt-3'>
                        {{$tasks_pending}}
                    </p>
                    <p class='panel-text mb-3'>
                        equipe
                    </p>
                </a>
            </div>

            <div class='col tasks-my'>
                <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'user_id' => Auth::user()->id,
				])}}'>
                    <p class='panel-number mt-3'>
                        {{$tasks_my}}
                    </p>
                    <p class='panel-text mb-3'>
                        minhas
                    </p>
                </a>
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