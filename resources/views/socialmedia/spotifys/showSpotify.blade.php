@extends('layouts/master')

@section('title','SPOTIFY')

@section('image-top')
{{ asset('images/spotify.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('spotify.index')}}">VER TODOS</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">  {{$spotify->page_name}}  </h1>
	<p class="labels">ENDEREÇO DA PÁGINA:<span class="fields">{{ $spotify->URL_name }}</span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
	
				<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($spotify->same_site_name === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Descrição no perfil:</b></td>
			@if ($spotify->about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Publica podcast:</b></td>
			@if ($spotify->feed_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($spotify->value_ads,2,",",".") }}</b></td>
		</tr>
	</table>

	<div style="text-align:right;padding: 2%">
		<form  style="text-decoration: none;color: black;display: inline-block" action="{{ route('spotify.destroy', ['spotify' => $spotify->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="button-delete" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('spotify.edit', ['spotify' => $spotify->id]) }}"">
			<i class='fa fa-edit'></i>
			Editar
		</a>
	</div>
</div>
@endsection