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
<form action=" {{ route('linkedin.update', ['linkedin' =>$linkedin->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >
			NOME DA PÁGINA:
		</label>
		<input type="text" name="page_name" size="20" value="{{ $linkedin->page_name }}"><span class="fields"></span>
		<label class="labels" for="" >
			ENDEREÇO DA PÁGINA:
		</label>
		<input type="text" name="URL_name" value="{{ $linkedin->URL_name }}" size="50"><span class="fields"></span>
		<label class="labels" for="" >
			DONO:
		</label>
		<select name="account_id">
			<option  class="fields" value="{{ $linkedin->account->id }}">
				{{ $linkedin->account->name }}
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
		@if ($linkedin->business == "yes")
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
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		@if ($linkedin->same_site_name == "yes")
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
		@if ($linkedin->about == "yes")
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
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		@if ($linkedin->feed_content == "yes")
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
		<label class="labels" for="">Publicações usam SEO:</label>
		<br>
		@if ($linkedin->SEO_descriptions == "yes")
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
		<label class="labels" for="">Imagens têm tamanho correto:</label>
		<br>
		@if ($linkedin->feed_images == "yes")
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
		<label class="labels" for="">Funcionários possuem perfil na rede:</label>
		<br>
		@if ($linkedin->employee_profiles == "yes")
		<input type="radio" name="employee_profiles" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="employee_profiles" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="employee_profiles" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="employee_profiles" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Anuncia/aceita vagas na rede:</label>
		<br>
		@if ($linkedin->offers_job == "yes")
		<input type="radio" name="offers_job" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="offers_job" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="offers_job" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="offers_job" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10"  value="{{ $linkedin->value_ads }}">
		<br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="{{ $linkedin->status }}">{{ $linkedin->status}}</option>
			@if ($linkedin->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($linkedin->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($linkedin->status == "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="button-secondary" type="submit" value="ATUALIZAR LINKEDIN">
		</form>



	</div>     
	@endsection
