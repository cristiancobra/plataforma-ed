@extends('layouts/master')

@section('title','LINKEDIN')

@section('image-top')
{{ asset('imagens/linkedin.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('linkedin.index')}}">VER TODOS</a>
@endsection

@section('main')
<br>
<div>
	<h1 class="name">  {{$linkedin->page_name}}  </h1>
	<p class="labels">ENDEREÇO DA PÁGINA:<span class="fields">{{ $linkedin->URL_name }}</span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 90%"><b>Análise da página</b></td>
			<td   class="table-list-header" style="width: 10%"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Possui conta Business:</b></td>
			@if ($linkedin->business === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($linkedin->same_site_name === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Descrição no perfil:</b></td>
			@if ($linkedin->about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($linkedin->feed_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($linkedin->SEO_descriptions === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($linkedin->feed_images === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Funcionários possuem perfil na rede:</b></td>
			@if ($linkedin->employee_profiles === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Anuncia/aceita vagas na rede:</b></td>
			@if ($linkedin->offers_job === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($linkedin->value_ads,2,",",".") }}</b></td>
		</tr>
	</table>

	<div style="text-align:right;padding: 2%">
		<form  style="text-decoration: none;color: black;display: inline-block" action="{{ route('linkedin.destroy', ['linkedin' => $linkedin->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="button-delete" type="submit" value="APAGAR">
		</form>
				<a class="btn btn-secondary" href=" {{ route('linkedin.edit', ['linkedin' => $linkedin->id]) }}"">
			<i class='fa fa-edit'></i>
			Editar
		</a>
	</div>
</div>
@endsection