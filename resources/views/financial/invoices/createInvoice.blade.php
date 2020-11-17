@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('invoice.index') }}">VER FATURAS</a>
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
	<form action=" {{ route('invoice.store') }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		<label class="labels" for="" >OPORTUNIDADE: </label>
		<select name="opportunitie_id">
			@foreach ($opportunities as $opportunitie)
			<option  class="fields" value="{{ $opportunitie->id }}">
				{{ $opportunitie->name }}
			</option>
			@endforeach
		</select>
		<a class="btn btn-secondary" href="{{ route('opportunitie.create') }}">CRIAR</a>
		<br>
		<label class="labels" for="" >VENDEDOR: </label>
		<select name="user_id">
			<option  class="fields" value="{{ $userAuth->id}}" checked>
				{{ $userAuth->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_creation" size="20" value="{{old('date_creation')}}"><span class="fields"></span>
		@if ($errors->has('date_creation'))
		<span class="text-danger">{{ $errors->first('date_creation') }}</span>
		@endif
		<br>
		<label class="labels" for="" >DATA DO PAGAMENTO:</label>
		<input type="date" name="pay_day" size="20" value="{{old('pay_day')}}"><span class="fields"></span>
		@if ($errors->has('pay_day'))
		<span class="text-danger">{{ $errors->first('pay_day') }}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >OBSERVAÇÕES:</label>
		<textarea id="description" name="description" rows="20" cols="90">
		{{ $invoice->description }}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="" >PRODUTOS: </label>
		<table class="table-list">
			<tr>
				<td   class="table-list-header">
					<b>QTDE </b>
				</td>
				<td   class="table-list-header">
					<b>FOTO </b>
				</td>
				<td   class="table-list-header">
					<b>NOME </b>
				</td>
				<td   class="table-list-header">
					<b>HORAS</b>
				</td>
				<td   class="table-list-header">
					<b>CUSTOS</b>
				</td>
				<td   class="table-list-header">
					<b>IMPOSTO</b>
				</td>
				<td   class="table-list-header">
					<b>MARGEM</b>
				</td>
				<td   class="table-list-header">
					<b>PREÇO</b>
				</td>
			</tr>

			@foreach ($products as $product)
			<tr style="font-size: 14px">

			<input type="hidden" name="product_id[]" value="{{ $product->id }}"><span class="fields"></span>
			<td class="table-list-center">
				<input type="number" name="product_amount[]" size="4"><span class="fields"></span>
			</td>

			<td class="table-list-right">
				<image src="{{$product->image}}" style="width:50px;height:50px; margin: 5px"></a>
			</td>

			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('product.show', ['product' => $product->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('product.edit', ['product' => $product->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				<input type="hidden" name="product_name[]" size="16" value="{{ $product->name }}"><span class="fields"></span>
				{{ $product->name }}
			</td>

			<td class="table-list-center">
				<input type="hidden" name="product_work_hours[]" size="4" value="{{$product->work_hours}}">
				{{ number_format($product->work_hours)}}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="product_cost[]" size="7" value="{{ $product->cost1 + $product->cost2 + $product->cost3}}" >
				{{ number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".") }}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="product_tax_rate[]" size="7" value="{{ $product->price * $product->tax_rate / 100 }}" >
				{{ number_format($product->price * $product->tax_rate / 100, 2,",",".") }}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="product_margin[]" size="7" value="{{ -$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price }}" >
				{{ number_format(-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".") }}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="product_price[]" size="7" value="{{ $product->price}}" >
				{{ number_format($product->price, 2,",",".") }}
			</td>

			</tr>
			@endforeach
		</table>
		<br>
		<br>
		<label class="labels" for="" >DESCONTO:</label>
		<input type="number" min="0" step="any" name="discount" size="20"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		<select class="fields" name="status">
			<option value="pendente">pendente</option>
			<option value="aprovada">aprovada</option>
			<option value="concluida">concluida</option>
			<option value="cancelada">cancelada</option>
		</select>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR FATURA">
	</form>
</div>     
@endsection