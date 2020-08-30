@extends('layouts/master')

@section('title','NOVA TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('task.index') }}">VER TAREFAS</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('task.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME DA TAREFA:</label>
		<input type="text" name="name" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >CATEGORIA:</label>
		<select class="fields" name="category">
			<option value="desenvolvimento">desenvolvimento</option>
			<option value="financeiro">financeiro</option>
			<option value="marketing">marketing</option>
			<option value="planejamento">planejamento</option>
			<option value="serviço">serviço</option>
			<option value="suporte">suporte</option>
			<option value="venda">venda</option>
		</select>
		<br>
		<label class="labels" for="" >RESPONSÁVEL: </label>
		<select name="user_id">
			<option  class="fields" value="{{ $userAuth->id }}">
				{{ $userAuth->name }}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >PRAZO FINAL:</label>
		<input type="date" name="date_due" size="20"><span class="fields"></span>
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
		<br>
		<label class="labels" for="" >CONTATO:</label>
		<input type="text" name="contact_id" size="50"><span class="fields"></span>
		<br>
		<label class="labels" for="" >PRIORIDADE:</label>
		<select class="fields" name="priority">
			<option value="baixa">baixa</option>
			<option value="média">média</option>
			<option value="alta">alta</option>
			<option value="emergência">emergência</option>
		</select>
		<br>
		<br>
		<label class="labels" for="" >
			INÍCIO: 
		</label>
		<input type="time" name="start_time" size="50"><span class="fields"></span>
		<br>
		<label class="labels" for="">
			TÉRMINO: 
			<br>
		</label>
		<input type="time" name="end_time" size="50"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="pendente">pendente</option>
			<option value="fazendo agora">fazendo agora</option>
			<option value="cancelada">cancelada</option>
			<option value="concluida">concluida</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR TAREFA">
	</form>
</div>     
@endsection