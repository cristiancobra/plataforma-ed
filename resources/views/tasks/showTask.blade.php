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
<div style="padding-left: 6%">
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
			<td   class="table-list-header" style="width: 5%">
				<b>ID</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>DATA </b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>TEMPO</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>SITUAÇÃO</b>
			</td>
		</tr>

		@foreach ($journeys as $journey)
		<tr style="font-size: 14px">
			<td class="table-list-center">
				<button class="button">
					<a href=" {{ route('journey.show', ['journey' => $journey->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('journey.edit', ['journey' => $journey->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $journey->id }}
			</td>

			<td class="table-list-center">
				{{ date('d/m/Y', strtotime($journey->date)) }}
			</td>

			<td class="table-list-center">
				{{ gmdate('H:i', $journey->duration) }}
			</td>

			<td class="table-list-center">
				@if ($journey->status == "cancelada")
				<button class="btn btn-dark">
					<b>{{ $journey->status  }}</b>
				</button>
				@elseif ($journey->status == "pendente")
				<button class="btn btn-warning">
					<b>{{ $journey->status  }}</b>
				</button>
				@elseif ($journey->status == "fazendo agora")
				<button class="btn btn-info">
					<b>{{ $journey->status  }}</b>
				</button>
				@elseif ($journey->status == "concluida")
				<button class="btn btn-success">
					<b>{{ $journey->status  }}</b>
				</button>
				@endif
			</td>
		</tr>
		@endforeach
	</table>
	<br>
	<a class="btn btn-secondary" href="{{ route('journey.create', ['taskName' => $task->user->name, 'taskUser' => $task->user->name])}}">
		NOVA JORNADA
	</a>
	<br>
	<br>
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