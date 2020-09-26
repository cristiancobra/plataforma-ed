@extends('layouts/master')

@section('title','NOVA PÁGINA')

@section('image-top')
{{ asset('imagens/pinterest.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('pinterest.index') }}">VER PÁGINAS</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('pinterest.store') }} " method="post" style="padding: 40px;color: #874983">
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
		<label class="labels" for="">Possui conta Business:</label>
		<br>
		<input type="radio" name="business" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="business" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Conta vinculada com site: </label>
		<br>
		<input type="radio" name="linked_site" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="linked_site" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Conta possui mesmo nome do site: </label>
		<br>
		<input type="radio" name="same_site_name" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="same_site_name" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Descrição do perfil:</label>
		<br>
		<input type="radio" name="about" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="about" value="no"><span class="fields">Não</span><br>
		<br>
		<label class="labels" for="">Publica conteúdos no feed:</label>
		<br>
		<input type="radio" name="pin_content" value="yes" checked="checked"><span class="fields">Sim</span><br>
		<input type="radio" name="pin_content" value="no"><span class="fields">Não</span><br>
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