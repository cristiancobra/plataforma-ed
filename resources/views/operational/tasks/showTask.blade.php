@extends('layouts/show')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonPdf($task, 'task')}}

@if($task->status == 'fazendo')
<form style='text-decoration: none;color: black;display: inline-block' action=" {{ route('task.complete', ['task' => $task]) }} " method="post">
    @csrf
    @method('put')
    <button id='' class='circular-button secondary' title='Encerrar tarefa com a data atual' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
        <i class='fas fa-clipboard-check'></i>
    </button>
</form>
@endif
{{createButtonTrash($task, 'task')}}
{{createButtonEdit('task', 'task', $task)}}
{{createButtonList('task')}}
@endsection

@section('name', $task->name)

@section('priority')
{{formatShowPriority($task)}}
@endsection


@section('status')
@if($task->status == 'fazer' AND $task->journeys()->exists())
<div class='doing'>
    fazendo
</div>
@else
{{formatShowStatus($task)}}
@endif
@endsection


@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        CONTATO
    </div>
    <div class='show-label'>
        EMPRESA
    </div>
    <div class='show-label'>
        OPORTUNIDADE
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>

    @if(isset($task->contact->name))
    <a href='{{route('contact.show', ['contact' => $task->contact_id])}}'>
        <div class='show-field-end'>
            {{$task->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif

    @if(isset($task->company->name))
    <a href='{{route('company.show', ['company' => $task->company_id])}}'>
        <div class='show-field-end'>
            {{$task->company->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Pessoa física
    </div>
    @endif


    @if(isset($task->opportunity->id))
    <a href=' {{route('opportunity.show', ['opportunity' => $task->opportunity])}}'>
        <div class='show-field-end'>
            {{$task->opportunity->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif
</div>

<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
        <div class='show-label'>
        PROJETO
    </div>
        <div class='show-label'>
        META
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        {{$task->department}}
    </div>


    @if(isset($task->user->contact->name))
    <a href=' {{route('user.show', ['user' => $task->user_id])}}'>
        <div class='show-field-end'>
            {{$task->user->contact->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        foi excluído
    </div>
    @endif
    
        @if(isset($task->project))
    <a href=' {{route('project.show', ['project' => $task->project])}}'>
        <div class='show-field-end'>
            {{$task->project->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif
    
        @if(isset($task->goal))
    <a href=' {{route('goal.show', ['goal' => $task->goal])}}'>
        <div class='show-field-end'>
            {{$task->goal->name}}
        </div>
    </a>
    @else
    <div class='show-field-end'>
        Não possui
    </div>
    @endif

</div>
@endsection


@section('date_start')
<div class='circle-date-start'>
    {{date('d/m/Y', strtotime($task->date_start))}}
</div>
<p class='labels' style='text-align: center'>
    CRIAÇÃO
</p>
@endsection


@section('date_due')
<div class='circle-date-due'>
    {{dateBr($task->date_due)}}
    <br>
    {{date('H:i', strtotime($task->date_due))}}
</div>
<p class='labels' style='text-align: center'>
    PRAZO
</p>
@endsection


@section('date_conclusion')
<div class='circle-date-conclusion'>
    @if($task->date_conclusion)
    {{dateBr($task->date_conclusion)}}
    @else
    <p style='color:white'>
        --
    </p>
    @endif
</div>
<p class='labels' style='text-align: center'>
    CONCLUSÃO
</p>
@endsection


@section('description')
{!!html_entity_decode($task->description)!!}
@endsection

@section('main')
<div class='row' style='margin-top: 50px'>
    <div class='show-label-large col-12'>
        IMAGENS 
    </div>
</div>
<div class='row description-field justify-content-center'>
    @foreach($task->images as $image)
    <div class='col-2 mt-2 mb-2'>
        <image src='{{asset($image->path)}}' widht='100%' height='120px'>
    </div>
    @endforeach
</div>
<div class='row' style='margin-top: 10px;text-align: right'>
    <div class='col-12'style='text-align: right'>
        <form action=" {{route('image.store', [
                                                                    'image_name' => $task->name,
                                                                    'task_id' => $task->id,
                                                                    ]
                                )}} " method="post" enctype='multipart/form-data'>
            @csrf
            <input type='file' name='image'>
            <button type='submit' class='circular-button primary'>
                <i class='fa fa-plus' aria-hidden='true'></i>
            </button>
        </form
    </div>
</div>
</div>



<div class='row' style='margin-top: 50px;margin-bottom: -5px'>
    <div class='col-12 show-label-large'>
        EXECUÇÃO
    </div>
</div>
<div class='row'>
    <div class='col-1 tb tb-header'>
        ID
    </div>
    <div class='tb tb-header col-3'>
        FUNCIONÁRIO
    </div>
    <div class='tb tb-header col-4'>
        OBSERVAÇÕES
    </div>
    <div class='tb tb-header col-1'>
        DATA
    </div>
    <div class='tb tb-header col-1'>
        INÍCIO
    </div>
    <div class='tb tb-header col-1'>
        TÉRMINO
    </div>
    <div class='tb tb-header col-1'>
        DURAÇÃO
    </div>
</div>
@foreach ($task->journeys as $journey)
<div class='row'>
    <div class='tb col-1'>
        <button class='button-round'>
            <a href=' {{route('journey.edit', ['journey' => $journey])}}'>
                <i class='fa fa-edit' style='color:white'></i>
            </a>
        </button>
        {{$journey->id}}
    </div>
    <div class='tb col-3'>
        <a href=' {{route('user.show', ['user' => $task->user_id])}}'>
            {{$journey->user->contact->name}}
        </a>
    </div>
    <div class='tb-description col-4'>
        {!!html_entity_decode($journey->description)!!}
    </div>
    <div class='tb col-1 text-center'>
        @if($journey->start == date('Y-m-d'))
        hoje
        @else
        {{dateBr($journey->start)}}
        @endif
    </div>
    <div class='tb col-1 text-center'>
        {{date('H:i', strtotime($journey->start))}}
    </div>
    <div class='tb col-1 text-center'>
        @if($journey->end == null)
        --
        @else
        {{date('H:i', strtotime($journey->end))}}
        @endif
    </div>
    <div class='tb col-1 text-center' style='color:white;background-color: #874983;border-color: white'>
        {{gmdate('H:i', $journey->duration)}}
    </div>
</div>
@endforeach
<div class='row'>
    <div class='tb tb-header col-12' style='text-align: right;padding: 5px;padding-right: 25px;font-size: 16px' colspan='7'>
        Tempo total:   {{number_format($totalDuration / 3600, 1, ',','.')}}
        <br>
    </div>
</div>

<div class='row' style='margin-top: 10px;text-align: right'>
    <div class='col-12'style='text-align: right'>
        <a class='circular-button primary' href='{{route('journey.create', [
				'taskName' => $task->name,
				'taskId' => $task->id,
				'taskAccountName' => $task->account->name,
				'taskAccountId' => $task->account->id,
				])}}'>
            <i class='fa fa-plus' aria-hidden='true'></i>
        </a>
    </div>
</div>

<div class='row'>
    @if(isset($openJourney))
    <div class='col-2 d-inline-block'>
        <form style='text-decoration: none;color: black;display: inline-block' action="{{route('journey.completeFromTask', ['journey' => $openJourney])}}" method="post">
            @csrf
            @method('put')
            <button id='' class=' emergency-display' title='Encerrar tarefa com a data atual' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
                <p class='panel-text pt-2 mb-2'>
                    <i class="fas fa-stopwatch" style="font-size:36px; color:white;padding-bottom: 10px"></i>
                    <br>
                    ENCERRAR JORNADA
                </p>
            </button>
        </form>
    </div>
    @else
    <div class='col-2 d-inline-block'>
        <form style='text-decoration: none;color: black;display: inline-block' action="{{route('journey.storeFromTask', ['taskId' => $task->id])}}" method="post">
            @csrf
            @method('put')
            <button id='' class=' sales-display' title='Iniciar com a data atual' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
                <p class='panel-text pt-2 mb-2'>
                    <i class="fas fa-stopwatch" style="font-size:36px; color:white;padding-bottom: 10px"></i>
                    <br>
                    INICIAR JORNADA
                </p>
            </button>
        </form>
    </div>
    @endif
    @if($task->status == 'fazendo')
    <div class='col-2 d-inline-block'>
        <form style='text-decoration: none;color: black;display: inline-block' action=" {{ route('task.complete', ['task' => $task]) }} " method="post">
            @csrf
            @method('put')
            <button id='' class=' emergency-display' title='Encerrar tarefa com a data atual' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
                <p class='panel-text pt-2 mb-2'>
                    <i class="fas fa-clipboard-check" style="font-size:36px; color:white;padding-bottom: 10px"></i>
                    <br>
                    ENCERRAR TAREFA
                </p>
            </button>
        </form>
    </div>                
    @endif
</div>
@endsection

@section('extraButton')
<form style='text-decoration: none;color: black;display: inline-block' action='{{route('task.destroy', ['task' => $task])}}' method='post'>
    @method('delete')
    @csrf
    <button id='' class='circular-button delete' style='border:none;padding-left:4px' 'type='submit'>
        <i class='fa fa-trash'></i>
    </button>
</form>
@endsection

@section('editButton', route('task.edit', ['task' => $task->id]))

@section('backButton', route('task.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($task->created_at))}}
    </div>
</div>
@endsection
