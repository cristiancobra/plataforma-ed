@extends('layouts/dashboard')

@section('buttons')
@endsection

@section('main')
<div class='row'>
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
                        @if($task->project)
                        {{$task->project->name}} - 
                        @endif
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
                            [ {{date('H:i', strtotime($journey->start))}}                
                            @if($journey->end == null)
                            - fazendo ]
                            @else
                            - {{date('H:i', strtotime($journey->end))}} ]
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
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <a class='white' style="color: white" href=' {{route('journey.index', [
                                                                                            'user_id' => auth()->user()->id,
                                                                                            ])}}'>
                        ver todas
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--    coluna 3 -->

    <div class='col-4 mt-3 mb-0' style='
         border-style: solid;
         border-width: 1px;
         border-color: #8b0000;
         border-radius: 10px;
         '>
        <div class='row mt-2'>
            <p style='color: #8b0000;font-weight: 600;text-align: center;font-size: 22px'>
                Próximas tarefas
            </p>
        </div>
        @if($myTasksLimited->isEmpty())

        <div class='row mt-2'>
            <p class='text-center'>
                Ufa...Tudo feito.
            </p>
        </div>
        @else
        @foreach($myTasksLimited as $task)
        <a style='text-decoration:none' href='{{route('task.show', ['task' => $task->id])}}'>
            <div class='row mb-3'>
                <div class='col-2 text-end  my-auto' style='color: #8b0000;font-weight: 600;font-size: 18px'>
                    {{date('d/m', strtotime($task->date_due))}}
                </div>

                @if($task->priority == 'emergência')
                <div class='col-9 justify-content-start task-emergency d-block'>
                    @else
                    <div class='col-9 justify-content-start task d-block'>
                        @endif
                        <p>
                            <span  style='font-weight: 600'>{{$task->name}}</span>
                            <br>
                            {{$task->department}}
                        </p>
                    </div>
                </div>
        </a>
        @endforeach
        <div class="row mb-2 mt-1">
            <div class="col d-flex justify-content-center">
                <a  href='{{route('task.index', [
				'status' =>'fazer',
				'user_id' => Auth::user()->id,
				])}}'>
                    {{$myTasksCount}} tarefas abertas
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!--    linha  -->

<div class='row mt-5 mb-5 ms-0 me-0 pe-3'>
    <div class='offset-1 col-2' style='
         background-color: #c28dbf;
         border-radius: 10px 0px 0px 10px
         '>
            <div class='row pt-3 text-center'>
                <i class='fas fa-check-circle' title='' style='color:white;font-size: 40px'></i>
            </div>
        <div class='row pt-1 labels' style="margin-bottom: -30px">
                <p style='text-align: center;color:white'>
                    PROJETOS
                    <br>
                    <a class='white' style="font-size: 12px" href=' {{route('project.index', [
                                                                                            'account_id' => auth()->user()->account_id,
                                                                                            ])}}'>
                        ver todos
                    </a>
                </p>
            </div>
    </div>
    <div class='col-2'>
        <div class="row pt-2 pb-2 ps-2 pe-2" style='
             border-style: solid;
             border-width: 1px;
             border-color: #c28dbf;
             border-radius: 0px 10px 10px 0px;
             '>
            <div class='col task-high-button'>
                <a style='text-decoration:none' href='{{route('project.index', [
				'status' =>'fazer',
				])}}'>
                    <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                        <span style='font-size:32px'>
                            {{$projectsCount}}
                        </span>
                        <br>
                        ANDAMENTO
                    </p>
                </a>
            </div>

            <div class='col emergency-button'>
                <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
                                        		'date_due' => date('Y-m-d'),
				])}}'>
                    <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                        <span style='font-size:32px'>
                            {{$delayedProjectsCount}}
                        </span>
                        <br>
                        ATRASADOS
                    </p>
                </a>
            </div>


        </div>
    </div>
    <div class='offset-1 col-2' style='
         background-color: #c28dbf;
         border-radius: 10px 0px 0px 10px
         '>
        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'user_id' => Auth::user()->id,
				])}}'>
            <div class='row pt-3 text-center'>
                <i class='fas fa-users' title='' style='color:white;font-size: 40px'></i>
            </div>
            <div class='row pt-1 labels'>
                <p style='text-align: center;color:white'>
                    EQUIPE
                </p>
            </div>
        </a>
    </div>
    <div class='col-3'>
        <div class="row pt-2 pb-2 ps-2 pe-2" style='
             border-style: solid;
             border-width: 1px;
             border-color: #c28dbf;
             border-radius: 0px 10px 10px 0px;
             '>
            <div class='col task-high-button'>
                <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				])}}'>
                    <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                        <span style='font-size:32px'>
                            {{$teamTasksCount}}
                        </span>
                        <br>
                        TAREFAS
                    </p>
                </a>
            </div>

            <div class='col emergency-button'>
                <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
                                        		'priority' =>'emergência',
				])}}'>
                    <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                        <span style='font-size:32px'>
                            {{$teamTasksEmergenciesCount}}
                        </span>
                        <br>
                        EMERGÊNCIAS
                    </p>
                </a>
            </div>


            <div class='col  team-button'>
                <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
				'date_due' =>date('Y-m-d'),
				])}}'>
                    <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                        <span style='font-size:32px'>
                            {{$teamTasksLatesCount}}
                        </span>
                        <br>
                        ATRASADAS
                    </p>
                </a>
            </div>

        </div>
    </div>
</div>

<!--users-->
<div class="row pt-1 pb-2 ps-2 pe-2" style='
     border-style: solid;
     border-width: 1px;
     border-color: #c28dbf;
     border-radius: 10px 0px 10px 0px;
     '>
    <div class='row mt-0 mb-2 ms-1 me-1 p-0'>
        <div class="col">
            @foreach($users as $user)
            <div class='row mt-5 me-1' style='
                 border-style: solid;
                 border-width: 1px;
                 border-color: #c28dbf;
                 border-radius: 10px;
                 background-color: {{$user['backgroundColor']}};
                 '>
                <div class='col-1 d-inline-block'>
                    @if(isset($user->image))
                    <div class='profile-picture-small'>
                        <a  class='white' href=' {{route('user.show', ['user' => $user->id])}}'>
                            <img src='{{asset($user->image->path)}}' width='100%' height='100%'>
                        </a>
                    </div>
                    @else
                    <a  class='white' href=' {{route('user.show', ['user' => $user->id])}}'>
                        {{$user->contact->name}}
                    </a>
                    @endif
                </div>

                @if($user['backgroundColor'] == null)
                <div class='col-1 mt-3 mb-4 ms-2 ps-1' style="
                     border-radius: 10px 0px 0px 10px;
                     background-color: {{$complementaryColor}};
                     color: white;
                     font-size:14px; 
                     margin-top: -0px;
                     padding-bottom: 0px;
                     padding-top: 15px;
                     text-align: left;
                     font-weight: 600;
                     ">
                    FAZENDO
                </div>
                @else
                <div class='col-1 mt-3 mb-4 ms-2 ps-1' style="
                     border-radius: 10px 0px 0px 10px;
                     border-color: gray;
                     border-style: solid;
                     border-width: 1px;
                     background-color: {{$user['backgroundColor']}};
                     color: white;
                     font-size:14px; 
                     margin-top: -0px;
                     padding-bottom: 0px;
                     padding-top: 15px;
                     text-align: left;
                     font-weight: 600;
                     ">
                    FAZENDO
                </div>
                @endif

                <div class="col-3 mt-3 mb-4 pt-3 show-field-end">
                    @if($user['taskId'] == null)
                    {{$user['journeyName']}}
                    @else
                    <a  class='white' style="font-size: 14px" href=' {{route('task.show', ['task' => $user['taskId']])}}'>
                        {{$user['journeyName']}}
                    </a>
                    @endif
                </div>

                @if($user['backgroundColor'] == null)
                <div class='col-1 mt-3 mb-4 ms-5 ps-3' style="
                     border-radius: 10px 0px 0px 10px;
                     background-color: {{$oppositeColor}};
                     color: white;
                     font-size:14px; 
                     margin-top: -0px;
                     padding-bottom: 0px;
                     padding-top: 15px;
                     text-align: left;
                     font-weight: 600;
                     ">
                    FEZ
                </div>
                @else
                <div class='col-1 mt-3 mb-4 ms-5 ps-3' style="
                     border-radius: 10px 0px 0px 10px;
                     border-color: gray;
                     border-style: solid;
                     border-width: 1px;
                     background-color: {{$user['backgroundColor']}};
                     color: white;
                     font-size:14px; 
                     margin-top: -0px;
                     padding-bottom: 0px;
                     padding-top: 15px;
                     text-align: left;
                     font-weight: 600;
                     ">
                    FEZ
                </div>
                @endif

                @if($user->lastTask)
                <div class="col-3 mt-3 mb-4 pt-2 show-field-end">
                    <a  class='white' style="font-size: 14px" href=' {{route('task.show', ['task' => $user->lastTask->id])}}'>
                        {{$user->lastTask->name}}
                    </a>
                </div>
                @endif

                <div class="col-3 text-end">
                    <div class="col d-inline-block mt-3 pt-2 task-high-button" style="width: 48px" title='tarefas abertas'>
                        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
                                                                                'user_id' => $user->id,
				])}}'>
                            <p style='font-size:20px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                                {{$user->tasks}}
                            </p>
                        </a>
                    </div>

                    <div class='col d-inline-block  mt-3 pt-2 emergency-button' style="width: 48px" title='tarefas emergenciais'>
                        <a style='text-decoration:none' href='{{route('task.index', [
				'status' => 'fazer',
                                                                                'priority' => 'emergência',
                                        		'user_id' => $user->id,
				])}}'>
                            <p style='font-size:20px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                                {{$user->emergencies}}
                            </p>
                        </a>
                    </div>

                    <div class='col d-inline-block  mt-3 pt-2  team-button' style="width: 48px" title='tarefas atrasadas'>
                        <a style='text-decoration:none' href='{{route('task.index', [
				'status' =>'fazer',
                                                                                'priority' =>'emergência',
                                        		'user_id' => $user->id,
                                                        		'date_due' =>date('Y-m-d'),
				])}}'>
                            <p style='font-size:20px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                                {{$user->lates}}
                            </p>
                        </a>
                    </div>

                    @if(isset($user->lastJourney))
                    <div class='d-inline-block mt-3  pt-2  sales-button' style="width: 48px" title='última tarefa'>
                        <a style='text-decoration:none' href='{{route('task.show', ['task' => $user->lastJourney->task_id])}}'>
                            <p style='font-size:20px; color:white;margin-top: -0px;padding-bottom: 0px;text-align: center;font-weight: 600'>
                                <i class='fas fa-step-forward' style='font-size:20px; color:white;margin-top: 0px;padding-bottom: 0px'></i>
                            </p>
                        </a>
                    </div>
                    @endif

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection
