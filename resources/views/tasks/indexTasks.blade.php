@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalTasks}} </span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('task.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<form action=" {{ route('task.index') }} " method="post" style="text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da tarefa" value="">
	<select class="select" name="account_id">
		@foreach ($accounts as $account)
		<option  class="fields" value="{{$account->id}}">
			{{$account->name}}
		</option>
		@endforeach
		<option  class="fields" value="">
			todas
		</option>
	</select>
	<select class="select" name="contact_id">
		<option  class="fields" value="">
			TODOS
		</option>
		@foreach ($contacts as $contact)
		<option  class="fields" value="{{$contact->id}}">
			{{$contact->name}}
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
			{{ $user->contact->name }}
		</option>
		@endforeach
	</select>
	<select class="select" name="status">
		<option  class="fields" value="fazer">
			fazer
		</option>
		<option  class="fields" value="fazendo">
			fazendo
		</option>
		<option  class="fields" value="aguardar">
			aguardar
		</option>
		<option  class="fields" value="feito">
			feito
		</option>
		<option  class="fields" value="">
			TODAS
		</option>
	</select>
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
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
			@if(isset($task->contact->name))
			{{$task->contact->name}}
			@else
			não possui
			@endif
		</td>

		<td class="table-list-center">
			{{ $task->account->name}}
		</td>

		<td class="table-list-center">
			{{ $task->user->contact->name}}
		</td>
		<td class="table-list-center">
			@if($task->date_due == date('Y-m-d'))
			hoje
			@else
			{{date('d/m/Y', strtotime($task->date_due))}}
			@endif
		</td>
		{{formatPriority($task)}}
		{{formatStatus($task)}}
	</tr>
	@endforeach
</table>
<p style="text-align: right">
	<br>
	{{ $tasks->links() }}
</p>
<br>
@endsection
