@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href="{{route('invoice.index')}}">VER FATURAS</a>
@endsection

@section('main')
<div style="padding-left: 6%">
	<form action=" {{ route('invoice.update', ['invoice' =>$invoice->id]) }} " method="post" style="padding: 40px;color: #874983">
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
		<input type="date" name="date_creation" size="20" value="{{$invoice->date_creation}}"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DO PAGAMENTO:</label>
		<input type="date" name="pay_day" size="20" value="{{$invoice->pay_day}}"><span class="fields"></span>
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
		<label class="labels" for="" >PRODUTOS:</label>
		<table class="table-list">
			<tr>
				<td   class="table-list-header">
					<b>QTDE</b>
				</td>
				<td   class="table-list-header">
					<b>FOTO</b>
				</td>
				<td   class="table-list-header">
					<b>NOME</b>
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

			@foreach ($invoiceLines as $invoiceLine)
			<tr style="font-size: 14px">
				<td class="table-list-center">
					<input type="number" name="{{$product++}}" size="4"
						   @if ($invoice->$product++ == $product->name)
					value="{{$invoiceLine->$amount}}"
					@endif
					>
					<span class="fields"></span>
				</td>

				<td class="table-list-right">
					<image src="{{ $product->image }}" style="width:50px;height:50px; margin: 5px"></a>
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
					<input type="hidden" name="{{$name}}" size="16" value="{{ $product->name }}"><span class="fields"></span>
					{{ $product->name }}
				</td>

				<td class="table-list-center">
					<input type="hidden" name="{{$hours}}" size="4" value="{{$product->work_hours}}">
					{{ number_format($product->work_hours)}}
				</td>

				<td class="table-list-right">
					<input type="hidden" name="{{$cost}}" size="7" value="{{ $product->cost1 + $product->cost2 + $product->cost3}}" >
					{{ number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".") }}
				</td>

				<td class="table-list-right">
					<input type="hidden" name="{{$tax_rate}}" size="7" value="{{ $product->price * $product->tax_rate / 100 }}" >
					{{ number_format($product->price * $product->tax_rate / 100, 2,",",".") }}
				</td>

				<td class="table-list-right">
					<input type="hidden" name="{{$margin}}" size="7" value="{{ -$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price }}" >
					{{ number_format(-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".") }}
				</td>

				<td class="table-list-right">
					<input type="hidden" name="{{$price}}" size="8" value="{{$product->price}}" >
					{{ number_format($product->price,2,",",".") }}
				</td>

			</tr>
			@php
			$name++;
			$amount++;
			$hours++;
			$cost++;
			$tax_rate++;
			$price++;
			@endphp
			@endforeach
		</table>
		<br>
		<br>
		<label class="labels" for="" >DESCONTO:</label>
		<input type="number" min="0" step="any" name="discount" size="20"><span class="fields"></span>
		<br>
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
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection