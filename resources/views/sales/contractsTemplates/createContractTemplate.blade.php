@extends('layouts/master')

@section('title','MODELOS DE CONTRATO')

@section('image-top')
{{ asset('images/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contractTemplate')}}
@endsection

@section('main')
<div>
	<form action=" {{ route('contractTemplate.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >NOME DO MODELO:</label>
		<input type="text" name="name"value="">
		<br>
		<br>
		<label class="labels" for="" >TEXTO DO CONTRATO:</label>
		<br>
		Inicie a numeração do contrato pelo número 4.
		<textarea id="text" name="text" rows="20" cols="90">
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
		CKEDITOR.replace('text');
		</script>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>     
@endsection