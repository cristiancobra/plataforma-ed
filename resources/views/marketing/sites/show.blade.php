@extends('layouts/master')

@section('title','SITES')

@section('image-top')
{{ asset('imagens/site.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('site')}}
@endsection

@section('main')
<br>
<h1 class="name">
	{{$site->name}}
</h1>
<br>
<label class="labels" for="" >DOMÍNIOS:</label>
<br>
@foreach ($site->domains as $domain)
{{$domain->name}}
{{createButtonShow($domain, 'domain')}}
{{createButtonExternalLink($domain->name)}}
<br>
@endforeach
<br>
<label class="labels" for="" >ENDEREÇO PARA EDITAR:</label>
<span class="fields">{{$site->link_edit}}</span>
@if(!empty($site->link_edit))
<button class="button-round">
	<a href="//{{$site->link_edit}}" target="_blank">
		<i class='fa fa-rocket' style="color:white"></i>
	</a>
</button>
@endif
<br>
<label class="labels" for="" >LOGIN DO SITE:</label>
<span class="fields">{{$site->site_login}}</span>
<br>
<label class="labels" for="" >SENHA DO SITE:</label>
<span class="fields">{{$site->site_password}}</span>
<br>
<br>
<label class="labels" for="" >HOSPEDAGEM:</label>
<span class="fields">{{$site->hosting}}</span>
<br>
<label class="labels" for="" >LINK DA HOSPEDAGEM:</label>
<span class="fields">{{$site->link_hosting}}</span>
@if(!empty($site->link_hosting))
<button class="button-round">
	<a href="//{{$site->link_hosting}}" target="_blank">
		<i class='fa fa-rocket' style="color:white"></i>
	</a>
</button>
@endif
<br>
<label class="labels" for="" >LOGIN DA HOSPEDAGEM:</label>
<span class="fields">{{$site->hosting_login}}</span>
<br>
<label class="labels" for="" >SENHA DA HOSPEDAGEM:</label>
<span class="fields">{{$site->hosting_password}}</span>
<br>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO::</label>
<span class="fields">{{date('d/m/Y', strtotime($site->creation_date))}}</span>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$site->status}}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{date('d/m/Y H:i', strtotime($site->created_at))}} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{route('site.destroy', ['site' => $site->id])}}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{route('site.edit', ['site' => $site->id])}} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('site.index')}}"><i class="fas fa-arrow-left"></i></a>
</div>
<br>

@endsection