@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('imagens/journey.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('journey.index')}}">
	VOLTAR
</a>
@endsection

@section('main')

@if(Session::has('failed'))
<div class="alert alert-danger">
	{{Session::get('failed')}}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{route('journey.store')}} " method="post" style="color: #874983">
		@csrf
		<label class="labels" for="" >EMPRESA: </label>
		@if(!empty(app('request')->input('taskAccountId')))
		{{app('request')->input('taskAccountName')}}
		<input type="hidden" name="account_id" value="{{app('request')->input('taskAccountId')}}">
		@else
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
			@endif
		</select>
		<br>
		<label class="labels" for="" >FUNCIONÁRIO: </label>
		{{Auth::user()->contact->name}}
		<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
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
		<textarea id="description" name="description" rows="10" cols="90">
                                    {{old('description')}}
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
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR">
	</form>
</div>     
@endsection