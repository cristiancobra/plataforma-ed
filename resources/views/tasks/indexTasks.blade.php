@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('task.create') }}">NOVA TAREFA</a>
@endsection

@section('main')
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 25%">
			<b>Nome</b>
		</td>
		<td   class="table-list-header" style="width: 50%">
			<b>Descrição </b>
		</td>
		<td   class="table-list-header" style="width: 15%">
			<b>Responsável</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>Status</b>
		</td>
	</tr>

	@foreach ($tasks as $task)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button">
				<a href=" {{ route('task.show', ['task' => $task->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $task->name}}
		</td>

		<td class="table-list-left">
			{{ $task->description}}
		</td>

		<td class="table-list-center">
			{{ $task->users->name}}
		</td>

		@if ($task->status == "cancelada")
		<td class="btn btn-dark"><b>{{ $task->status  }}</b></td>
		@elseif ($task->status == "pendente")
		<td class="btn btn-warning"><b>{{ $task->status  }}</b></td>
		@elseif ($task->status == "fazendo agora")
		<td class="btn btn-info"><b>{{ $task->status  }}</b></td>
		@elseif ($task->status == "concluida")
		<td class="btn btn-success"><b>{{ $task->status  }}</b></td>
		@endif
</tr>
<tr>
	<td class="table-list-center">
		<label class="labels" for="" >
			DATA DE CRIAÇÃO:
			<br>
			{{ $task->date_start }}
		</label>
	</td>

	<td class="table-list-center">
		<label class="labels" for="" >
			PRAZO FINAL: 
			<br>
			{{ $task->date_due }}
		</label>
	</td>

	<td class="table-list-center" style="background-color: #874983">
		<label class="labels" for="" style="color: white;text-align: center">
			INÍCIO: 
			<br>
			{{ $task->start_time }}
		</label>
	</td>

	<td class="table-list-center" style="background-color: #874983">
		<label class="labels" for="" style="color: white;text-align: center">
			TÉRMINO: 
			<br>
			{{ $task->end_time }}
		</label>
	</td>

</tr>
<tr>
	<td>
		<br>
		<br>
	</td>
</tr>
@endforeach
</table>
<br>
@endsection
