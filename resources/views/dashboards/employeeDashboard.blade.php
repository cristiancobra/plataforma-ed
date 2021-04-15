@extends('layouts/master')

@section('title','FUNCIONÁRIO')

@section('image-top')
{{asset('imagens/control-panel.png')}}
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('task.create')}}">
	<i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div class="grid-employee">
	<div class="tasks-title">
		<img src="{{asset('imagens/tarefas.png')}}" width="50" height="50">
		<br>
		<br>
		TAREFAS
	</div>

	<a style="text-decoration:none" href="{{route('task.index', [
				'status' =>"fazer",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
		<div class="tasks-delayed">
			<p class="numeros_painel">
				{{$tasks_pending}}
			</p>
			<p class="subtitulo-branco">
				atrasadas
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
				'status' =>"feito",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
		<div class="tasks-now">
			<p class="numeros_painel">
				{{$tasksDone}}
			</p>
			<p class="subtitulo-branco">
				feitas
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
		<a href="{{route('opportunity.index', [
				'stage' =>"prospecção",
				'contact_id' => "",
				'user_id' => Auth::user()->id,
				])}}">
			<div class="funnel-bar-prospecting">
				PROSPECTAR: {{$opportunitiesProspecting}}
			</div>
		</a>
		<a href="{{route('opportunity.index', [
				'stage' =>"apresentação",
				'contact_id' => "",
				'user_id' => "",
				])}}">
			<div class="funnel-bar-presentation">
				APRESENTAR: {{$opportunitiesPresentation}}
			</div>
		</a>
		<a href="{{route('opportunity.index', [
				'stage' =>"proposta",
				'contact_id' => "",
				'user_id' => "",
				])}}">
			<div class="funnel-bar-proposal">
				PROPOSTA: {{$opportunitiesProposal}}
			</div>
		</a>
	</div>
	<a href="{{route('opportunity.index', [
				'stage' =>"ganhamos",
				'contact_id' => "",
				'user_id' => "",
				])}}">
		<div id="triangle-text"  style="display: inline-block;position: relative">
			<div class="balance-won">
			</div>
			<p class="balance_number">
				{{$opportunitiesWon}}
			</p>
			<p class="balance_label_won">
				ganhamos
			</p>
		</div>
	</a>
	<a href="{{route('opportunity.index', [
				'stage' =>"perdemos",
				'contact_id' => "",
				'user_id' => "",
				])}}">
		<div id="triangle-text"  style="display: inline-block;position: relative">
			<div class="balance-lost">
			</div>
			<p class="balance_number">
				{{$opportunitiesLost}}
			</p>
			<p class="balance_label_lost">
				perdemos
			</p>
		</div>
	</a>
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
					<b>DEPARTAMENTOS </b>
				</td>
				<td   class="table-list-header" style="width: 10%">
					HOJE					
				</td>
				<td   class="table-list-header" style="width: 10%">
					{{strtoupper($month)}}
				</td>
			</tr>

			@foreach ($departments as $department)
			<tr style="font-size: 14px">
				<td class="table-list-left">
					<a class="white" href=" ">
						<button class="button-round">
							<i class='fa fa-eye'></i>
						</button>
					</a>
					{{$department}}
				</td>
				<td class="table-list-center">
					{{number_format($departmentsToday[$department] / 3600, 1, ',','.')}}
				</td>
				<td class="table-list-center">
					{{number_format($departmentsMonthly[$department] / 3600, 1, ',','.')}}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
<br>
<br>
@endsection