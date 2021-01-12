@extends('layouts/master')

@section('title','ADMINISTRADOR')

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

	<a style="text-decoration:none" href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => "",
				])}}">
		<div class="tasks-toDo">
			<p class="numeros_painel">
				{{$tasks_pending}}
			</p>
			<p class="subtitulo-branco">
				equipe
			</p>
		</div>
	</a>

	<a href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
		<div class="tasks-my">
			<p class="numeros_painel">
				{{$tasks_my}}
			</p>
			<p class="subtitulo-branco">
				minhas
			</p>
		</div>
	</a>

	<a href="{{route('task.index', [
				'status' =>"fazendo",
				'contact_id' => "",
				'user_id' => "",
				])}}">
		<div class="tasks-now">
			<p class="numeros_painel">
				{{$tasks_now}}
			</p>
			<p class="subtitulo-branco">
				fazendo
			</p>
		</div>
	</a>

	<div class="opportunities-title">
		<img src="{{asset('imagens/financeiro.png')}}" width="50" height="50">
		<br>
		<br>
		OPORTUNIDADES
	</div>
	<div class="opportunities-funnel">
		<div class="funnel-bar-prospecting">
			PROSPECTAR: {{$opportunitiesProspecting}}
		</div>
		<div class="funnel-bar-presentation">
			APRESENTAR: {{$opportunitiesPresentation}}
		</div>
		<div class="funnel-bar-proposal">
			PROPOSTA: {{$opportunitiesProposal}}
		</div>
	</div>
	<div class="balance-won">
		<p style="position: absolute; top: -10px; right: 0px;left:-16px;font-size: 22px">
			<br>
			{{$opportunitiesWon}}
			<br>
			ganhamos
		</p>
	</div>
	<div class="balance-lost">
		<p style="position: absolute; top: -130px; right: 0px;left: -14px;font-size: 22px">
			<br>
			{{$opportunitiesLost}}
			<br>
			perdemos
		</p>
	</div>
	<br>
	<div class="journeys-title">
		<img src="{{asset('imagens/journey.png')}}" width="50" height="50">
		<br>
		<br>
		JORNADAS
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
					<a class="white" href=" {{route('user.show', ['user' => $user->id])}}">
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