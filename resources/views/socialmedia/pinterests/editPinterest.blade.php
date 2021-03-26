@extends('layouts/master')

@section('title','PINTEREST')

@section('image-top')
{{ asset('imagens/pinterest.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('pinterest.index')}}">VER TODOS</a>
@endsection

@section('main')
<br>
<form action=" {{ route('pinterest.update', ['pinterest' =>$pinterest->id]) }} " method="post" style="padding: 40px;color: #874983">
	@csrf
	@method('put')
	<div style="padding-left: 6%">
		<label class="labels" for="" >NOME DA PÁGINA:</label>
		<input type="text" name="page_name" size="20" value="{{ $pinterest->page_name }}"><span class="fields"></span><br>
		<label class="labels" for="" >ENDEREÇO DA PÁGINA:</label>
		<input type="text" name="URL_name" value="{{ $pinterest->URL_name }}" size="50"><span class="fields"></span><br>
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
		@if ($pinterest->business == "yes")
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
		<label class="labels" for="">Conta vinculada com site: </label>
		<br>
		@if ($pinterest->linked_site == "yes")
		<input type="radio" name="linked_site" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_site" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="linked_site" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="linked_site" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		@if ($pinterest->same_site_name == "yes")
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
		@if ($pinterest->about == "yes")
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
		<label class="labels" for="">Possui pastas de ideias:</label>
		<br>
		@if ($pinterest->pin_content == "yes")
		<input type="radio" name="pin_content" value="yes" checked="checked">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="pin_content" value="no">
		<span class="fields">Não</span>
		<br>
		@else
		<input type="radio" name="pin_content" value="yes">
		<span class="fields">Sim</span>
		<br>
		<input type="radio" name="pin_content" value="no" checked="checked">
		<span class="fields">Não</span>
		<br>
		@endif
		<br>
		<label class="labels" for="">Investimento em ADs:</label>
		<input type="number" name="value_ads" step="10"  value="{{ $pinterest->value_ads }}">
		<br>
		<br>
		<label class="labels" for="">STATUS:</label>
		<select class="fields" name="status">
			<option value="{{ $pinterest->status }}">{{ $pinterest->status}}</option>
			@if ($pinterest->status == "desativado")
			<option value="ativo">ativo</option>
			<option value="pendente">pendente</option>
			@elseif  ($pinterest->status == "ativo")
			<option value="desativado">desativado</option>
			<option value="pendente">pendente</option>
			@elseif  ($pinterest->status == "pendente")
			<option value="ativo">ativo</option>
			<option value="desativado">desativado</option>
			@endif
		</select>
		<br>
		<br>
		<input class="button-secondary" type="submit" value="ATUALIZAR">
		</form>
	</div>     
	@endsection
