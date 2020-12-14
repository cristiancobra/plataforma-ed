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
<br>
<h1 class="name">
	{{ $domain->name }}
</h1>
<label class="labels" for="" >EMPRESA: </label>
<span class="fields">{{$domain->account->name }}</span>
<br>
<label class="labels" for="" >SITE:</label>
<span class="fields">{{$domain->holder}}</span>
<br>
<label class="labels" for="" >NOME DO TITULAR:</label>
<span class="fields">{{$domain->holder}}</span>
<br>
<label class="labels" for="" >PROVEDOR DO DOMÍNIO:</label>
<span class="fields">{{$domain->provider}}</span>
<br>
<label class="labels" for="" >LINK DO PROVEDOR:</label>
<span class="fields">{{$domain->link_provider}}</span>
<br>
<label class="labels" for="" >SENHA DO PROVEDOR:</label>
<span class="fields">{{$domain->provider_password}}</span>
<br>
<label class="labels" for="" >DATA DE VENCIMENTO:</label>
<span class="fields">{{date('d/m/Y', strtotime($domain->due_date))}}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$domain->status}}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($domain->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('domain.destroy', ['domain' => $domain->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('domain.edit', ['domain' => $domain->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('domain.index')}}">VOLTAR</a>
</div>
<br>

@endsection