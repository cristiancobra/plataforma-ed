@extends('layouts/master')

@section('title','CRIAR BRIEFING')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href=" {{ route('report.index') }}">VER RELATÓRIOS</a>
@endsection

@section('main')
@if($errors->any())
<br>
<p class="alert-danger">
	{{$errors->first()}}
	<a href="{{route('facebook.create')}}" class="btn btn-secondary">
		FACEBOOK
	</a>
	<a href="{{route('instagram.create')}}" class="btn btn-secondary">
		INSTAGRAM
	</a>
		<a href="{{route('facebook.create')}}" class="btn btn-secondary">
		LINKEDIN
	</a>
	<a href="{{route('instagram.create')}}" class="btn btn-secondary">
		TWITTER
	</a>
</p>
<br>
@endif
<p class="title-reports">DADOS DO RELATÓRIO </p>
<br>
<form action=" {{ route('report.store') }} " method="post">
	@csrf
	<label class="labels" for="" >DONO: </label>
	<select class="fields" name="user_id">
		@foreach ($users as $user)
		<option value="{{ $user->id }}">
			{{ $user->name }}
		</option>
		@endforeach
	</select>
	<br>
	<label  class="labels" for="">Nome do relatório: </label>
	<input class="fields" type="text" name="name">
	<br>
	<label class="labels" for="">Data da realização: </label>
	<input class="fields" type="date" name="date">
	<br>
	<label class="labels" for="">Situação: </label>
	<select class="fields" name="status">
		<option value="pending">pendente</option>
		<option value="disable">desativado</option>
		<option value="active">ativo</option>
	</select>
	<br>
	<br>
	<p class="title-reports">IDENTIDADE VISUAL </p>
	<br>
	<label class="labels" for="" >Possui logomarca: </label><br>
	<input type="radio" name="logo" value="good" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="logo" value="bad"><span class="fields">Sim, mas precisa de adequações</span><br>
	<input type="radio" name="logo" value="no"><span class="fields">Não possui</span><br>
	<br>
	<br>
	<label class="labels" for="" >Paleta de cores? [Kit de UI ]</label>
	<br>
	<input type="radio" name="palette" value="good" checked="checked"><span class="fields">Sim</span><br>
	<input type="radio" name="palette" value="bad"><span class="fields">Sim, mas precisa de adequações</span><br>
	<input type="radio" name="palette" value="no"><span class="fields">Não possui</span><br>
	<br>
	<input class="btn btn-secondary"  type="submit" value="Gerar relatório">
	<br>
	<br>
	@endsection