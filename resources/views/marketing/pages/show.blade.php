@extends('layouts/show')

@section('title','PÁGINAS')

@section('image-top')
{{asset('images/page.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonEdit('page', 'page', $page)}}
{{createButtonList('page')}}
@endsection

@section('name')
@if($page->task)
{{$page->task->name}}
@else
Tarefa excluída
@endif
@endsection

@section('status')
{{formatShowStatus($page)}}
@endsection

@section('priority')
<div class="to-do">
    {{dateBr($page->start)}}
</div>
@endsection

@section('description')
{!!html_entity_decode($page->description)!!}
@endsection

@section('fieldsId')
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        TAREFA
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
            @if($page->task)
        <a href="{{route('task.show', ['task' => $page->task->id])}}">
            {{$page->task->name}}
        </a>
            @else
            Tarefa excluída
            @endif
    </div>
</div>
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        CONTATO
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        @if($page->task)
        <a href="{{route('contact.show', ['contact' => $page->task->contact->id])}}">
            {{$page->task->contact->name}}
        </a>
        @else
        Tarefa excluída
        @endif
    </div>
</div>
<div class='col-md-2 col-sm-4' style='text-align: center'>
    <div class='show-label'>
        OPORTUNIDADE
    </div>
</div>
<div class='col-md-4 col-sm-8' style='text-align: center'>
    <div class='show-field-end'>
        @if($page->task)
        @if($page->task->opportunity)
        <a href="{{route('opportunity.show', ['opportunity' => $page->task->opportunity->id])}}">
            {{$page->task->opportunity->name}}
        </a>
        @else
        Não possui
        @endif
@else
Tarefa excluída
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
        @if($page->task)
        {{$page->task->department}}
@else
Tarefa excluída
@endif
    </div>
</div>
@endsection


@section('date_start')
<div class="circle-date-start">
@if($page->task)
    {{date('d/m/Y', strtotime($page->task->date_start))}}
@else
--
@endif
</div>
<p class="labels" style="text-align: center">
    CRIAÇÃO DA TAREFA
</p>
@endsection


@section('date_due')
<div class="circle-date-due">
    @if($page->task)
    {{dateBr($page->task->date_due)}}
@else
--
@endif
</div>
<p class="labels" style="text-align: center">
    PRAZO DA TAREFA
</p>
@endsection


@section('date_conclusion')
<div class="circle-date-conclusion">
    @if($page->task)
    @if($page->task->date_conclusion)
    {{dateBr($page->task->date_conclusion)}}
    @else
    <p style="color:white">
        --
    </p>
    @endif
@else
--
@endif
</div>
<p class="labels" style="text-align: center">
    CONCLUSÃO DA TAREFA
</p>
@endsection



@section('main')

@endsection


@section('deleteButton')

@endsection


@section('editButton', route('page.edit', ['page' => $page->id]))

@section('backButton', route('page.index'))

@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{dateBr($page->created_at)}}
    </div>
</div>
@endsection