@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('task.create') }}">NOVA TAREFA</a>
@endsection

@section('main')
<form action=" {{ route('task.index') }} " method="post" style="padding: 20px;text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da tarefa" value="">
	<select class="select" name="status">
		<option  class="fields" value="">
			situação
		</option>
		<option  class="fields" value="">
			TODAS
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
	<select class="select" name="contact_id">
		<option  class="fields" value="">
			contatos
		</option>
		<option  class="fields" value="">
			TODOS
		</option>
		@foreach ($contacts as $contact)
		<option  class="fields" value="{{ $contact->id }}">
			{{ $contact->name }}
		</option>
		@endforeach
	</select>
	<select class="select"name="user_id">
		<option  class="fields" value="">
			responsável
		</option>
		<option  class="fields" value="">
			TODOS
		</option>
		@foreach ($users as $user)
		<option  class="fields" value="{{ $user->id }}">
			{{ $user->name }}
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
		<td   class="table-list-header" style="width: 13%">
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
		<td   class="table-list-header" style="width: 3%">
			<b>EXECUÇÃO</b>
		</td>
		<td   class="table-list-header" style="width: 3%">
			<b>EXECUÇÃO</b>
		</td>
		<td   class="table-list-header" style="width: 5%">
			<b>PRIORIDADE</b>
		</td>
		<td   class="table-list-header" style="width: 5%">
			<b>SITUAÇÃO</b>
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
			<b>{{ $task->name}}</b>
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
			{{ date('d/m/Y', strtotime($task->date_due)) }}
		</td>
		<td class="table-list-center" style="color:white;background-color: #874983">
			{{ gmdate('H:i', $task->duration) }}
		</td>
		<td class="table-list-center" style="color:white;background-color: #c28dbf">
			{{ gmdate('H:i', $task->duration) }}
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
