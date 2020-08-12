@extends('layouts/master')

@section('title','RELATÓRIO')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Decida suas estratégias baseado em dados
<a href="/relatorios"><br><br>
	<button type="button" class="button-header">VER TODOS OS RELATÓRIOS</button> </a>
@endsection

@section('main')
	<div style="background-color: #874983;padding-bottom: 1%;padding-top: 1.5%;border-radius: 40px">
		<h1 class="name" style="color: white;text-align: center"> {{ $report->name }}  </h1>
		<p class="fields" style="color: white;text-align: center">  {{ $report->date}} </span></p>
	</div>
	<br>
	<div>
		<p class="title-reports">IDENTIDADE VISUAL</p>
		<br>
		<p class="labels">Possui logomarca:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Possui paleta de cores:<span class="fields">  {{ $report->palette}} </span></p>
		<br>
	</div>

	<div>
		<p class="title-reports">INSTAGRAM</p>
		<br>
		<p class="labels">Sua empresa  possui conta bussiness?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Conta está vinculada ao facebook?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Nome da conta está igual ao site?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Apresentação/ bio está preenchida?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">bio possui link para site o linktree?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Produz conteúdo para FEED? :<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">FEED é organizado?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">As imagens do FEED estão no tamanho correto?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Produz conteúdo para IGTV?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Produz STORIES?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Usa recursos de INTERAÇÂO do stories?: <span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Paga ads?:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Quanto paga de ads?:<span class="fields">  {{ $report->logo}} </span></p>
		<br>
	</div>

	<div>
		<p class="title-reports">FACEBOOK</p>
		<br>
		<p class="labels">conta bussiness  vinculada ao Instagram:<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Nome da conta está igual ao site<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Apresentação preenchida<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Produz conteúdo para FEED<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">FEED é organizado<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">descrições do FEED com SEO<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">imagens do FEED estão no tamanho corretospan class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Produz STORIES<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Usa recursos de INTERAÇÂO<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Paga ads<span class="fields">  {{ $report->logo}} </span></p>
		<p class="labels">Quanto de ads<span class="fields">  {{ $report->logo}} </span></p>
		<br>
	</div>

	<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
		<button class="button"><a href=" {{ route('reports.edit', ['report' => $report->id]) }} "  style="text-decoration: none;color: black"><i class='fa fa-edit'></i>Editar informações</a></button>
	</div>
	<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
		<form action="{{ route('reports.destroy', ['report' => $report->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="button-delete" type="submit" value="APAGAR">
		</form>
	</div>
@endsection