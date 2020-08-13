@extends('layouts/master')

@section('title','EDITAR FACEBOOK')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Altere seu email
<a href="/facebooks/"><br><br>
	<button type="button" class="button-header">VER FACEBOOKS</button> </a>

@endsection

@section('main')
<br>
<form action=" {{ route('facebook.update', ['facebook' =>$facebook->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20" value="{{ $facebook->page_name }}"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" value="{{ $facebook->URL_name }}" size="50"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="user_id">
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="">Conta Business vinculada com Instagram: </label>
		<br>
		<input type="radio" name="linked_instagram" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="linked_instagram" value="no"><span class="fields">Não</span><br>
		<br>


		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		<input type="radio" name="same_site_name" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="same_site_name" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Apresentação da página:</label>
		<br>
		<input type="radio" name="about" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="about" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		<input type="radio" name="feed_content" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="feed_content" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Feed organizado:</label>
		<br>
		<input type="radio" name="harmonic_feed" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="harmonic_feed" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		<input type="radio" name="SEO_descriptions" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="SEO_descriptions" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Imagens têm tamanho correto:</label>
		<br>
		<input type="radio" name="feed_images" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="feed_images" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica Stories:</label>
		<br>
		<input type="radio" name="stories" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="stories" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publicações com interação:</label>
		<br>
		<input type="radio" name="interaction" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="interaction" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Paga ADs:</label>
		<br>
		<input type="radio" name="pay_ads" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="pay_ads" value="no"><span class="fields">Não</span><br>
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
		<input class="button-header" type="submit" value="ATUALIZAR FACEBOOK">
		@if ($user->perfil == "administrador")
		<a href="https://acadia.mxroute.com:2083/cpsess2438558906/frontend/manager/email_accounts/index.html#/list" target="_blank"><br><br>
			<button type="button" class="button-header">SERVIDOR DE EMAIL</button> </a><br>
		<center>login: solucoes</center>
		@endif
</form>



</div>     
@endsection
