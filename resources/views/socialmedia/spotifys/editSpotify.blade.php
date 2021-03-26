@extends('layouts/master')

@section('title','EDITAR SPOTIFY')

@section('image-top')
{{ asset('imagens/spotify.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('spotify.index')}}">VER SPOTIFYS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('spotify.update', ['spotify' =>$spotify->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20" value="{{ $spotify->page_name }}"><span class="fields"></span><br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" value="{{ $spotify->URL_name }}" size="50"><span class="fields"></span><br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $spotify->account->id }}">
				{{ $spotify->account->name }}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>

		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		@if ($spotify->same_site_name == "yes")
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
		<label class="labels" for="">Descrição:</label>
		<br>
		@if ($spotify->about == "yes")
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
		<label class="labels" for="">Publica podcast:</label>
		<br>
		@if ($spotify->feed_content == "yes")
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
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10"  value="{{ $spotify->value_ads }}">
		<br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="{{ $spotify->status }}">{{ $spotify->status}}</option>
			@if ($spotify->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($spotify->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($spotify->status == "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		{{submitFormButton('SALVAR')}}
		</form>
	</div>     
	@endsection
