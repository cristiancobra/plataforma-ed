@extends('layouts/master')

@section('title','SUPER ADMINISTRADOR')

@section('image-top')
{{asset('images/control-panel.png')}}
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
		<img src="{{asset('images/tarefas.png')}}" width="50" height="50">
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
		<form action=" {{route('task.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" value="fazer">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="all">
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
			{{$tasks_now}}
		</p>
		<p class="subtitulo-branco">
			fazendo
		</p>
		<form action=" {{route('task.index')}} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status"  value="fazendo">
			<input type="hidden" name="contact_id" value="">
			<input type="hidden" name="user_id" value="">
			<input class="button-panel" type="submit" value="VER">
		</form>
	</div>

	<div class="opportunities-title">
		<img src="{{asset('images/financeiro.png')}}" width="50" height="50">
		<br>
		<br>
		OPORTUNIDADES
	</div>
	<div class="opportunities-funnel">
		<div class="funnel-bar-prospecting">
			PROSPECÇÃO: 12
		</div>
		<div class="funnel-bar-presentation">
			APRESENTAÇÃO: 6
		</div>
		<div class="funnel-bar-proposal">
			PROPOSTA: 3
		</div>
	</div>
	<div class="balance-won">
		<p style="position: absolute; top: -10px; right: 0px;left:-16px;font-size: 22px">
		<br>
		14
		<br>
		ganhamos
		</p>
	</div>
	<div class="balance-lost">
		<p style="position: absolute; top: -130px; right: 0px;left: -14px;font-size: 22px">
		<br>
		7
		<br>
		perdemos
		</p>
	</div>
	<br>
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
					{{$user->name}}
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