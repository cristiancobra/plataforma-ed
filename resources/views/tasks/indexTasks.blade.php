@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('task.create') }}">NOVA TAREFA</a>
@endsection

@section('main')
<form action=" {{ route('task.filter') }} " method="post" style="padding: 40px;text-align: right;color: #874983">
	@csrf
	<label class="labels" for="" >SITUAÇÃO:</label>
	<select name="status">
		<option  class="fields" value="todos">
			todos
		</option>
		<option  class="fields" value="fazendo agora">
			fazendo agora
		</option>
		<option  class="fields" value="pendente">
			pendentes
		</option>
		<option  class="fields" value="concluida">
			concluidas
		</option>
	</select>
	<label class="labels" for="" >CONTATO:</label>
	<select name="contact_id">
		<option  class="fields" value="todos">
			todos
		</option>
		@foreach ($contacts as $contact)
		<option  class="fields" value="{{ $contact->id }}">
			{{ $contact->name }}
		</option>
		@endforeach
	</select>
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 40%">
			<b>NOME</b>
		</td>

		<td   class="table-list-header" style="width: 15%">
			<b>CONTATO</b>
		</td>

		<td   class="table-list-header" style="width: 15%">
			<b>EMPRESA</b>
		</td>

		<td   class="table-list-header" style="width: 10%">
			<b>RESPONSÁVEL</b>
		</td>

		<td   class="table-list-header" style="width: 10%">
			<b>PRAZO</b>
		</td>

		<td   class="table-list-header" style="width: 5%">
			<b>PRIORIDADE</b>
		</td>

		<td   class="table-list-header" style="width: 5%">
			<b>STATUS</b>
		</td>
	</tr>

	@foreach ($tasks as $task)
	<tr style="font-size: 14px">
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
			{{ $task->contact->name}}
		</td>

		<td class="table-list-center">
			{{ $task->account->name}}
		</td>

		<td class="table-list-center">
			{{ $task->user->name}}
		</td>

		<td class="table-list-center">
			{{ $task->date_due }}
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
										</button>
										</td>
										</tr>
										@endforeach
										</table>
										<p style="text-align: right">
											<br>
											{{ $tasks->links() }}
										</p>
										<br>
										@endsection
