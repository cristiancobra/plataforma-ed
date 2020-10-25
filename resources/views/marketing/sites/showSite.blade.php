@extends('layouts/master')

@section('title','SITES')

@section('image-top')
{{ asset('imagens/site.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('site.index')}}">VER SITES</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $site->name }}
</h1>
<label class="labels" for="" >ENDEREÇO PARA VISUALIZAR:: </label>
<span class="fields">{{$site->link_view }}</span>
<br>
<label class="labels" for="" >ENDEREÇO PARA EDITAR:: </label>
<span class="fields">{{$site->link_edit }}</span>
<br>
<label class="labels" for="" >SENHA DO SITE:</label>
<span class="fields">{{$site->site_password }}</span>
<br>
<label class="labels" for="" >HOSPEDAGEM:</label>
<span class="fields">{{$site->hosting }}</span>
<br>
<label class="labels" for="" >LINK DA HOSPEDAGEM:</label>
<span class="fields">{{$site->link_hosting }}</span>
<br>
<label class="labels" for="" >SENHA DA HOSPEDAGEM:</label>
<span class="fields">{{$site->hosting_password }}</span>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO::</label>
<span class="fields">{{ date('d/m/Y', strtotime($site->creation_date)) }}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$site->status }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($site->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('site.destroy', ['site' => $site->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('site.edit', ['site' => $site->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('site.index')}}">VOLTAR</a>
</div>
<br>

@endsection