@extends('layouts/master')

@section('title','SUPER ADMINISTRADOR')

@section('image-top')
{{asset('imagens/control-panel.png')}}
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
	<div class="tasks-title">
		<img src="{{asset('imagens/tarefas.png')}}" width="50" height="50">
		<br>
		<br>
		TAREFAS
	</div>
	<div class="tasks-toDo">
		<p class="numeros_painel">
			{{$tasks_pending}}
		</p>
		<p class="subtitulo-branco">
			fazer
		</p>
		<form action=" {{ route('task.index') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" value="fazer">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>
	<div class="tasks-my">
		<p class="numeros_painel">
			{{$tasks_my}}
		</p>
		<p class="subtitulo-branco">
			minhas
		</p>
		<form action=" {{route('task.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" size="20" value="fazer">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="{{$userAuth->id}}">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>

	<div class="tasks-now">
		<p class="numeros_painel">
			{{ $tasks_now }}
		</p>
		<p class="subtitulo-branco">
			fazendo
		</p>
		<form action=" {{ route('task.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status"  value="fazendo">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>

	<div class="opportunities-title">
		<img src="{{asset('imagens/financeiro.png')}}" width="50" height="50">
		<br>
		<br>
		OPORTUNIDADES
	</div>
	<div class="opportunities-toDo">
		<p class="numeros_painel">
			{{$opportunities_pending}}
		</p>
		<p class="subtitulo-branco">
			fazer
		</p>
		<form action=" {{ route('opportunity.index') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" value="fazer">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>
	<div class="opportunities-my">
		<p class="numeros_painel">
			{{$opportunities_my}}
		</p>
		<p class="subtitulo-branco">
			minhas
		</p>
		<form action=" {{route('opportunity.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" size="20" value="fazer">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="{{$userAuth->id}}">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>
	<div class="opportunities-now">
		<p class="numeros_painel">
			{{$opportunities_now}}
		</p>
		<p class="subtitulo-branco">
			fazendo
		</p>
		<form action=" {{route('opportunity.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status"  value="fazendo">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>
	<br>
	<br>
	<div class="hoursToday">
		<br>
		<p class="numeros_painel">

		</p>
		<p class="subtitulo-branco">
			horas hoje
		</p>
	</div>
	<div class="hoursToday">
		<br>
		<p class="numeros_painel">
			{{number_format($todayTotal / 3600)}}
		</p>
		<p class="subtitulo-branco">
			total hoje
		</p>
		<br>
		<p class="numeros_painel">
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
					<a class="white" href=" {{ route('user.show', ['user' => $user->id]) }}">
						<button class="button-round">
							<i class='fa fa-eye'></i>
						</button>
					</a>
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
<br>
<br>
@endsection