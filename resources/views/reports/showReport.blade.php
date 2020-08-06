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
<br>
<br>
<div style="padding-left: 6%">
<h1 class="name"> {{ $report->name }}  </h1>
<p class="labels">DONO:<span class="fields">{{ $user->name }}</span></p>
<p class="labels">DATA:<span class="fields">  {{ $report->date}} </span></p>
<p class="labels">LOGOMARCA:<span class="fields">  {{ $report->logo}} </span></p>
<p class="labels">PALETA:<span class="fields">  {{ $report->palette}} </span></p>
<p class="labels">INSTAGRAM:<span class="fields">  {{ $report->instagram_businness}} </span></p>
<p class="labels">SITUAÇAO:<span class="fields">  {{ $report->status }} </span></p>
<br>
<p class="fields">Criado em:  {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

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
<br>
<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>
@endsection