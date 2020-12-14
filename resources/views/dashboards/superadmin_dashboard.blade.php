@extends('layouts/master')

@section('title','PAINEL')

@section('image-top')
{{ asset('imagens/control-panel.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('task.create')}}">
	CRIAR TAREFA
</a>
@endsection

@section('main')
<div class="grid-administrator">
	<div class="tasks-toDo">
		<p class="numeros_painel">
			{{ $tasks_pending }}
		</p>
		<p class="subtitulo-branco">
			tarefas pendentes
		</p>
		<form action=" {{ route('task.index') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" value="pendente">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="btn btn-secondary" type="submit" value="VER">
		</form>
	</div>


	<div class="tasks-my">
		<p class="numeros_painel" style="color: yellow">
			{{ $tasks_my }}
		</p>
		<p class="subtitulo-branco">
			minhas tarefas
		</p>
		<form action=" {{ route('task.index') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" size="20" value="pendente">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="{{$userAuth->id}}">
			<input class="btn btn-secondary" type="submit" value="VER">
		</form>
	</div>

	<div class="tasks-now">
		<p class="numeros_painel">
			{{ $tasks_now }}
		</p>
		<p class="subtitulo-branco">
			tarefas sendo executadas
		</p>
		<form action=" {{ route('task.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status"  value="fazendo agora">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="btn btn-secondary" type="submit" value="VER">
		</form>
	</div>
	<div class="hours">
		<br>
		<p class="numeros_painel" style="color: yellow">
			
		</p>
		<p class="subtitulo-branco">
			horas hoje
		</p>
	</div>
	<div class="hours">
		<br>
		<p class="numeros_painel" style="color: yellow">
			{{number_format($todayTotal / 3600)}}
		</p>
		<p class="subtitulo-branco">
			total hoje
		</p>
		<br>
		<p class="numeros_painel" style="color: yellow">
			{{number_format($monthTotal / 3600)}}
		</p>
		<p class="subtitulo-branco">
			total {{$month}}
		</p>
	</div>
	<div class="tasks-team">
		<table class="table-list">
			<tr>
				<td   class="table-list-header" style="width: 50%">
					<b>FUNCIONÁRIO </b>
				</td>
				<td   class="table-list-header" style="width: 10%">
					HOJE					
				</td>
				<td   class="table-list-header" style="width: 10%">
					{{strtoupper($month)}}
				</td>
			</tr>

			@foreach ($users as $user)
			<tr style="font-size: 14px">
				<td class="table-list-left">
					{{$user->contact->name}}
				</td>
				<td class="table-list-center">
					{{number_format($user->hoursToday / 3600, 1, ',','.')}}
				</td>
				<td class="table-list-center">
					{{number_format($user->hoursMonthly / 3600, 1, ',','.')}}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection