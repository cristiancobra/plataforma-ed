@extends('layouts/master')

@section('title','EDITAR TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('task.index')}}">VER TAREFAS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('task.update', ['task' =>$task->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >NOME DA TAREFA:</label>
		<input type="text" name="name" size="20" value="{{ $task->name }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >CATEGORIA:</label>
		<select class="fields" name="category">
			<option value="{{ $task->category }}">{{ $task->category }}</option>
			<option value="atendimento">atendimento</option>
			<option value="desenvolvimento">desenvolvimento</option>
			<option value="financeiro">financeiro</option>
			<option value="marketing">marketing</option>
			<option value="organização">organização</option>
			<option value="planejamento">planejamento</option>
			<option value="serviço">serviço</option>
			<option value="suporte">suporte</option>
			<option value="venda">venda</option>
		</select>
		<br>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="user_id">
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20" value="{{ $task->date_start }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >PRAZO FINAL:</label>
		<input type="date" name="date_due" size="20" value="{{ $task->date_due }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<input type="text" name="description" size="50"  value="{{ $task->description }}" style="width: 100%;height: 200px"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >CONTATO:</label>
		<input type="text" name="contact_id" size="50"  value="{{ $task->contact_id }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >PRIORIDADE:</label>
		<input type="text" name="priority" size="50"  value="{{ $task->priority }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="">
			INÍCIO: 
		</label>
		<input type="time" name="start_time" size="50"  value="{{ $task->start_time }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="">
			TÉRMINO: 
			<br>
		</label>
		<input type="time" name="end_time" size="50"  value="{{ $task->end_time }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="{{ $task->status }}">{{ $task->status}}</option>
			@if ($task->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($task->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($task->status == "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR TAREFA">
		</form>
	</div>     
	@endsection
