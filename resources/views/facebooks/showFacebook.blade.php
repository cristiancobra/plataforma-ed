@extends('layouts/master')

@section('title','DETALHES DO FACEBOOK')

@section('image-top')
{{ asset('imagens/facebook.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="/facebooks">VER TODOS AS PÁGINAS </a>

@endsection

@section('main')
<br>
<div>
	<h1 class="name">  {{$facebook->page_name}}  </h1>
	<br>
	<p class="labels">DONO:<span class="fields">{{ $facebook->users->name }}</span></p>
	<p class="labels">ENDEREÇO DA PÁGINA:<span class="fields">{{ $facebook->URL_name }}</span></p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Análise da página</b></td>
			<td   class="table-list-header"><b>situação</b></td>
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta Business vinculada com Instagram:</b></td>
			@if ($facebook->linked_instagram === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Conta possui mesmo nome do site:</b></td>
			@if ($facebook->same_site_name === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>	
		<tr>
			<td   class="table-list-left"><b>Apresentação da página:</b></td>
			@if ($facebook->about === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Publica conteúdos no feed:</b></td>
			@if ($facebook->feed_content === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>		
		<tr>
			<td   class="table-list-left"><b>Feed organizado:</b></td>
			@if ($facebook->harmonic_feed === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações usam SEO:</b></td>
			@if ($facebook->SEO_descriptions === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Imagens têm tamanho correto:</b></td>
			@if ($facebook->feed_images === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publica Stories:</b></td>
			@if ($facebook->stories === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Publicações com interação:</b></td>
			@if ($facebook->interaction === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Paga ADs:</b></td>
			@if ($facebook->pay_ads === "yes")
			<td   class="button-active"><b>SIM</b></td>
			@else
			<td   class="button-delete"><b>NÃO</b></td>
			@endif
		</tr>
		<tr>
			<td   class="table-list-left"><b>Investimento em ADs:</b></td>
			<td   class="table-list-money-income"><b> R$ {{ number_format($facebook->value_ads,2,",",".") }}</b></td>
		</tr>
	</table>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('facebook.destroy', ['facebook' => $facebook->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="button-delete" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('facebook.edit', ['facebook' => $facebook->id]) }} "    style="text-decoration: none;color: black;display: inline-block">
			<i class='fa fa-edit'></i>Editar</a>
				<a class="btn btn-primary" href="{{route('facebook.index')}}">VOLTAR</a>
	</div>
	<br>
	<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>
@endsection