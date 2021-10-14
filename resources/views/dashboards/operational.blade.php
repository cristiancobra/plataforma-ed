@extends('layouts/dashboard')

@section('buttons')
@endsection

@section('main')
<div class='row mt-2 mb-3'>
    <div class='col-4 mt-3 mb-3' style='
         border-style: solid;
         border-width: 1px;
         border-color: #c28dbf;
         border-radius: 10px;
         '>
        <div class='row mt-2'>
            <p style='color: #52004d;font-weight: 600;text-align: center;font-size: 22px'>
                HOJE
            </p>
        </div>
        @if($myTasksToday->isEmpty())
        <div class='row'>
            <img class='ms-auto me-auto w-50 pt-3 pb-2' src='{{asset('images/cao-astronauta.png')}}'>
        </div>
        <div class='row mt-2'>
            <p class='text-center fs-5'>
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
        <div class='row mt-2'>
            <div class='col d-flex justify-content-center'>
                <a class='circular-button primary' style='display: inline-block;float: right' href='{{route('task.create', [
//                                                                                                                                                                                        'task_name' => 'ATENDIMENTO',
//                                                                                                                                                                                        'opportunity_id' => $opportunity->id,
//                                                                                                                                                                                        'opportunity_name' => $opportunity->name,
//                                                                                                                                                                                        'company_name' => $companyName,
//                                                                                                                                                                                        'company_id' => $companyId,
//                                                                                                                                                                                        'contact_name' => $opportunity->contact->name,
//                                                                                                                                                                                        'contact_id' => $opportunity->contact->id,
//                                                                                                                                                                                        'department' => 'atendimento',
//                                                                                                                                                                                        'invoiceStatus' => 'orçamento',
                                                                                                                                                                                        ]
                    )}}'>
                    <i class='fa fa-plus text-center ' aria-hidden='true'></i>
                </a>
                <a class='circular-button primary' style='display: inline-block;float: right' href='{{route('task.calendar')}}'>
                    <i class='fa fa-calendar text-center ' aria-hidden='true'></i>
                </a>
            </div>
        </div>
    </div>

    <!-- coluna 2 -->

    <div class='col-4'>
        <div class='journey-display'>
            <div class='row'>
                <p class='panel-text pt-0 pb-2 fs-5'>
                    JORNADAS
                </p>
            </div>
            <div class='row pb-1 mb-1'>
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
            <div class='journey-display-row'>
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
    </div>

    <!--    coluna 3 -->

    <div class='col-4 mt-3 mb-3' style='
         border-style: solid;
         border-width: 1px;
         border-color: #8b0000;
         border-radius: 10px;
         '>
        <div class='row mt-2'>
            <p style='color: #8b0000;font-weight: 600;text-align: center;font-size: 22px'>
                {{$myTasksEmergenciesAmount}} emergências
            </p>
        </div>
        @if($myTasksEmergencies->isEmpty())

        <div class='row mt-2'>
            <p class='text-center'>
                Ufa! Sem emergências.
            </p>
        </div>
        @else
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
        @endif
    </div>
</div>
<div class='row mt-4 mb-3 ms-1 me-5 p-0' style='
     border-style: solid;
     border-width: 1px;
     border-color: #c28dbf;
     border-radius: 10px;
     '>
    <div class='col-2' style='background-color: #c28dbf;  border-radius: 10px 0px 0px 10px'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'user_id' => Auth::user()->id,
				])}}'>
        <div class='row pt-4 text-center'>
            <i class='fas fa-exclamation-triangle' title='' style='color:white;font-size: 50px'></i>
        </div>
        <div class='row pt-3 labels'>
            <p style='text-align: center;color:white'>
                {{$myTasksCount}} TAREFAS
            </p>
        </div>
        </a>
    </div>

    <div class='col-1 d-inline-block task-high-button'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'priority' =>'alta',
				'user_id' => Auth::user()->id,
				])}}'>
            <p class='panel-text'>
                <span style='font-size:36px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                    {{$myTasksHighCount}}
                </span>
                <br>
                ALTA
            </p>
        </a>
    </div>

    <div class='col-1 d-inline-block task-medium-button'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'priority' =>'média',
				'user_id' => Auth::user()->id,
				])}}'>
            <p class='panel-text'>
                <span style='font-size:36px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                    {{$myTasksMediumCount}}
                </span>
                <br>
                MÉDIA
            </p>
        </a>
    </div>

    <div class='col-1 d-inline-block task-low-button'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'priority' =>'baixa',
				'user_id' => Auth::user()->id,
				])}}'>
            <p class='panel-text'>
                <span style='font-size:36px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                    {{$myTasksLowCount}}
                </span>
                <br>
                BAIXA
            </p>
        </a>
    </div>

    <div class='col-1 d-inline-block emergency-button'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'user_id' => Auth::user()->id,
				'date_due' => date('Y-m-d'),
				])}}'>
            <p class='panel-text'>
                <span style='font-size:36px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                    {{$myTasksLateCount}}
                </span>
                <br>
                ATRASADAS
            </p>
        </a>
    </div>


    <div class='col-2 d-inline-block team-button'>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				])}}'>
            <p class='panel-text'>
                <span style='font-size:36px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                    {{$teamTasksPendingCount}}
                </span>
                <br>
                EQUIPE
            </p>
        </a>
    </div>

    
    @if(isset($myLastJourney))
    <div class='col-2 d-inline-block sales-button'>
        <a style='text-decoration:none' href='{{route('task.show', ['task' => $myLastJourney->task_id])}}'>
            <p class='panel-text mt-3'>
                <i class='fas fa-step-forward' style='font-size:30px; color:white;margin-top: 0px;padding-bottom: 10px'></i>
                <br>
                ÚLTIMA
            </p>
        </a>
    </div>
    @endif
</div>

<div class='row mt-4 mb-3 ms-1 me-5 p-0' style='
     border-style: solid;
     border-width: 1px;
     border-color: #c28dbf;
     border-radius: 10px;
     '>
    @foreach($users as $user)
    @if($user['journeyName'])
    <div class='row'>
        <div class='col-2 d-inline-block'>
            @if(isset($user->image))
            <div class='profile-picture-small'>
                <a  class='white' href=' {{route('user.show', ['user' => $user->id])}}'>
                    <img src='{{asset($user->image)}}' width='100%' height='100%'>
                </a>
            </div>
            @else
            <a  class='white' href=' {{route('user.show', ['user' => $user->id])}}'>
                {{$user->name}}
            </a>
            @endif
        </div>
        <div class='col-2 tb tb-header mt-4 mb-4' style="border-radius: 10px 0px 0px 10px">
                FAZENDO
            </div>
        <div class="col-8 mt-4 mb-4 pt-3 show-field-end">
            <a  class='white' href=' {{route('task.show', ['task' => $user['taskId']])}}'>
            {{$user['journeyName']}}
            </a>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endsection
