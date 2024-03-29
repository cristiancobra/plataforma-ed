@extends('layouts/master')

@section('title','NOVA PÁGINA')

@section('image-top')
{{ asset('images/facebook.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('facebook.index') }}">VER PÁGINAS</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('facebook.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" size="50"><span class="fields"></span><br>
		<br>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="">Possui conta Business: </label>
		<br>
		<input type="radio" name="business" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="business" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Conta Business vinculada com Instagram: </label>
		<br>
		<input type="radio" name="linked_instagram" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="linked_instagram" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		<input type="radio" name="same_site_name" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="same_site_name" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Apresentação da página:</label>
		<br>
		<input type="radio" name="about" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="about" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		<input type="radio" name="feed_content" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="feed_content" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Feed organizado:</label>
		<br>
		<input type="radio" name="harmonic_feed" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="harmonic_feed" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		<input type="radio" name="SEO_descriptions" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="SEO_descriptions" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">images têm tamanho correto:</label>
		<br>
		<input type="radio" name="feed_images" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="feed_images" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica Stories:</label>
		<br>
		<input type="radio" name="stories" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="stories" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publicações com interação:</label>
		<br>
		<input type="radio" name="interaction" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="interaction" value="no" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10" value="0">
		<br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CADASTRAR PÁGINA">
	</form>
</div>     
@endsection