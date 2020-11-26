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
	<select class="select" name="account_id">
		@foreach ($accounts as $account)
		<option  class="fields" value="{{ $account->id }}">
			{{ $account->name }}
		</option>
		@endforeach
		<option  class="fields" value="">
			todas
		</option>
	</select>
	<select class="select"name="user_id">
		<option  class="fields" value="{{$userAuth->id}}">
			minhas tarefas
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
	<select class="select" name="status">
		<option  class="fields" value="fazendo agora">
			fazendo
		</option>
		<option  class="fields" value="pendente">
			fazer
		</option>
		<option  class="fields" value="stuck">
			aguardar
		</option>
		<option  class="fields" value="concluida">
			feito
		</option>
		<option  class="fields" value="">
			TODAS
		</option>
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
			<b>SITUAÇÃO</b>
		</td>
	</tr>

	@foreach ($tasks as $task)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<a class="white" href=" {{ route('task.show', ['task' => $task->id]) }}">
				<button class="button-round">
					<i class='fa fa-eye'></i>
				</button>
			</a>
			<a href=" {{ route('task.edit', ['task' => $task->id]) }}">
				<button class="button-round">
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
			@if($task->date_due == date('Y-m-d'))
			hoje
			@else
			{{date('d/m/Y', strtotime($task->date_due))}}
			@endif
		</td>

		@if ($task->priority == "baixa")
		<td class="td-low">
			baixa
		</td>
		@elseif ($task->priority == "média")
		<td class="td-medium">
			média
		</td>
		@elseif ($task->priority == "alta")
		<td class="td-high">
			alta
		</td>
		@elseif ($task->priority == "emergência")
		<td class="td-emergency">
			emergência
		</td>
		@endif

		@if ($task->status == "cancelada")
		<td class="td-low">
			cancelada
		</td>
		@elseif ($task->status == "pendente")
		<td class="td-toDo">
			fazer
		</td>
		@elseif ($task->status == "fazendo agora")
		<td class="td-doing">
			fazendo
		</td>
		@elseif ($task->status == "concluida")
		<td class="td-done">
			feito
		</td>
		@elseif ($task->status == "aguardando")
		<td class="td-stuck">
			aguardar
		</td>
		@endif
	</tr>
	@endforeach
</table>
<p style="text-align: right">
	<br>
	{{ $tasks->links() }}
</p>
<br>
@endsection
