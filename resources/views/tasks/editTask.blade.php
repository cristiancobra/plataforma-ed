@extends('layouts/master')

@section('title','EDITAR TAREFA')

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('task.index')}}">
	CRIAR
</a>
@endsection

@section('main')
<br>
<form action=" {{route('task.update', ['task' =>$task->id])}} " method="post" style="color: #874983">
	@csrf
	@method('put')
	<div>
		<label class="labels" for="" >NOME DA TAREFA:</label>
		<input type="text" name="name" size="20" value="{{$task->name}}"><span class="fields"></span><br>
		<label class="labels" for="" >DEPARTAMENTO:</label>
		<select class="fields" name="department">
			<option value="{{$task->department}}">{{$task->department}}</option>
		{{createSimpleSelect($departments)}}
		</select>
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $task->account->id }}">
				{{ $task->account->name }}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >RESPONSÁVEL: </label>
		<select name="user_id">
			<option  class="fields" value="{{ $task->user->id }}">
				{{ $task->user->name }}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->contact->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20" value="{{ $task->date_start }}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >PRAZO FINAL:</label>
		<input type="date" name="date_due" size="20" value="{{ $task->date_due }}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $task->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<label class="labels" for="" >CONTATO: </label>
		<select name="contact_id">
			<option  class="fields" value="{{ $task->contact_id }}">
				{{ $task->contact->name }}
			</option>
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{ $contact->id }}">
				{{ $contact->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >PRIORIDADE:</label>
		<select class="fields" name="priority">
			<option  class="fields" value="{{ $task->priority }}">
				{{ $task->priority }}
			</option>
			{{createSimpleSelect($priorities)}}
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CONCLUSÃO:</label>
		<input type="date" name="date_conclusion" size="20" value="{{ $task->date_conclusion }}"><span class="fields"></span>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="{{ $task->status }}">{{ $task->status}}</option>
		{{createSimpleSelect($status)}}
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR TAREFA">
		</form>
	</div>     
	@endsection
