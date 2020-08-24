@extends('layouts/master')

@section('title','DETALHES DA TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('task.index')}}">VER TAREFAS</a>
@endsection

@section('main')
<br>
<div style="padding-left: 6%">
	<h1 class="name"> {{ $task->name }}  </h1>
	<p class="labels">CATEGORIA:<span class="fields">{{ $task->category }} </span></p>
	<p class="labels">DONO:<span class="fields">{{ $task->users->name }} </span></p>
	<br>
	<p class="labels">DATA DE CRIAÇÃO:<span class="fields">  {{ $task->date_start }} </span></p>
	<p class="labels">PRAZO FINAL:<span class="fields">  {{ $task->date_due }} </span></p>
	<br>
	<p class="labels">DESCRIÇÃO:<span class="fields">  {{ $task->description }} </span></p>
	<p class="labels">CONTATO:<span class="fields">  {{ $task->contact_Id }} </span></p>
	<p class="labels">PRIORIDADE:<span class="fields">  {{ $task->priority }} </span></p>
	<br>
	<p class="labels">INÍCIO:<span class="fields">  {{ $task->start_time }} </span></p>
	<p class="labels">TÉRMINO:<span class="fields">  {{ $task->end_time }} </span></p>
	<p class="labels">DURAÇÃO:<span class="fields">  {{ $task->duration }} hora(s)</span></p>
	<br>
	<p class="labels">SITUAÇAO:<span class="fields">  {{ $task->status }} </span></p>
	<br>
	<p class="fields">Criado em:  {{ date('d/m/Y H:i', strtotime($task->created_at)) }} </p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('task.destroy', ['task' => $task->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('task.edit', ['task' => $task->id]) }}">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('task.index')}}">VOLTAR</a>
	</div>
</div>
@endsection