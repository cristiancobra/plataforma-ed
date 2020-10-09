@extends('layouts/master')

@section('title','MEU PAINEL')

@section('image-top')
{{ asset('imagens/control-panel.png') }} 
@endsection

@section('description')
<span style="color: yellow;font-size: 22px">{{ date("d/m/Y", strtotime($today)) }} </span>
<a class="btn btn-primary" href="{{ route('task.create') }}">CRIAR TAREFA</a>
@endsection

@section('main')
<div class="grid-start">
    <div class="tasks-now">
		<p class="numeros_painel">
			{{ $tasks_now }}
		</p>
		<p class="subtitulo-branco">
			tarefas sendo executadas
		</p>
		<form action=" {{ route('task.filter') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" size="20" value="fazendo agora">
			<input type="hidden" name="contact_id" size="20" value="todos">
			<input class="btn btn-secondary" type="submit" value="VER">
		</form>
	</div>

    <div class="tasks-pending">
		<p class="numeros_painel" style="color: #874983">
			{{ $tasks_pending }}
		</p>
		<p class="subtitulo-branco"  style="color: #874983">
			tarefas pendentes
		</p>
		<form action=" {{ route('task.filter') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" size="20" value="pendente">
			<input type="hidden" name="contact_id" size="20" value="todos">
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
		<form action=" {{ route('task.filter') }} " method="post" style="text-align: center;color: #874983">
			@csrf
			<input type="hidden" name="status" size="20" value="pendente">
			<input type="hidden" name="contact_id" size="20" value="todos">
			<input class="btn btn-secondary" type="submit" value="VER">
		</form>
	</div>

    <div class="hours">
		<p class="numeros_painel" style="color: yellow">
			{{ number_format($hoursToday / 3600, 1, ',','.')  }}
		</p>
		<p class="subtitulo-branco">
			horas concluidas hoje
		</p>
	</div>
</div>

<div style="padding-top: 3%;padding-left: 2%; padding-right: 4%;display: inline-block;text-align: left;vertical-align: top">
	<img src=" {{ asset('imagens/cao-astronauta-left.png') }} " width="150px" height="150px">
</div>

<div style="padding-top: 1%; padding-left: 4%; padding-right: 4%;display: inline-block">
	<br>	
	<p style="color:purple; font-weight: 400;line-height: 2;padding-top: 2%;font-size: 28px">
		<b>Olá {{$userAuth->name}}, já organizou seu dia? </b>
	</p>
	<p style="color:purple; font-weight: 400;line-height: 2;font-size: 18px">
		Agosto: {{ number_format($hoursAugust / 3600, 1, ',','.')  }} horas
		<br>
		Setembro: {{ number_format($hoursSeptember / 3600, 1, ',','.')  }} horas
		<br>
		Outubro: {{ number_format($hoursOctober / 3600, 1, ',','.')  }} horas
		<br>
		<b>Total: {{ number_format($hoursTotal / 3600, 1, ',','.')  }} horas</b>
		<br>
	</p>
</div>
@endsection