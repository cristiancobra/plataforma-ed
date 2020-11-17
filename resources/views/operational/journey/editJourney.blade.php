@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('imagens/journeys.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('journey.index')}}">VER TODOS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('journey.update', ['journey' =>$journey->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
		<div>
			<form action=" {{ route('journey.store') }} " method="post" style="padding: 40px;color: #874983">
				@csrf
				<label class="labels" for="" >EMPRESA: </label>
				<select name="account_id">
					<option  class="fields" value="{{ $journey->account->id }}">
						{{ $journey->account->name }}
					</option>
					@foreach ($accounts as $account)
					<option  class="fields" value="{{ $account->id }}">
						{{ $account->name }}
					</option>
					@endforeach
				</select>
				<br>
				<label class="labels" for="" >TAREFA: </label>
				<select name="task_id">
					<option value="{{ $journey->task->id }}">{{ $journey->task->name }}</option>
					@foreach ($tasks as $task)
					<option  class="fields" value="{{ $task->id }}">
						{{ $task->name }}
					</option>
					@endforeach
				</select>
				<a class="btn btn-secondary" href="{{ route('task.create') }}" target="blank">NOVA TAREFA</a>
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
				<input type="date" name="date" size="20" value="{{ $journey->date }}"><span class="fields"></span>
				@if ($errors->has('date'))
				<span class="text-danger">{{ $errors->first('date') }}</span>
				@endif
				<br>
				<label class="labels" for=""  value="{{$journey->start_time}}">
					INÍCIO: 
				</label>
				<input type="time" name="start_time" size="50"  value="{{ date('H:i', strtotime($journey->start_time)) }}"><span class="fields"></span>
				@if ($errors->has('start_time'))
				<span class="text-danger">{{ $errors->first('start_time') }}</span>
				@endif
				<br>
				<label class="labels" for=""  value="{{$journey->date}}">
					TÉRMINO: 
					<br>
				</label>
				@if ($journey->end_time == null)
				<input type="time" name="end_time" size="50"><span class="fields"></span>
				@else
				<input type="time" name="end_time" size="50"  value="{{ date('H:i', strtotime($journey->end_time)) }}"><span class="fields"></span>
				@endif
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