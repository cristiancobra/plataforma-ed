@extends('layouts/master')

@section('title','TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('task.index')}}">VER TAREFAS</a>
@endsection

@section('main')
<br>
<div style="padding-left: 2%">
	<h1 class="name">
		{{ $task->name }}
	</h1>
	<p class="labels">
		CATEGORIA:
		<span class="fields">{{ $task->category }}</span></p>
	<p class="labels">
		DONO:<span class="fields">{{ $task->account->name }}</span>
	</p>
	<p class="labels">
		RESPONSÁVEL:<span class="fields">{{ $task->user->name }}</span>
	</p>
	<br>
	<br>
	<p class="labels">
		DATA DE CRIAÇÃO:<span class="fields">  {{ date('d/m/Y', strtotime($task->date_start))}}</span>
	</p>
	<p class="labels">
		PRAZO FINAL:<span class="fields">  {{ date('d/m/Y', strtotime($task->date_due))}}</span>
	</p>
	<br>
	<p class="labels">
		DESCRIÇÃO:<span class="fields">  {!!html_entity_decode($task->description)!!} </span>
	</p>
	<br>
	<p class="labels">
		CONTATO:<span class="fields">  {{$task->contact->nam}}</span>
	</p>
	<p class="labels">
		PRIORIDADE:<span class="fields">  {{$task->priority}}</span>
	</p>
	<br>
	<br>
	<label class="labels" for="" >EXECUÇÃO:</label>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 10%">
				<b>ID</b>
			</td>
			<td   class="table-list-header" style="width: 35%">
				<b>FUNCIONÁRIO</b>
			</td>
			<td   class="table-list-header" style="width: 35%">
				<b>OBSERVAÇÕES</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>DATA </b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>INÍCIO </b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>TÉRMINO </b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>DURAÇÃO</b>
			</td>
		</tr>
		@php
		$totalDuration = 0;
		@endphp
		@foreach ($journeys as $journey)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('journey.show', ['journey' => $journey]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('journey.edit', ['journey' => $journey]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{$journey->id}}
			</td>
			<td class="table-list-center">
				{{$journey->user->name}}
			</td>
			<td class="table-list-center">
				{{$journey->description}}
			</td>
			<td class="table-list-center">
				{{date('d/m/Y', strtotime($journey->date))}}
			</td>
		<td class="table-list-center">
			{{date('H:i', strtotime($journey->start_time))}}
		</td>
		<td class="table-list-center">
			@if($journey->end_time == null)
			--
			@else
			{{date('H:i', strtotime($journey->end_time))}}
			@endif
		</td>
			<td class="table-list-center" style="color:white;background-color: #874983">
				{{ gmdate('H:i', $journey->duration) }}
			</td>
		</tr>
		@php
		$totalDuration = $totalDuration + $journey->duration;
		@endphp
		@endforeach
			<tr>
				<td   class="table-list-header" style="text-align: right;padding: 5px;padding-right: 45px;font-size: 16px" colspan="7">
					<b>Tempo total:</b>   {{gmdate('H:i', $totalDuration)}}
					<br>
				</td>
			</tr>
	</table>
	<br>
	<a class="btn btn-secondary" href="{{ route('journey.create', [
				'taskName' => $task->name,
				'taskId' => $task->id,
				'taskUserName' => $task->user->name,
				'taskUserId' => $task->user->id,
				'taskAccountName' => $task->account->name,
				'taskAccountId' => $task->account->id,
				])}}">
		NOVA JORNADA
	</a>
	<br>
	<br>
	<p class="labels">
		inicio:<span class="fields">  {{$task->start_time}} </span>
	</p>
	<p class="labels">
		termino:<span class="fields">  {{$task->end_time}} </span>
	</p>
	<p class="labels">
		data de conclusao:<span class="fields">  {{$task->date_conclusion}} </span>
	</p>

	<br>
	<p class="labels">
		SITUAÇAO:<span class="fields">  {{ $task->status }} </span>
	</p>
	<br>
	<p class="fields">Criado em:  {{ date('d/m/Y H:i', strtotime($task->created_at)) }}
	</p>

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