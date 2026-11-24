@extends('layouts/dashboard')

@section('buttons')
@endsection

@section('main')
    <div class='row'>
        <div class='col-4 mt-3 mb-3'
            style='
         border-style: solid;
         border-width: 1px;
         border-color: var(--principal-color, #874983);
         border-radius: 10px;
         '>
            <div class='row mt-2'>
                <p style='color: #52004d;font-weight: 600;text-align: center;font-size: 22px'>
                    HOJE
                </p>
            </div>
            @if ($myTasksToday->isEmpty())
                <div class='row'>
                    <img class='ms-auto me-auto w-50 pt-3 pb-2' src='{{ asset('images/sciblock-mascote.png') }}'>
                </div>
                <div class='row mt-2'>
                    <p class='text-center fs-5'>
                        Sem tarefas hoje.
                    </p>
                </div>
            @else
                @foreach ($myTasksToday as $task)
                    <a class='task-line' href='{{ route('task.show', ['task' => $task->id]) }}'
                        title='{{ $task->name }}'>
                        <span class='task-line-date'>{{ date('H:i', strtotime($task->date_due)) }}</span>
                        <span class='task-line-name'>{{ $task->name }}</span>
                        <span class='task-line-meta'>{{ $task->project ? $task->project->name . ' · ' : '' }}{{ $task->department }}</span>
                    </a>
                @endforeach
            @endif
            <div class='row mt-2'>
                <div class='col d-flex justify-content-center gap-3 pb-4 pt-2'>
                    <x-buttons.create model="task" title="Nova tarefa" :principalColor="$principalColor" />
                    <a class='btn rounded-circle' title='Agenda' href='{{ route('task.calendar') }}'
                        style='background-color: {{ $principalColor }}; border-color: {{ $principalColor }}; color: white; width: 38px; height: 38px; padding: 0; display: inline-flex; align-items: center; justify-content: center;'>
                        <i class='fas fa-calendar'></i>
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
                        <a class='white'
                            href=' {{ route('journey.index', [
                                'user_id' => auth()->user()->id,
                                'date_start' => date('Y-m-d'),
                                'date_end' => date('Y-m-d'),
                            ]) }}'>
                            <p class='panel-text pt-2'>
                                HOJE
                                <br>
                                {{ formatTotalHour($hoursToday) }}
                            </p>
                        </a>
                    </div>

                    <div class='col'>
                        <a class='white'
                            href=' {{ route('journey.index', [
                                'user_id' => auth()->user()->id,
                                'date_start' => date('Y-m-1'),
                                'date_end' => date('Y-m-31'),
                            ]) }}'>
                            <p class='panel-text pt-2 pb-4'>
                                MÊS
                                <br>
                                {{ formatTotalHour($hoursMonthly) }}
                            </p>
                        </a>
                    </div>
                </div>
                @foreach ($lastJourneys as $journey)
                    <div class='journey-display-row'>
                        <div class='col-4'>
                            <a class='white' href=' {{ route('journey.show', ['journey' => $journey]) }}'>
                                <p class='ps-3' style='color:white;font-weight:600;font-size: 15px'>
                                    <i class='fas fa-clock' style='font-size:14px'></i>
                                    {{ date('d/m', strtotime($journey->start)) }}
                                </p>
                            </a>
                        </div>
                        <div class='col-6'>
                            <a class='white' href=' {{ route('journey.show', ['journey' => $journey]) }}'>
                                <p style='color:white;font-weight:600;font-size: 14px;text-align: center'>
                                    [ {{ date('H:i', strtotime($journey->start)) }}
                                    @if ($journey->end == null)
                                        - fazendo ]
                                    @else
                                        - {{ date('H:i', strtotime($journey->end)) }} ]
                                    @endif
                                </p>
                            </a>
                        </div>
                        <div class='col-2'>
                            <a class='white' href=' {{ route('journey.show', ['journey' => $journey]) }}'>
                                <p style='color:white;font-weight:600;font-size: 14px'>
                                    {{ number_format($journey->duration / 3600, 1, ',', '.') }}
                                </p>
                            </a>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <a class='white' style="color: white"
                            href=' {{ route('journey.index', [
                                'user_id' => auth()->user()->id,
                            ]) }}'>
                            ver todas
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--    coluna 3 -->

        <div class='col-4 mt-3 mb-0'
            style='
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
            @if ($myTasksLimited->isEmpty())
                <div class='row mt-2'>
                    <p class='text-center'>
                        Ufa...Tudo feito.
                    </p>
                </div>
            @else
                @foreach ($myTasksLimited as $task)
                    <a class='task-line {{ $task->priority == 'emergência' ? 'task-line-emergency' : '' }}'
                        href='{{ route('task.show', ['task' => $task->id]) }}' title='{{ $task->name }}'>
                        <span class='task-line-date'>{{ date('d/m', strtotime($task->date_due)) }}</span>
                        <span class='task-line-name'>{{ $task->name }}</span>
                        <span class='task-line-meta'>{{ $task->department }}</span>
                    </a>
                @endforeach
        <div class="row mb-2 mt-1">
            <div class="col d-flex justify-content-center">
                <a
                    href='{{ route('task.index', [
                        'status' => 'fazer',
                        'user_id' => Auth::user()->id,
                    ]) }}'>
                    {{ $myTasksCount }} tarefas abertas
                </a>
            </div>
        </div>
        @endif
    </div>
    </div>

    <!--    linha  -->

    <div class='row mt-5 mb-5 ms-0 me-0 pe-3'>
        <div class='offset-1 col-2'
            style='
         background-color: var(--principal-color, #874983);
         border-radius: 10px 0px 0px 10px
         '>
            <div class='row pt-3 text-center'>
                <i class='fas fa-check-circle' title='' style='color:white;font-size: 40px'></i>
            </div>
            <div class='row pt-1 labels' style="margin-bottom: -30px">
                <p style='text-align: center;color:white'>
                    PROJETOS
                    <br>
                    <a class='white' style="font-size: 12px"
                        href=' {{ route('project.index', [
                            'account_id' => auth()->user()->account_id,
                        ]) }}'>
                        ver todos
                    </a>
                </p>
            </div>
        </div>
        <div class='col-2'>
            <div class="row pt-2 pb-2 ps-2 pe-2 h-100 align-items-stretch"
                style='
             border-style: solid;
             border-width: 1px;
             border-color: var(--principal-color, #874983);
             border-radius: 0px 10px 10px 0px;
             '>
                <div class='col stat-card'>
                    <a style='text-decoration:none'
                        href='{{ route('project.index', [
                            'status' => 'fazer',
                        ]) }}'>
                        <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                            <span style='font-size:32px'>
                                {{ $projectsCount }}
                            </span>
                            <br>
                            ANDAMENTO
                        </p>
                    </a>
                </div>

                <div class='col stat-card stat-card-danger'>
                    <a style='text-decoration:none'
                        href='{{ route('task.index', [
                            'status' => 'fazer',
                            'date_due' => date('Y-m-d'),
                        ]) }}'>
                        <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                            <span style='font-size:32px'>
                                {{ $delayedProjectsCount }}
                            </span>
                            <br>
                            ATRASADOS
                        </p>
                    </a>
                </div>


            </div>
        </div>
        <div class='offset-1 col-2'
            style='
         background-color: var(--principal-color, #874983);
         border-radius: 10px 0px 0px 10px
         '>
            <a style='text-decoration:none'
                href='{{ route('task.index', [
                    'status' => 'fazer',
                    'user_id' => Auth::user()->id,
                ]) }}'>
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
            <div class="row pt-2 pb-2 ps-2 pe-2 h-100 align-items-stretch"
                style='
             border-style: solid;
             border-width: 1px;
             border-color: var(--principal-color, #874983);
             border-radius: 0px 10px 10px 0px;
             '>
                <div class='col stat-card'>
                    <a style='text-decoration:none'
                        href='{{ route('task.index', [
                            'status' => 'fazer',
                        ]) }}'>
                        <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                            <span style='font-size:32px'>
                                {{ $teamTasksCount }}
                            </span>
                            <br>
                            TAREFAS
                        </p>
                    </a>
                </div>

                <div class='col stat-card stat-card-danger'>
                    <a style='text-decoration:none'
                        href='{{ route('task.index', [
                            'status' => 'fazer',
                            'priority' => 'emergência',
                        ]) }}'>
                        <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                            <span style='font-size:32px'>
                                {{ $teamTasksEmergenciesCount }}
                            </span>
                            <br>
                            EMERGÊNCIAS
                        </p>
                    </a>
                </div>


                <div class='col stat-card stat-card-warning'>
                    <a style='text-decoration:none'
                        href='{{ route('task.index', [
                            'status' => 'fazer',
                            'date_due' => date('Y-m-d'),
                        ]) }}'>
                        <p class='ps-0 pe-0' style='font-size:12px; color:white;text-align: center;font-weight: 600'>
                            <span style='font-size:32px'>
                                {{ $teamTasksLatesCount }}
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
    <div class="row pt-1 pb-2 ps-2 pe-2"
        style='
     border-style: solid;
     border-width: 1px;
     border-color: var(--principal-color, #874983);
     border-radius: 10px 0px 10px 0px;
     '>
        <div class='row mt-0 mb-2 ms-1 me-1 p-0'>
            <div class="col">
                @foreach ($users as $user)
                    <div class='team-line {{ $user['backgroundColor'] == null ? 'team-line-active' : '' }}'>
                        <a class='team-line-user' href='{{ route('user.show', ['user' => $user->id]) }}'
                            title='{{ $user->contact->name }}'>
                            @if (isset($user->image))
                                <img class='team-line-avatar' src='{{ asset($user->image->path) }}'>
                            @else
                                <i class='fas fa-user-circle team-line-avatar-icon'></i>
                            @endif
                            <span class='team-line-username'>{{ $user->contact->name }}</span>
                        </a>

                        <span class='team-line-label'>{{ $user['backgroundColor'] == null ? 'FAZENDO' : 'FEZ' }}</span>
                        <span class='team-line-task'>
                            @if ($user['backgroundColor'] == null)
                                @if ($user['taskId'] == null)
                                    {{ $user['journeyName'] }}
                                @else
                                    <a href='{{ route('task.show', ['task' => $user['taskId']]) }}'
                                        title='{{ $user['journeyName'] }}'>{{ $user['journeyName'] }}</a>
                                @endif
                            @elseif ($user->lastTask)
                                <a href='{{ route('task.show', ['task' => $user->lastTask->id]) }}'
                                    title='{{ $user->lastTask->name }}'>{{ $user->lastTask->name }}</a>
                            @else
                                {{ $user['journeyName'] }}
                            @endif
                        </span>

                        <span class='team-line-counters'>
                            <a class='team-pill' title='tarefas abertas'
                                href='{{ route('task.index', ['status' => 'fazer', 'user_id' => $user->id]) }}'>
                                <i class='fas fa-tasks'></i> {{ $user->tasks }}
                            </a>
                            <a class='team-pill team-pill-danger' title='tarefas emergenciais'
                                href='{{ route('task.index', ['status' => 'fazer', 'priority' => 'emergência', 'user_id' => $user->id]) }}'>
                                <i class='fas fa-exclamation-triangle'></i> {{ $user->emergencies }}
                            </a>
                            <a class='team-pill team-pill-warning' title='tarefas atrasadas'
                                href='{{ route('task.index', ['status' => 'fazer', 'priority' => 'emergência', 'user_id' => $user->id, 'date_due' => date('Y-m-d')]) }}'>
                                <i class='fas fa-clock'></i> {{ $user->lates }}
                            </a>
                            @if (isset($user->lastJourney))
                                <a class='team-pill team-pill-ok' title='última tarefa'
                                    href='{{ route('task.show', ['task' => $user->lastJourney->task_id]) }}'>
                                    <i class='fas fa-step-forward'></i>
                                </a>
                            @else
                                <span class='team-pill team-pill-ok' style='visibility:hidden'><i class='fas fa-step-forward'></i></span>
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection
