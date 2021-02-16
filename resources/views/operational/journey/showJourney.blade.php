@extends('layouts/master')

@section('title','JORNADA')

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
<br>
<div>
	<p class="labels">
		DONO:<span class="fields">{{$journey->account->name}}</span>
	</p>
	<p class="labels">
		RESPONSÁVEL:<span class="fields">{{$journey->task->user->contact->name}}</span>
	</p>
	<p class="labels">
		TAREFA:
		<span class="fields">{{$journey->task->name}} </span>
			<button class="button-round">
				<a href=" {{route('task.show', ['task' => $journey->task])}}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{route('task.edit', ['task' => $journey->task])}}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
	</p>
	<br>
	<p class="labels">
		DESCRIÇÃO:<span class="fields"> {!!html_entity_decode($journey->description)!!} </span>
	</p>
	<br>
	<p class="labels">
		CONTATO:<span class="fields">  {{ $journey->task->contact->name }}  </span>
	</p>
	<br>
	<p class="labels">
		DATA:<span class="fields">  {{date('d/m/Y', strtotime($journey->date))}} </span>
	</p>
	<p class="labels">
		INÍCIO:<span class="fields">  {{ date('H:i', strtotime($journey->start_time)) }} </span>
	</p>

	@if ($journey->end_time == null)
	<p class="labels">
		TÉRMINO:<span class="fields">  0:00 </span>
	</p>	
	@else
	<p class="labels">
		TÉRMINO:<span class="fields">  {{ date('H:i', strtotime($journey->end_time)) }} </span>
	</p>	
	@endif

	<p class="labels">
		DURAÇÃO:<span class="fields">  {{ gmdate('H:i', $journey->duration) }}</span>
	</p>
	<br>
	<p class="labels">
		SITUAÇAO:<span class="fields">  {{ $journey->status }} </span>
	</p>
	<br>
	<p class="fields">Criado em:  {{ date('d/m/Y H:i', strtotime($journey->created_at)) }}
	</p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('journey.destroy', ['journey' => $journey->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('journey.edit', ['journey' => $journey->id]) }}">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('journey.index')}}">VOLTAR</a>
	</div>
</div>
@endsection