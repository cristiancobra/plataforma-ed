@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('imagens/journey.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('journey.index') }}">VER JORNADAS</a>
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
	<form action=" {{ route('journey.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			<option  class="fields" value="{{app('request')->input('taskAccountId')}}">
				{{app('request')->input('taskAccountName')}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >FUNCIONÁRIO: </label>
		<select name="user_id">
			<option  class="fields" value="{{app('request')->input('taskUserId')}}">
				{{app('request')->input('taskUserName')}}
			</option>
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
		<label class="labels" for="" >TAREFA: </label>
		@if(isset($task))
		{{app('request')->input('taskName')}}
		<input type="hidden" name="name" value="{{app('request')->input('taskName')}}">
		@else
		<select name="task_id">
			<option  class="fields" value="{{app('request')->input('taskId')}}">
				{{app('request')->input('taskName')}}
			</option>
			@foreach ($tasks as $task)
			<option  class="fields" value="{{ $task->id }}">
				{{ $task->name }}
			</option>
			@endforeach
		</select>
		<a class="btn btn-secondary" href="{{ route('task.create') }}" target="blank">NOVA TAREFA</a>
		@endif
		<br>
		<br>
		<label class="labels" for="" >OBSERVAÇÕES:</label>
		<br>
		@if ($errors->has('description'))
		<span class="text-danger">{{ $errors->first('description') }}</span>
		@endif
		<textarea id="description" name="description" rows="10" cols="90"  value="{{old('description')}}">
		{{ $journey->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="" >DATA:</label>
		<input type="date" name="date" value="{{old('date')}}">
		@if ($errors->has('date'))
		<span class="text-danger">{{ $errors->first('date') }}</span>
		@endif
		<br>
		<label class="labels" for="" >
			INÍCIO: 
		</label>
		<input type="time" name="start_time" size="50" value="{{old('start_time')}}"><span class="fields"></span>
		@if ($errors->has('start_time'))
		<span class="text-danger">{{ $errors->first('start_time') }}</span>
		@endif
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
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR">
	</form>
</div>     
@endsection