@extends('layouts/master')

@section('title','INSTAGRAM')

@section('image-top')
{{ asset('images/email.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('instagram.index')}}">VER TODOS AS PÁGINAS</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">  {{$instagram->page_name}}  </h1>
	<br>
	<p class="labels">ENDEREÇO DA PÁGINA:<span class="fields">{{ $instagram->URL_name }}</span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui conta Business:</b></td>
			@if ($instagram->business === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta vinculada com Facebook:</b></td>
			@if ($instagram->linked_facebook === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($instagram->same_site_name === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Descrição da bio:</b></td>
			@if ($instagram->about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Linktree na bio:</b></td>
			@if ($instagram->linktree === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($instagram->feed_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Feed organizado:</b></td>
			@if ($instagram->harmonic_feed === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($instagram->SEO_descriptions === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>images têm tamanho correto:</b></td>
			@if ($instagram->feed_images === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($instagram->stories === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações com interação:</b></td>
			@if ($instagram->interaction === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($instagram->value_ads,2,",",".") }}</b></td>
		</tr>
	</table>

	<br>
	<div style="text-align:right;padding: 2%">
		<form  style="text-decoration: none;color: black;display: inline-block" action="{{ route('instagram.destroy', ['instagram' => $instagram->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="button-delete" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('instagram.edit', ['instagram' => $instagram->id]) }}">
			<i class='fa fa-edit'></i>
			Editar
		</a>
	</div>
</div>
@endsection