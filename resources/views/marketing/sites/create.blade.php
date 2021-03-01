@extends('layouts/master')

@section('title','SITES')

@section('image-top')
{{ asset('imagens/site.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('site.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('site.store') }} " method="post">
		@csrf
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="60" value="{{$site->name}}"><span class="fields"></span>
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
		<label class="labels" for="" >ENDEREÇO PARA VISUALIZAR:</label>
		<input type="text" name="link_view" size="60"><span class="fields"></span>
		<br>
		<label class="labels" for="" >ENDEREÇO PARA EDITAR:</label>
		<input type="text" name="link_edit" size="60"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LOGIN DO SITE:</label>
		<input type="text" name="site_login" size="60"><span class="fields"></span>
		<br>
		<label class="labels" for="" >SENHA DO SITE:</label>
		<input type="text" name="site_password" size="60"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >HOSPEDAGEM:</label>
		<input type="text" name="hosting" size="60"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LINK DA HOSPEDAGEM:</label>
		<input type="text" name="link_hosting" size="60"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LOGIN DA HOSPEDAGEM:</label>
		<input type="text" name="hosting_login" size="60"><span class="fields"></span>
		<br>
		<label class="labels" for="" >SENHA DA HOSPEDAGEM:</label>
		<input type="text" name="hosting_password" size="60"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="creation_date" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		{{createSelect('status', 'fields', returnStatusActive())}}
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>     
@endsection