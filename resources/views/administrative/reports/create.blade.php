@extends('layouts/master')

@section('title','CRIAR BRIEFING')

@section('image-top')
{{ asset('images/colaborador.png') }} 
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
	<a href="{{route('linkedin.create')}}" class="btn btn-secondary">
		LINKEDIN
	</a>
	<a href="{{route('twitter.create')}}" class="btn btn-secondary">
		TWITTER
	</a>
</p>
<br>
@endif
<p class="title-reports">DADOS DO RELATÓRIO </p>
<br>
<form action=" {{ route('report.store') }} " method="post">
	@csrf
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
	<label  class="labels" for="">Recomendações gerais: </label>
	<br>
	<textarea id="general" name="general" rows="20" cols="90">
	</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
	<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script>
CKEDITOR.replace('general');
	</script>
	<br>
	<label  class="labels" for="">Público Alvo e Persona: </label>
	<br>
	<textarea id="target" name="target" rows="20" cols="90">
	</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
	<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
	<script>
CKEDITOR.replace('target');
	</script>
	
	<input class="btn btn-secondary" type="submit" value="CRIAR RELATÓRIO">
</form>
@endsection