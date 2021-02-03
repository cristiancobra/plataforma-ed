@extends('layouts/master')

@section('title','MODELOS DE CONTRATO')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contractTemplate.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{route('contractTemplate.update', ['contractTemplate' => $contractTemplate->id])}} " method="post" style="color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			<option  class="fields" value="{{$contractTemplate->account_id}}">
				{{$contractTemplate->account->name}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >NOME DO MODELO:</label>
		<input type="text" name="name"value="{{$contractTemplate->name}}">
		<br>
		<br>
		<label class="labels" for="" >TEXTO DO CONTRATO:</label>
		<textarea id="text" name="text" rows="20" cols="90">
{{$contractTemplate->text}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
		CKEDITOR.replace('text');
		</script>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR">
	</form>
</div>
<br>
<br>
@endsection