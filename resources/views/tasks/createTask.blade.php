@extends('layouts/master')

@section('title','NOVA TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('task.index') }}">VER PÁGINAS</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('task.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME DA TAREFA:</label>
		<input type="text" name="name" size="20"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >CATEGORIA:</label>
		<select class="fields" name="category">
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
		<input type="date" name="date_start" size="20"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >PRAZO FINAL:</label>
		<input type="date" name="date_due" size="20"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<input type="text" name="description" size="50" style="width: 100%;height: 200px"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >CONTATO:</label>
		<input type="text" name="contatc_id" size="50"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >PRIORIDADE:</label>
		<input type="text" name="priority" size="50"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >
			INÍCIO: 
		</label>
		<input type="time" name="start_time" size="50"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">
			TÉRMINO: 
			<br>
		</label>
		<input type="time" name="end_time" size="50"><span class="fields"></span>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR TAREFA">
	</form>
</div>     
@endsection