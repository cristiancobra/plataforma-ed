@extends('layouts/master')

@section('title','REDES SOCIAIS')

@section('image-top')
{{asset('imagens/socialmedia.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('socialmedia')}}
@endsection

@section('main')
<div>
	<form action=" {{route('facebook.store')}} " method="post">
		@csrf
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
		<label class="labels" for="" >NOME DA REDE SOCIAL:</label>
		{{createSimpleSelect('socialmedia_name', 'fields', returnSocialmediaType())}}
		<br>
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" size="50"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">Possui conta Business: </label>
		<br>
		<input type="radio" name="business" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="business" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Conta Business vinculada com Instagram: </label>
		<br>
		<input type="radio" name="linked_instagram" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_instagram" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Conta Business vinculada com  facebook: </label>
		<br>
		<input type="radio" name="linked_facebook" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_facebook" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		<input type="radio" name="same_site_name" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Apresentação da página (Biografia):</label>
		<br>
		<input type="radio" name="about" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="0" ><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica conteúdos  feed:</label>
		<br>
		<input type="radio" name="feed_content" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Feed organizado:</label>
		<br>
		<input type="radio" name="harmonic_feed" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		<input type="radio" name="SEO_descriptions" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Imagens têm tamanho correto:</label>
		<br>
		<input type="radio" name="feed_images" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Publica Stories:</label>
		<br>
		<input type="radio" name="stories" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Ferramentas de interação:</label>
		<br>
		<input type="radio" name="interaction" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Publica IGTV:</label>
		<br>
		<input type="radio" name="interaction" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Publica Reels:</label>
		<br>
		<input type="radio" name="reels" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="reels" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Possui  funcionários linkados ao perfil da empresa:</label>
		<br>
		<input type="radio" name="employee_profiles" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="employee_profiles" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Perfil dos funcionários está adequado ao cargo da empresa:</label>
		<br>
		<input type="radio" name="employee_profiles_cv" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="employee_profiles_cv" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Anuncia vagas de emprego:</label>
		<br>
		<input type="radio" name="offers_job" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="offers_job" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Possui pasta com ideias:</label>
		<br>
		<input type="radio" name="pin_content" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="pin_content" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Possui linktree:</label>
		<br>
		<input type="radio" name="linktree" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="linktree" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Capa personalizada:</label>
		<br>
		<input type="radio" name="image_banner" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="image_banner" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Playlists organizadas por SEO:</label>
		<br>
		<input type="radio" name="organized_playlists" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="organized_playlists" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Possui link para loja virtual externa:</label>
		<br>
		<input type="radio" name="liked_virtualstore" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="liked_virtualstore" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Vídeos possuem capa personalizada:</label>
		<br>
		<input type="radio" name="video_banner" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="video_banner" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Vídeos possuem legendas em português:</label>
		<br>
		<input type="radio" name="legend" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="legend" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Produz conteúdo exclusivo para membros:</label>
		<br>
		<input type="radio" name="feed_member" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_member" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Segue outros canais que tenham haver com o seu nicho:</label>
		<br>
		<input type="radio" name="follow_channel" value="1" checked="checked"><span class="fields">Sim</span>
		<br>
		<input type="radio" name="follow_channel" value="0" ><span class="fields">Não</span>
		<br>
		<br>
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10" value="0">
		<br>
		<label class="labels" for="">STATUS:</label>
		{{createSimpleSelect('status', 'fields', returnStatusActive())}}
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CADASTRAR PÁGINA">
	</form>
</div>     
@endsection








