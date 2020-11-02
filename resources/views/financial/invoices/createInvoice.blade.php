@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('invoice.index') }}">VER FATURAS</a>
@endsection

@section('main')
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
		<br>
		<label class="labels" for="" >VENDEDOR: </label>
		<select name="user_id">
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >CATEGORIA: </label>
		<select name="category">
			<option value="Agricultura">Agricultura</option>
			<option value="Biotecnologia">Biotecnologia</option>
			<option value="Química">Substâncias e produtos químicos</option>
			<option value="Aeroespacial">Aeroespacial</option>
			<option value="Computadores e hardware">Computadores e hardware</option>
			<option value="Construção">Construção</option>
			<option value="Consultoria">Consultoria</option>
			<option value="Produtos de consumo">Produtos de consumo</option>
			<option value="Serviços ao consumidor">Serviços ao consumidor</option>
			<option value="Marketing digital">Marketing digital</option>
			<option value="Educação">Educação</option>
			<option value="Eletrônica">Eletrônica</option>
			<option value="Moda">Moda</option>
			<option value="Serviços financeiros">Serviços financeiros</option>
			<option value="Alimentos e bebidas">Alimentos e bebidas</option>
			<option value="Jogos">Jogos</option>
			<option value="Serviços de saúde">Serviços de saúde</option>
			<option value="Indústria">Indústria</option>
			<option value="Internet/serviços da web">Internet/serviços da web</option>
			<option value="Serviços de TI">Serviços de TI</option>
			<option value="Jurídico">Jurídico</option>
			<option value="Estilo de vida">Estilo de vida</option>
			<option value="Marítimo">Marítimo</option>
			<option value="Marketing/publicidade">Marketing/publicidade</option>
			<option value="Mídias e entretenimento">Mídias e entretenimento</option>
			<option value="Mineração">Mineração</option>
			<option value="Petróleo e gás">Petróleo e gás</option>
			<option value="Política">Política</option>
			<option value="Imóveis">Imóveis</option>
			<option value="Varejo/distribuição">Varejo/distribuição</option>
			<option value="Segurança">Segurança</option>
			<option value="Software">Software</option>
			<option value="Esportes">Esportes</option>
			<option value="Telecomunicações">Telecomunicações</option>
			<option value="Transportes">Transportes</option>
			<option value="Turismo">Turismo</option>
			<option value="Outros">Outros</option>
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
		<input type="date" name="date_creation" size="20"><span class="fields"></span>
		<br>
		<label class="labels" for="" >DATA DO PAGAMENTO:</label>
		<input type="date" name="pay_day" size="20"><span class="fields"></span>
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

			<input type="hidden" name="product_id[]" size="4"><span class="fields"></span>
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
				<input type="hidden" name="" size="16" value="{{ $product->name }}"><span class="fields"></span>
				{{ $product->name }}
			</td>

			<td class="table-list-center">
				<input type="hidden" name="" size="4" value="{{$product->work_hours}}">
				{{ number_format($product->work_hours)}}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="" size="7" value="{{ $product->cost1 + $product->cost2 + $product->cost3}}" >
				{{ number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".") }}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="" size="7" value="{{ $product->price * $product->tax_rate / 100 }}" >
				{{ number_format($product->price * $product->tax_rate / 100, 2,",",".") }}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="" size="7" value="{{ -$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price }}" >
				{{ number_format(-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".") }}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="" size="8" value="{{$product->price}}" >
				{{ number_format($product->price,2,",",".") }}
			</td>

			</tr>
			@endforeach
		</table>
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
		<input class="btn btn-secondary" type="submit" value="CRIAR FATURA">
	</form>
</div>     
@endsection