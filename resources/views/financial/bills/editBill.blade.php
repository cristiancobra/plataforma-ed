@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/bill.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('bill.index')}}">VER FATURAS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('bill.update', ['bill' =>$bill->id]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
			<label class="labels" for="" >OPORTUNIDADE: </label>
		<select name="opportunitie_id">
			@foreach ($opportunities as $opportunitie)
			<option  class="fields" value="{{ $opportunitie->id }}">
				{{ $opportunitie->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_creation" size="20" value="{{$bill->date_creation}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DO PAGAMENTO:</label>
		<input type="date" name="pay_day" size="20" value="{{$bill->pay_day}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >OBSERVAÇÕES:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $bill->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="pendente">pendente</option>
			<option value="desativado">desativado</option>
			<option value="ativo">ativo</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection