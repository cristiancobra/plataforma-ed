@extends('layouts/master')

@section('title','EDITAR FACEBOOK')

@section('image-top')
{{ asset('imagens/facebook.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('facebook.index')}}">VER FACEBOOKS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('facebook.update', ['facebook' =>$facebook->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20" value="{{ $facebook->page_name }}"><span class="fields"></span><br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" value="{{ $facebook->URL_name }}" size="50"><span class="fields"></span><br>
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
		@if ($facebook->business === "yes")
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
		<label class="labels" for="">Conta Business vinculada com Instagram: </label>
		<br>
		@if ($facebook->linked_instagram === "yes" )
		<input type="radio" name="linked_instagram" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_instagram" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="linked_instagram" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_instagram" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Conta com mesmo nome do site: </label>
		<br>
		@if ($facebook->same_site_name === "yes" )
		<input type="radio" name="same_site_name" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="same_site_name" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Apresentação da página:</label>
		<br>
		@if ($facebook->same_site_name === "yes" )
		<input type="radio" name="about" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="about" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		@if ($facebook->feed_content === "yes" )
		<input type="radio" name="feed_content" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="feed_content" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Feed organizado:</label>
		<br>
		@if ($facebook->harmonic_feed === "yes" )
		<input type="radio" name="harmonic_feed" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="harmonic_feed" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		@if ($facebook->SEO_descriptions === "yes" )
		<input type="radio" name="SEO_descriptions" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="SEO_descriptions" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Imagens têm tamanho correto:</label>
		<br>
		@if ($facebook->feed_images === "yes" )
		<input type="radio" name="feed_images" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="feed_images" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publica Stories:</label>
		<br>
		@if ($facebook->stories === "yes" )
		<input type="radio" name="stories" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="stories" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publicações com interação:</label>
		<br>
		@if ($facebook->stories === "yes" )
		<input type="radio" name="interaction" value="yes"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="no" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="interaction" value="yes" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="no"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10"  value="{{ $facebook->value_ads }}">
		<br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="{{ $facebook->status }}">{{ $facebook->status}}</option>
			@if ($facebook->status === "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($facebook->status === "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($facebook->status === "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR FACEBOOK">
		</form>



	</div>     
	@endsection
