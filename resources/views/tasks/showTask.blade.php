@extends('layouts/master')

@section('title','TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('task.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">
		{{$task->name}}
	</h1>
	<p class="labels">
		EMPRESA:<span class="fields">{{ $task->account->name }}</span>
	</p>
	<p class="labels">
		DEPARTAMENTO:
		<span class="fields">{{$task->department}}</span>
	</p>
	<p class="labels">
		OPORTUNIDADE:
		@isset($task->opportunity->id)
		<span class="fields">{{$task->opportunity->name}}</span>
		<button class="button-round">
			<a href=" {{route('opportunity.show', ['opportunity' => $task->opportunity])}}">
				<i class='fa fa-eye' style="color:white"></i>
			</a>
		</button>
		@else
		Não possui
		@endisset
	</p>
	<p class="labels">
		@if(isset($task->user->name))
		RESPONSÁVEL:<span class="fields">  {{$task->user->contact->name}}</span>
		@else
		RESPONSÁVEL:<span class="fields"> foi excluído</span>
		@endif
	</p>
	<br>
	<br>
	<p class="labels">
		DATA DE CRIAÇÃO:<span class="fields">  {{date('d/m/Y', strtotime($task->date_start))}}</span>
	</p>
	<p class="labels">
		PRAZO FINAL:<span class="fields">  {{ date('d/m/Y', strtotime($task->date_due))}}</span>
	</p>
	<p class="labels">
		DATA DE CONCLUSÃO:<span class="fields">
			@if($task->date_conclusion)
			{{date('d/m/Y', strtotime($task->date_conclusion))}}</span>
		@else
		não concluída
		@endif
	</p>
	<br>
	<p class="labels">
		DESCRIÇÃO:<span class="fields">  {!!html_entity_decode($task->description)!!} </span>
	</p>
	<br>
	<p class="labels">
		@if(isset($task->contact->name))
		CONTATO:<span class="fields">  {{$task->contact->name}}</span>
		@else
		CONTATO:<span class="fields"> foi excluído</span>
		@endif
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
			<td   class="table-list-header" style="width: 15%">
				<b>ID</b>
			</td>
			<td   class="table-list-header" style="width: 20%">
				<b>FUNCIONÁRIO</b>
			</td>
			<td   class="table-list-header" style="width: 45%">
				<b>OBSERVAÇÕES</b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>DATA </b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>INÍCIO </b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>TÉRMINO </b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>DURAÇÃO</b>
			</td>
		</tr>
		@php
		$totalDuration = 0;
		@endphp
		@foreach ($task->journeys as $journey)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('journey.show', ['journey' => $journey]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button-round">
					<a href=" {{ route('journey.edit', ['journey' => $journey]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{$journey->id}}
			</td>
			<td class="table-list-center">
				{{$journey->user->contact->name}}
			</td>
			<td class="table-list-left">
				{!!html_entity_decode($journey->description)!!}
			</td>
			<td class="table-list-center">
				@if($journey->date == date('Y-m-d'))
				hoje
				@else
				{{date('d/m/Y', strtotime($journey->date))}}
				@endif
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
			<td   class="table-list-header" style="text-align: right;padding: 5px;padding-right: 25px;font-size: 16px" colspan="7">
				<b>Tempo total:</b>   {{ number_format($totalDuration / 3600, 1, ',','.')  }}
				<br>
			</td>
		</tr>
	</table>
	<br>
	<a class="btn btn-secondary" href="{{route('journey.create', [
				'taskName' => $task->name,
				'taskId' => $task->id,
				'taskAccountName' => $task->account->name,
				'taskAccountId' => $task->account->id,
				])}}">
		NOVA JORNADA
	</a>
	<br>
	<br>
	<p class="labels">
		SITUAÇAO:<span class="fields">  {{$task->status}}</span>
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