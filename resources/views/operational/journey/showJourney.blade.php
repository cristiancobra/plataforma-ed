@extends('layouts/show')

@section('title','JORNADA')

@section('image-top')
{{asset('imagens/journey.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
<form style='text-decoration: none;color: black;display: inline-block' action=" {{ route('journey.complete', ['journey' => $journey]) }} " method="post">
    @csrf
    @method('put')
    <button id='' class='circular-button secondary' style='border:none;padding-left:7px;padding-top: -4px' "type='submit'>
        <i class='fa fa-check-square'></i>
    </button>
</form>
{{createButtonList('journey')}}
@endsection

@section('name')
{{$journey->task->name}}
@endsection

@section('status')
{{formatShowStatus($journey)}}
@endsection

@section('priority')
<div class="to-do">
    {{dateBr($journey->start)}}
</div>
@endsection

@section('description')
{!!html_entity_decode($journey->description)!!}
@endsection

@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        TAREFA
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        <a href="{{route('task.show', ['task' => $journey->task->id])}}">
            {{$journey->task->name}}
        </a>
    </div>
</div>
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        CONTATO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        <a href="{{route('contact.show', ['contact' => $journey->task->contact->id])}}">
            {{$journey->task->contact->name}}
        </a>
    </div>
</div>
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        OPORTUNIDADE
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        @if($journey->task->opportunity)
        <a href="{{route('opportunity.show', ['opportunity' => $journey->task->opportunity->id])}}">
            {{$journey->task->opportunity->name}}
        </a>
        @else
        Não possui
        @endif
    </div>
</div>
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        DEPARTAMENTO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        {{$journey->task->department}}
    </div>
</div>
@endsection


@section('date_start')
<div class="circle-date-start">
    {{date('d/m/Y', strtotime($journey->task->date_start))}}
</div>
<p class="labels" style="text-align: center">
    CRIAÇÃO DA TAREFA
</p>
@endsection


@section('date_due')
<div class="circle-date-due">
    {{dateBr($journey->task->date_due)}}
</div>
<p class="labels" style="text-align: center">
    PRAZO DA TAREFA
</p>
@endsection


@section('date_conclusion')
<div class="circle-date-conclusion">
    @if($journey->task->date_conclusion)
    {{dateBr($journey->task->date_conclusion)}}
    @else
    <p style="color:white">
        --
    </p>
    @endif
</div>
<p class="labels" style="text-align: center">
    CONCLUSÃO DA TAREFA
</p>
@endsection



@section('execution')
<div class='row'>
    <div class='col-1 tb tb-header'>
        DATA
    </div>
    <div class='tb tb-header col-8'>
        QUEM EXECUTOU
    </div>
    <div class='tb tb-header col-1'>
        INÍCIO
    </div>
    <div class='tb tb-header col-1'>
        FIM
    </div>
    <div class='tb tb-header col-1'>
        DURAÇÃO
    </div>
</div>
<div class="row">
    <div class='tb col-1'>
        @if($journey->date == date('Y-m-d'))
        hoje
        @else
        {{dateBr($journey->date)}}
        @endif
    </div>
    <div class='tb col-8 justify-content-start'>
        <a href="{{route('contact.show', ['contact' => $journey->user->contact->id])}}">
            {{$journey->user->contact->name}}
        </a>
    </div>
    <div class='tb col-1'>
        {{date('H:i', strtotime($journey->start))}}
    </div>
    <div class='tb col-1'>
        @if($journey->end == null)
        --
        @else
        {{date('H:i', strtotime($journey->end))}}
        @endif
    </div>
    <div class='tb col-1' style='color:white;background-color: #874983;border-color: white'>
        {{gmdate('H:i', $journey->duration)}}
    </div>
</div>
@endsection


@section('deleteButton')

@endsection

@section('extraButton')
<form style='text-decoration: none;color: black;display: inline-block' action='{{route('journey.destroy', ['journey' => $journey])}}' method='post'>
    @method('delete')
    @csrf
    <button id='' class='circular-button delete' style='border:none;padding-left:4px' "type='submit'>
        <i class='fa fa-trash'></i>
    </button>
</form>
<form style='text-decoration: none;color: black;display: inline-block' action=" {{route('journey.complete', ['journey' => $journey])}} " method="post">
    @method('put')
    @csrf
    <button id='' class='circular-button secondary' style='border:none;padding-left:7px;padding-top: -2px' "type='submit'>
        <i class='fa fa-check-square'></i>
    </button>
</form>
@endsection

@section('editButton', route('journey.edit', ['journey' => $journey->id]))

@section('backButton', route('journey.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{dateBr($journey->created_at)}}
    </div>
</div>
@endsection