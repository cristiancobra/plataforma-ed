@extends('layouts/master')

@section('title','NOVA TAREFA')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('task.index') }}">VER TAREFAS</a>
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
	{{ Session::get('failed') }}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{ route('task.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME DA TAREFA:</label>
		<input type="text" name="name" value="{{old('name')}}">
		@if ($errors->has('name'))
		<span class="text-danger">{{ $errors->first('name') }}</span>
		@endif
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
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
		<input type="date" name="date_start" value="{{old('date_start')}}">
		@if ($errors->has('date_start'))
		<span class="text-danger">{{ $errors->first('date_start') }}</span>
		@endif
		<br>
		<label class="labels" for="" >PRAZO FINAL:</label>
		<input type="date" name="date_due" value="{{old('date_due')}}">
		@if ($errors->has('date_due'))
		<span class="text-danger">{{ $errors->first('date_due') }}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<br>
		@if ($errors->has('description'))
		<span class="text-danger">{{ $errors->first('description') }}</span>
		@endif
		<textarea id="description" name="description" rows="20" cols="90"  value="{{old('description')}}">
		{{ $task->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="" >CONTATO: </label>
		<select name="contact_id">
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{ $contact->id }}">
				{{ $contact->name }}
			</option>
			@endforeach
		</select>
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
		<input type="time" name="start_time" size="50">{{old('start_time')}}<span class="fields"></span>
		<br>
		<label class="labels" for="">
			TÉRMINO: 
			<br>
		</label>
		<input type="time" name="end_time" size="50">{{old('end_time')}}<span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DE CONCLUSÃO:</label>
		<input type="date" name="date_conclusion" size="20">{{old('date_conclusion')}}<span class="fields"></span>
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