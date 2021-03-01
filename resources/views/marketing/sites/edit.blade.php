@extends('layouts/master')

@section('title','SITES')

@section('image-top')
{{ asset('imagens/site.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('site.index')}}">
	VER TODOS
</a>
@endsection

@section('main')
<div>
	<form action=" {{route('site.update', ['site' =>$site->id])}} " method="post">
		@csrf
		@method('put')
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="60" value="{{$site->name}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{$site->account_id}}">
				{{$site->account->name}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >ENDEREÇO PARA VISUALIZAR:</label><span style='margin-left:20px'>https://</span>
		<input type="text" name="link_view" size="60" value="{{$site->link_view}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >ENDEREÇO PARA EDITAR:</label><span style='margin-left:20px'>https://</span>
		<input type="text" name="link_edit" size="60" value="{{$site->link_edit}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LOGIN DO SITE:</label>
		<input type="text" name="site_login" size="60" value="{{$site->site_login}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >SENHA DO SITE:</label>
		<input type="text" name="site_password" size="60" value="{{$site->site_password}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >HOSPEDAGEM:</label>
		<input type="text" name="hosting" size="60" value="{{$site->hosting}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LINK DA HOSPEDAGEM:</label><span style='margin-left:20px'>https://</span>
		<input type="text" name="link_hosting" size="60" value="{{$site->link_hosting}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LOGIN DA HOSPEDAGEM:</label>
		<input type="text" name="hosting_login" size="60" value="{{$site->hosting_login}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >SENHA DA HOSPEDAGEM:</label>
		<input type="text" name="hosting_password" size="60" value="{{$site->hosting_password}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="creation_date" size="20"  value="{{$site->creation_date}}"><span class="fields"></span>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		{{editSelect('status', 'fields', returnStatusActive(), $site->status)}}
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection