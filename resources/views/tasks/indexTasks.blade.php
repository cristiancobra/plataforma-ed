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
		<option  class="select" value="all">
			Qualquer funcionário
		</option>
		@foreach ($users as $user)
		<option  class="select" value="{{ $user->id }}">
			{{ $user->name }}
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
	<input class="button-secondary" type="submit" value="FILTRAR">
</form>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 40%">
			NOME
		</td>
		<td   class="table-list-header" style="width: 15%">
			CONTATO
		</td>
		<td   class="table-list-header" style="width: 15%">
			EMPRESA
		</td>
		<td   class="table-list-header" style="width: 10%">
			RESPONSÁVEL
		</td>
		<td   class="table-list-header" style="width: 10%">
			PRAZO
		</td>
		<td   class="table-list-header" style="width: 5%">
			PRIORIDADE
		</td>
		<td   class="table-list-header" style="width: 5%">
			SITUAÇÃO
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
			{{$task->name}}
		</td>

		<td class="table-list-center">
			@if(isset($task->contact->name))
			{{$task->contact->name}}
			@else
			contato excluído
			@endif
		</td>
		<td class="table-list-center">
			{{$task->account->name}}
		</td>
		<td class="table-list-center">
			@if(isset($task->user->contact->name))
			{{$task->user->contact->name}}
			@else
			funcionário excluído
			@endif
		</td>	
		<td class="table-list-center">
			@if($task->date_due == date('Y-m-d'))
			hoje
			@else
			{{date('d/m/Y', strtotime($task->date_due))}}
			@endif
		</td>
		{{formatPriority($task)}}
		@if($task->status == 'fazer' AND $task->date_due <= date('Y-m-d'))
		<td class="td-late">
			atrasada
		</td>
		@elseif($task->status == 'fazer' AND $task->journeys()->exists())
		<td class="td-doing">
			fazendo
		</td>
		@else
		{{formatStatus($task)}}
		@endif
	</tr>
	@endforeach
</table>
<p style="text-align: right">
	<br>
	{{$tasks->links()}}
</p>
<br>
@endsection
