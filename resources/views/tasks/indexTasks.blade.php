@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('task.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<form action="{{route('task.index')}}" method="post" style="text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da tarefa" value="">
	<select class="select" name="account_id">
		<option  class="select" value="">
			Qualquer empresa
		</option>
		@foreach ($accounts as $account)
		<option  class="select" value="{{$account->id}}">
			{{$account->name}}
		</option>
		@endforeach
		<option  class="select" value="">
			todas
		</option>
	</select>
	<select class="select" name="contact_id">
		<option  class="select" value="">
			Qualquer contato
		</option>
		@foreach ($contacts as $contact)
		<option  class="select" value="{{$contact->id}}">
			{{$contact->name}}
		</option>
		@endforeach
		<option  class="fields" value="">
			todas
		</option>
	</select>
	<select class="select"name="user_id">
		<option  class="select" value="">
			Qualquer funcionário
		</option>
		@foreach ($users as $user)
		<option  class="select" value="{{ $user->id }}">
			{{ $user->contact->name }}
		</option>
		@endforeach
	</select>
	<select class="select" name="status">
		<option  class="select" value="">
			Todas situações
		</option>
		<option  class="select" value="fazer">
			fazer
		</option>
		<option  class="select" value="aguardar">
			aguardar
		</option>
		<option  class="select" value="feito">
			feitas
		</option>
		<option  class="select" value="cancelado">
			canceladas
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
			{{$task->account->name}}
		</td>

		<td class="table-list-center">
			{{$task->user->contact->name}}
		</td>
		<td class="table-list-center">
			@if($task->date_due == date('Y-m-d'))
			hoje
			@else
			{{date('d/m/Y', strtotime($task->date_due))}}
			@endif
		</td>
		{{formatPriority($task)}}
		@if($task->journeys()->exists())
		<td class="td-doing">
			andamento
		</td>
		@elseif($task->status == 'fazer' AND $task->date_due <= $today)
		<td class="td-late">
			atrasada
		</td>
		@else
		{{formatStatus($task)}}
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
