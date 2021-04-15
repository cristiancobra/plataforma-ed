@extends('layouts/show')

@section('title','TAREFAS')

@section('image-top')
{{asset('imagens/tarefas.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('task.pdf', ['task' => $task])}}">
    <i class="fas fa-print"></i>
</a>
<a class="circular-button primary"  href="{{route('task.index')}}">
    <i class="fas fa-arrow-left"></i>
</a>
@endsection

@section('name', $task->name)

@section('priority')
{{formatShowPriority($task)}}
@endsection

@section('status')
@if($task->status == 'fazer' AND $task->journeys()->exists())
<div class="doing">
    fazendo
</div>
@else
{{formatShowStatus($task)}}
@endif
@endsection

@section('date_start')
<div class="circle-date-start">
    {{date('d/m/Y', strtotime($task->date_start))}}
</div>
<p class="labels" style="text-align: center">
    CRIAÇÃO
</p>
@endsection

@section('date_due')
<div class="circle-date-due">
    {{date('d/m/Y', strtotime($task->date_due))}}
</div>
<p class="labels" style="text-align: center">
    PRAZO
</p>
@endsection

@section('date_conclusion')
<div class="circle-date-conclusion">
    @if($task->date_conclusion)
    {{date('d/m/Y', strtotime($task->date_conclusion))}}
@else
<p style="color:white">
--
</div>
@endif
<p class="labels" style="text-align: center">
    CONCLUSÃO
</p>
@endsection