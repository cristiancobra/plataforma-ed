@extends('layouts/master')

@section('title','TAREFAS')

@section('image-top')
{{ asset('imagens/tarefas.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('task.index')}}">
	VOLTAR
</a>
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
	<form action=" {{ route('task.store') }} " method="post" style="color: #874983">
		@csrf
		<label class="labels" for="" >NOME:</label>
		@if(!empty(app('request')->input('taskName')))
		{{app('request')->input('taskName')}}
		<input type="hidden" name="name"value="{{app('request')->input('taskName')}}">
		@else
		<input type="text" name="name" value="{{old('name')}}">
		@endif
		<br>
		<label class="labels" for="" >EMPRESA:</label>
		@if(!empty(app('request')->input('taskAccountName')))
		{{app('request')->input('taskAccountName')}}
		<input type="hidden" name="account_id" value="{{app('request')->input('taskAccountId')}}">
		@else
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		@endif
		<br>
		@if(!empty(app('request')->input('opportunityName')))
		<label class="labels" for="" >OPORTUNIDADE:</label>
		{{app('request')->input('opportunityName')}}
		<input type="hidden" name="opportunity_id" value="{{app('request')->input('opportunityId')}}">
		<br>
		@endif
		<label class="labels" for="" >DEPARTAMENTO:</label>
		@if(!empty(app('request')->input('department')))
		{{app('request')->input('department')}}
		<input type="hidden" name="department"value="{{app('request')->input('department')}}">
		@elseif($errors->has('department'))
		<span class="text-danger">{{$errors->first('department')}}</span>
		@else
		<select class="fields" name="department">
		{{createSimpleSelect($departments)}}
		</select>
		@endif
		<br>
		<label class="labels" for="" >RESPONSÁVEL: </label>
		<select name="user_id">
			<option  class="fields" value="{{Auth::user()->id}}">
				Eu
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->contact_id}}">
				{{$user->contact->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_start" value="{{$today}}">
		@if ($errors->has('date_start'))
		<span class="text-danger">{{ $errors->first('date_start') }}</span>
		@endif
		<br>
		<label class="labels" for="" >PRAZO FINAL:</label>
		<input type="date" name="date_due" value="{{old('date_due')}}">
		@if ($errors->has('date_due'))
		<span class="text-danger">{{$errors->first('date_due')}}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<br>
		@if ($errors->has('description'))
		<span class="text-danger">{{$errors->first('description')}}</span>
		@endif
		<textarea id="description" name="description" rows="20" cols="90"  value="{{old('description')}}">
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
			@if(!empty(app('request')->input('opportunityContactName')))
			<option  class="fields" value="{{app('request')->input('opportunityContactId')}}">
				{{app('request')->input('opportunityContactName')}}
			</option>
			@endif
			@foreach ($contacts as $contact)
			<option  class="fields" value="{{$contact->id}}">
				{{$contact->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >PRIORIDADE:</label>
		<select class="fields" name="priority">
		{{createSimpleSelect($priorities)}}
		</select>
		<br>
		<br>

		<input class="btn btn-secondary" type="submit" value="CRIAR TAREFA">
	</form>
</div>
<br>
<br>
@endsection