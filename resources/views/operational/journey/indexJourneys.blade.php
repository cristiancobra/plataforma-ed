@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('imagens/journey.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('journey.create')}}">NOVA JORNADA</a>
@endsection

@section('main')
<div style="text-align:right;padding: 2%">
	<form action=" {{ route('journey.index') }} " method="post" style="padding: 20px;color: #874983;display: inline-block">
		@csrf
		<select class="select"name="user_id">
			<option  class="fields" value="">
				funcionário
			</option>
			<option  class="fields" value="">
				TODOS
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<input class="btn btn-secondary" type="submit" value="FILTRAR">
	</form>
	<form action=" {{route('journey.reports')}} " method="post" style="padding: 20px;color: #874983;display: inline-block">
		@csrf
		<select class="select"name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<input type="hidden" value="mensal">
		<input class="btn btn-secondary" type="submit" value="MENSAL">
	</form>
</div>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 20%">
			<b>DATA </b>
		</td>
		<td   class="table-list-header" style="width: 35%">
			<b>TAREFA </b>
		</td>
		<td   class="table-list-header" style="width: 15%">
			<b>RESPONSÁVEL </b>
		</td>
		<td   class="table-list-header" style="width: 5%">
			<b>INÍCIO </b>
		</td>
		<td   class="table-list-header" style="width: 5%">
			<b>TÉRMINO </b>
		</td>
		<td   class="table-list-header" style="width: 5%">
			<b>DURAÇÃO </b>
		</td>
	</tr>

	@foreach ($journeys as $journey)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<button class="button">
				<a href=" {{ route('journey.show', ['journey' => $journey]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('journey.edit', ['journey' => $journey]) }}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			{{date('d/m/Y', strtotime($journey->date))}}
		</td>
		<td class="table-list-left">
			<button class="button">
				<a href=" {{ route('task.show', ['task' => $journey->task_id]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			{{$journey->task->name}}
		</td>
		<td class="table-list-center">
			{{$journey->user->name}}
		</td>
		<td class="table-list-center">
			{{date('H:i', strtotime($journey->start_time))}}
		</td>
		<td class="table-list-center">
			@if($journey->end_time == null)
			--
			@else
			{{date('H:i', strtotime($journey->end_time))}}
			@endif
		</td>
		<td class="table-list-center" style="color:white;background-color: #874983">
			{{ gmdate('H:i', $journey->duration) }}
		</td>
	</tr>
	@endforeach
</table>
<p style="text-align: right">
	<br>

</p>
<br>
@endsection