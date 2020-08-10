@extends('layouts/master')

@section('title','MEU PAINEL')

@section('image-top')
{{ asset('imagens/painel-progresso.png') }} 
@endsection

@section('description')

Olá {{$user->name}}, hoje é {{ $hoje }}

@endsection

@section('main')
<center>
	<div style="width: 100%;padding-top: 2%">
		<div class="numbers">
			<p class="numeros_painel">  {{ $totalTasks }}</p>
			<p class="subtitulo-branco"> tarefas </p>
			<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DTasks%26action%3Dindex%26parentTab%3DAtividades" target="_blank" style="color: yellow">fazer</a></p>
		</div>

		<div class="numbers">
			<p class="numeros_painel">  {{  $totalLeads }} </p>
			<p class="subtitulo-branco"> potenciais </p>
			<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DLeads%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">contatar</a></p>
		</div>

		<div class="numbers">
			<p class="numeros_painel"  style="font-size: 40px">  R$ {{  $totalOpportunities }} </p>
			<p class="subtitulo-branco"> oportunidades</p>
			<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">vender</a></p>
		</div>
	</div>
</center>

<div style="padding-top: 3%;padding-left: 2%; padding-right: 4%;display: inline-block;text-align: left;vertical-align: top">
	<img src=" {{ asset('imagens/cao-astronauta-left.png') }} " width="150px" height="150px">
</div>

<div style="padding-top: 1%; padding-left: 4%; padding-right: 4%;display: inline-block">
	<p style="color:purple; font-weight: 400;line-height: 2;padding-top: 2%;font-size: 28px"><b>O que você precisa fazer hoje? </b></p>
	<p style="color:purple; font-weight: 400;line-height: 2;padding-top: 2%;font-size: 18px">
	Use os links do painel e não deixe suas tarefas acumularem. <br>Use o menu lateral para navegar através dos DEPARTAMENTOS.</p>
</div>
@endsection