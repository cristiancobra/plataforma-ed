@extends('layouts/master')

@section('title','DETALHES DO YOUTUBE')

@section('image-top')
{{ asset('imagens/youtube.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('youtube.index')}}">VER TODOS AS PÁGINAS</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">  {{$youtube->page_name}}  </h1>
	<br>
	<p class="labels">DONO:<span class="fields">{{ $youtube->users->name }}</span></p>
	<p class="labels">ENDEREÇO DA PÁGINA:<span class="fields">{{ $youtube->URL_name }}</span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui capa personalizada:</b></td>
			@if ($youtube->image_banner === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left">
				<b>Botão da capa possui link para site:</b>
			</td>
			@if ($youtube->liked_site === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Canal está organizado por playlist:</b></td>
			@if ($youtube->organized_playlists === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui biografia: </b></td>
			@if ($youtube->about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>segue outros canais:</b></td>
			@if ($youtube->follow_channel === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>conteúdo para membros:</b></td>
			@if ($youtube->feed_member === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>loja virtual está linkada  para loja do site:</b></td>
			@if ($youtube->liked_virtualstore === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
                
                <tr>
			<td   class="table-list-left"><b>videos possuem capa personalizada:</b></td>
			@if ($youtube->video_banner === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
<tr>
			<td   class="table-list-left"><b>Videos possuem legenda:</b></td>
			@if ($youtube->legend === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
                <tr>
			<td   class="table-list-left"><b>Títulos e descrição usam SEO:</b></td>
			@if ($youtube->seo_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
                
                
                <tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($youtube->value_ads,2,",",".") }}</b></td>
		</tr>
	</table>

	<div style="text-align:right;padding: 2%">
		<form  style="text-decoration: none;color: black;display: inline-block" action="{{ route('youtube.destroy', ['youtube' => $youtube->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="button-delete" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('youtube.edit', ['youtube' => $youtube->id]) }}"">
			<i class='fa fa-edit'></i>
			Editar
		</a>
	</div>
</div>
@endsection