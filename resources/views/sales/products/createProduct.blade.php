@extends('layouts/master')

@if($type == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

@section('image-top')
{{ asset('imagens/products.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('product.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
@if(Session::has('failed'))
<div class="alert alert-danger">
	{{ Session::get('failed') }}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{ route('product.store') }} " method="post" style="color: #874983">
		@csrf
		@if($type == 'receita')
		<input type="hidden" name="type" value="receita">
		@else
		<input type="hidden" name="type" value="expense">
		@endif
		<label class="labels" for="" >NOME:</label>
		<input type="text" name="name" size="20" value="{{old('name')}}"><span class="fields"></span>
		@if ($errors->has('name'))
		<span class="text-danger">{{ $errors->first('name') }}</span>
		@endif
		<br>
		<label class="labels" for="" >FOTO:</label>
		<input type="text" name="image" size="20" value=""><span class="fields"></span>
		<br>
		<label class="labels" for="" >DONO: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >CATEGORIA:</label>
		{{createSelect('category', 'fields', returnProductCategory())}}
		<br>
		<br>
		<label class="labels" for="" >DESCRIÇÃO:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		@if($type == 'receita')
		<label class="labels" for="" >HORAS NECESSÁRIAS:</label>
		<input type="decimal" name="work_hours" size="5" value=""><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >IMPOSTO (%):</label>
		<input type="decimal" name="tax_rate" size="5" value=""><span class="fields"></span>
		<br>
		<br>
		@endif
		<label class="labels" for="" >PREÇO:</label>
		<input type="integer" name="price" size="5" value=""><span class="fields"></span>
		@if ($errors->has('price'))
		<span class="text-danger">{{ $errors->first('price') }}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >PRAZO DE ENTREGA:</label>
		<input type="integer" name="due_date" size="5" value=""><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		{{createSelect('status', 'fields', returnProductStatus())}}
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR PRODUTO">
	</form>
</div>     
@endsection