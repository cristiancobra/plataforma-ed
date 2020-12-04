@extends('layouts/master')

@section('title','PRODUTOS')

@section('image-top')
{{ asset('imagens/products.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalProducts }} </span>
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('product.index')}}">
	VOLTAR
</a>
<a class="button-primary"  href="{{route('product.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 5%">
				<b>Foto</b>
			</td>
			<td   class="table-list-header" style="width: 30%">
				<b>Nome </b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Tipo </b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>Entrega</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Horas</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Custos</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Imposto</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Margem</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Preço</b>
			</td>
		</tr>

		@foreach ($products as $product)
		<tr style="font-size: 14px">
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
				{{ $product->name }}
			</td>

			<td class="table-list-right">
				{{ $product->type }}
			</td>

			@if ($product->due_date == 0)
			<td class="table-list-right">
				imediata
			</td>
			@else
			<td class="table-list-right">
				{{ $product->due_date }} dias
			</td>
			@endif

			<td class="table-list-center">
				{{ number_format($product->work_hours)}}
			</td>

			<td class="table-list-right">
				R$ {{ number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".") }}
			</td>

			<td class="table-list-right">
				R$ {{ number_format($product->price * $product->tax_rate / 100, 2,",",".") }}
			</td>

			<td class="table-list-right">
				R$ {{ number_format(-$product->price * $product->tax_rate /100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".") }}
			</td>

			<td class="table-list-right">
				R$ {{ number_format($product->price,2,",",".") }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $products->links() }}
	</p>
</div>
	<br>
	@endsection