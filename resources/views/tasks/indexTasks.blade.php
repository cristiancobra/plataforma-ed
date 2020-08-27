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
		<td   class="table-list-header" style="width: 60%">
			<b>NOME</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>RESPONSÁVEL</b>
		</td>

		<td   class="table-list-header" style="width: 10%">
			<b>PRAZO</b>
		</td>

		<td   class="table-list-header" style="width: 10%">
			<b>EXECUÇÃO</b>
		</td>

		<td   class="table-list-header">
			<b>PRIORIDADE</b>
		</td>

		<td   class="table-list-header">
			<b>STATUS</b>
		</td>
	</tr>

	@foreach ($tasks as $task)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<a class="white" href=" {{ route('task.show', ['task' => $task->id]) }}">
				<button class="button">
					<i class='fa fa-eye'></i>
				</button>
			</a>
			<a href=" {{ route('task.edit', ['task' => $task->id]) }}">
				<button class="button">
					<i class='fa fa-edit'></i>
				</button>
			</a>
			{{ $task->name}}
		</td>

		<td class="table-list-center">
			{{ $task->users->name}}
		</td>

		<td class="table-list-center">
			{{ $task->date_due }}
		</td>

		<td class="table-list-center" style="background-color: #874983;color: white">
			{{ date("H:i", strtotime($task->duration)) }}
		</td>

		<td class="table-list-center">
			@if ($task->priority == "baixa")
			<button class="btn btn-info">
				<b>{{ $task->priority  }}</b>
				@elseif ($task->priority == "média")
				<button class="btn btn-warning">
					<b>{{ $task->priority  }}</b>
					@elseif ($task->priority == "alta")
					<button class="btn btn-danger">
						<b>{{ $task->priority  }}</b>
						@elseif ($task->priority == "emergência")
						<button class="btn btn-dark">
							<b>{{ $task->priority  }}</b>
							@endif
						</button>
						</td>

						<td class="table-list-center">
							@if ($task->status == "cancelada")
							<button class="btn btn-dark">
								<b>{{ $task->status  }}</b>
								@elseif ($task->status == "pendente")
								<button class="btn btn-warning">
									<b>{{ $task->status  }}</b>
									@elseif ($task->status == "fazendo agora")
									<button class="btn btn-info">
										<b>{{ $task->status  }}</b>
										@elseif ($task->status == "concluida")
										<button class="btn btn-success">
											<b>{{ $task->status  }}</b>
											@endif
											</td>
											</tr>
											@endforeach
											</table>
											<br>
											@endsection
