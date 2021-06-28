@extends('layouts/master')

@section('title','EDITAR INSTAGRAM')

@section('image-top')
{{ asset('images/email.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('instagram.index')}}">VER INSTAGRAMS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('instagram.update', ['instagram' =>$instagram->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20" value="{{ $instagram->page_name }}"><span class="fields"></span><br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" value="{{ $instagram->URL_name }}" size="50"><span class="fields"></span><br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $instagram->account->id }}">
				{{ $instagram->account->name }}
			</option>
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
		@if ($instagram->business === "yes")
		<input type="radio" name="business" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="business" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="business" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="business" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Conta vinculada com Facebook: </label>
		<br>
		@if ($instagram->linked_facebook === "yes")
		<input type="radio" name="linked_facebook" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_facebook" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="linked_facebook" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_facebook" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		@if ($instagram->same_site_name === "yes")
		<input type="radio" name="same_site_name" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="same_site_name" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Descrição da bio:</label>
		<br>
		@if ($instagram->about === "yes")
		<input type="radio" name="about" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="about" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Linktree na bio:</label>
		<br>
		@if ($instagram->linktree === "yes")
		<input type="radio" name="linktree" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linktree" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="linktree" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linktree" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		@if ($instagram->feed_content === "yes")
		<input type="radio" name="feed_content" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="feed_content" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">Feed organizado:</label>
		<br>
		@if ($instagram->harmonic_feed === "yes")
		<input type="radio" name="harmonic_feed" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="harmonic_feed" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		@if ($instagram->SEO_descriptions === "yes")
		<input type="radio" name="SEO_descriptions" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="SEO_descriptions" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">images têm tamanho correto:</label>
		<br>
		@if ($instagram->feed_images === "yes")
		<input type="radio" name="feed_images" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="feed_images" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">Publica Stories:</label>
		<br>
		@if ($instagram->stories === "yes")
		<input type="radio" name="stories" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="stories" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">Publicações com interação:</label>
		<br>
		@if ($instagram->interaction === "yes")
		<input type="radio" name="interaction" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="interaction" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<br>
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10"  value="{{ $instagram->value_ads }}">
		<br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="{{ $instagram->status }}">{{ $instagram->status}}</option>
			@if ($instagram->status === "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($instagram->status === "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($instagram->status === "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR INSTAGRAM">
		</form>



	</div>     
	@endsection
