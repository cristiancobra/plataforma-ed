@extends('layouts/master')

@section('title','NOVA PÁGINA')

@section('image-top')
{{ asset('images/youtube.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('youtube.index') }}">VER PÁGINAS</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('youtube.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20"><span class="fields"></span><br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" size="50"><span class="fields"></span><br>
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
		<label class="labels" for="">Possui capa personalizada:</label>
		<br>
		<input type="radio" name="image_banner" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="image_banner" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Botão da capa possui link para site: </label>
		<br>
		<input type="radio" name="linked_site" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="linked_site" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Canal está organizado por playlist:</label>
		<br>
		<input type="radio" name="organized_playlists" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="organized_playlists" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Possui biografia::</label>
		<br>
		<input type="radio" name="about" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="about" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">segue outros canais:</label>
		<br>
		<input type="radio" name="follow_channel" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="follow_channel" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica vídeos:</label>
		<br>
		<input type="radio" name="feed_content" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="feed_content" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">conteúdo para membros:</label>
		<br>
		<input type="radio" name="feed_members" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="feed_members" value="no"><span class="fields">Não</span><br>
		<br>

		<br>
		<label class="labels" for="">loja virtual está linkada  para loja do site:</label>
		<br>
		<input type="radio" name="liked_virtualstore" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="liked_virtualstore" value="no"><span class="fields">Não</span><br>
		<br>

		<br>
		<label class="labels" for="">videos possuem capa personalizada:</label>
		<br>
		<input type="radio" name="video_banner" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="video_banner" value="no"><span class="fields">Não</span><br>
		<br>

		<br>
		<label class="labels" for="">Videos possuem legenda:</label>
		<br>
		<input type="radio" name="legend" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="legend" value="no"><span class="fields">Não</span><br>
		<br>


		<label class="labels" for="">Títulos e descrição usam SEO:</label>
		<br>
		<input type="radio" name="seo_content" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="seo_content" value="no"><span class="fields">Não</span><br>
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
		<input class="btn btn-secondary" type="submit" value="CADASTRAR">
	</form>
</div>     
@endsection

