@extends('layouts/show')

@section('title','TAREFAS')

@section('image-top')
{{asset('images/rocket.png')}}
@endsection

@section('buttons')
{{createButtonBack()}}
<a class='circular-button secondary'  href='{{route('task.pdf', ['task' => $task])}}'>
    <i class='fas fa-print'></i>
</a>
@if($task->status == 'fazendo')
<form style='text-decoration: none;color: black;display: inline-block' action=" {{ route('task.complete', ['task' => $task]) }} " method="post">
    @csrf
    @method('put')
    <button id='' class='circular-button secondary' title='Encerrar tarefa com a data atual' style='border:none;padding-left:4px;padding-top:2px' "type='submit'>
        <i class='fas fa-clipboard-check'></i>
    </button>
</form>
@endif
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
    <div class='show-field-end'>
        @if(isset($task->contact->name))
        {{$task->contact->name}}
        @else
        Não possui
        @endif
    </div>
    <div class='show-field-end'>
        @if(isset($task->company->name))
        {{$task->company->name}}
        @else
        Pessoa física
        @endif
    </div>
    <div class='show-field-end'>
        @isset($task->opportunity->id)
        <a href=' {{route('opportunity.show', ['opportunity' => $task->opportunity])}}'>
            {{$task->opportunity->name}}
            <i class='fa fa-eye' style='color:white'></i>
        </a>
        @else
        Não possui
        @endisset
    </div>
</div>

<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
    <div class='show-label'>
        RESPONSÁVEL
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        {{$task->department}}
    </div>
    <div class='show-field-end'>
        @if(isset($task->user->contact->name))
        {{$task->user->contact->name}}
        @else
        foi excluído
        @endif
    </div>
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
            <a href=' {{route('journey.show', ['journey' => $journey])}}'>
                <i class='fa fa-eye' style='color:white'></i>
            </a>
        </button>
        {{$journey->id}}
    </div>
    <div class='tb col-3'>
        {{$journey->user->contact->name}}
    </div>
    <div class='tb col-4'>
        {!!html_entity_decode($journey->description)!!}
    </div>
    <div class='tb col-1 text-center'>
        @if($journey->date == date('Y-m-d'))
        hoje
        @else
        {{dateBr($journey->date)}}
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
