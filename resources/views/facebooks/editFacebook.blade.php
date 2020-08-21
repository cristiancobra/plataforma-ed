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
		<br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" value="{{ $facebook->URL_name }}" size="50"><span class="fields"></span><br>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="user_id">
			<option  class="fields" value="{{ $facebook->user_id}}">
				{{ $facebook->users->name }}
			</option>
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
		<input type="radio" name="linked_instagram" value="sim" @if ($facebook->linked_instagram == "sim" ) checked @endif>
		<input type="radio" name="linked_instagram" value="não" checked="checked">
		<br>
		@endif
		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		@if ($facebook->same_site_name == "sim" )
		<input type="radio" name="same_site_name" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="same_site_name" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="same_site_name" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Apresentação da página:</label>
		<br>
		@if ($facebook->same_site_name == "sim" )
		<input type="radio" name="about" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="about" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="about" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		@if ($facebook->feed_content == "sim" )
		<input type="radio" name="feed_content" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="feed_content" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_content" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Feed organizado:</label>
		<br>
		@if ($facebook->harmonic_feed == "sim" )
		<input type="radio" name="harmonic_feed" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="harmonic_feed" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="harmonic_feed" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		@if ($facebook->SEO_descriptions == "sim" )
		<input type="radio" name="SEO_descriptions" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="SEO_descriptions" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="SEO_descriptions" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Imagens têm tamanho correto:</label>
		<br>
		@if ($facebook->feed_images == "sim" )
		<input type="radio" name="feed_images" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="feed_images" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="feed_images" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publica Stories:</label>
		<br>
		@if ($facebook->stories == "sim" )
		<input type="radio" name="stories" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="stories" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="stories" value="não"  checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Publicações com interação:</label>
		<br>
		@if ($facebook->stories == "sim" )
		<input type="radio" name="interaction" value="sim"  checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="não" >
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="interaction" value="sim" >
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="interaction" value="não"  checked="checked">
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
			@if ($facebook->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($facebook->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($facebook->status == "pendente")
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
