@extends('layouts/master')

@section('title','DOMÍNIOS')

@section('image-top')
{{ asset('imagens/domain.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('domain.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('domain.store') }} " method="post" style="color: #874983">
		@csrf
		<label class="labels" for="" >DOMÍNIO:</label>
		<input type="text" name="name" size="60" value="{{$domain->name}}"><span class="fields"></span>
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
		<label class="labels" for="" >SITE: </label>
		<select name="site_id">
			@foreach ($sites as $site)
			<option  class="fields" value="{{ $site->id }}">
				{{ $site->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >NOME DO TITULAR:</label>
		<input type="text" name="holder" size="60" value="{{$domain->holder}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >PROVEDOR DO DOMÍNIO:</label>
		<input type="text" name="provider" size="60" value="{{$domain->provider}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >LINK DO PROVEDOR:</label>
		<input type="text" name="link_provider" size="60" value="{{$domain->link_provider}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >SENHA DO PROVEDOR:</label>
		<input type="text" name="provider_password" size="60" value="{{$domain->domain_password}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >DATA DE VENCIMENTO:</label>
		<input type="date" name="due_date" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
		<option value="pendente">pendente</option>
		<option value="desativado">desativado</option>
		<option value="ativo">ativo</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>     
@endsection