@extends('layouts/master')

@if($variation == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

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
<a class="button-primary"  href="{{route('product.create', ['variation' => $variation])}}">
	CRIAR
</a>
@endsection

@section('main')
<form action="{{route('product.index')}}" method="post" style="text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da oportunidade" value="">
	<select class="select" name="account_id">
		<option  class="select" value="">
			Qualquer empresa
		</option>
		@foreach ($accounts as $account)
		<option  class="select" value="{{$account->id}}">
			{{$account->name}}
		</option>
		@endforeach
		<option  class="select" value="">
			todas
		</option>
	</select>
	{{createFilterSelect('status', 'select', returnInvoiceStatus())}}
	{{returnType('type', 'select', 'product')}}
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 5%">
				Foto
			</td>
			<td   class="table-list-header" style="width: 30%">
				Nome 
			</td>
			<td   class="table-list-header" style="width: 10%">
				Categoria 
			</td>
			<td   class="table-list-header" style="width: 5%">
				Entrega
			</td>
			<td   class="table-list-header" style="width: 10%">
				Horas
			</td>
			<td   class="table-list-header" style="width: 10%">
				Custos
			</td>
			<td   class="table-list-header" style="width: 10%">
				Imposto
			</td>
			<td   class="table-list-header" style="width: 10%">
				Margem
			</td>
			<td   class="table-list-header" style="width: 10%">
				Preço
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

			<td class="table-list-center">
				{{ $product->category }}
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