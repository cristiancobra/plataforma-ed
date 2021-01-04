@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('invoice.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('invoice.update', ['invoice' =>$invoice]) }} " method="post" style="padding: 40px;color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >OPORTUNIDADE: </label>
		<input type="hidden" name="opportunity_id" value="{{$invoice->opportunity_id}}">
		<span class="fields">{{$invoice->opportunity->name}}</span>
		<br>
		<label class="labels" for="" >VENDEDOR: </label>
		<select name="user_id">
			<option  class="fields" value="{{$invoice->user->id}}">
				{{$invoice->user->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->contact->name }}
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
					<b>PRAZO</b>
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
			<input type="hidden" name="{{$id}}" size="16" value="{{$invoiceLine->id}}">
			<input type="hidden" name="{{$productId}}" size="16" value="{{$invoiceLine->product->id}}">
			<td class="table-list-center">
				<input type="number" name="{{$amount}}" size="4" value="{{$invoiceLine->amount}}">
				<span class="fields"></span>
			</td>
			<td class="table-list-right">
				<image src="{{$invoiceLine->product->image}}" style="width:50px;height:50px; margin: 5px"></a>
			</td>
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('product.show', ['product' => $invoiceLine->product->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('product.edit', ['product' => $invoiceLine->product->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				<input type="hidden" name="{{$name}}" size="16" value="{{$invoiceLine->product->name}}">
				<span class="fields">{{$invoiceLine->product->name}}</span>
			</td>
			<td class="table-list-center">
				<input type="hidden" name="{{$dueDate}}" size="4" value="{{$invoiceLine->product->due_date}}">
				{{ number_format($invoiceLine->product->due_date)}}
			</td>
			<td class="table-list-center">
				<input type="hidden" name="{{$hours}}" size="4" value="{{$invoiceLine->product->work_hours}}">
				{{ number_format($invoiceLine->product->work_hours)}}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="{{$cost}}" size="7" value="{{ $invoiceLine->product->cost1 + $invoiceLine->product->cost2 + $invoiceLine->product->cost3}}" >
				{{ number_format($invoiceLine->product->cost1 + $invoiceLine->product->cost2 + $invoiceLine->product->cost3, 2,",",".") }}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="{{$taxRate}}" size="7" value="{{ $invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 }}" >
				{{ number_format($invoiceLine->product->price * $invoiceLine->product->tax_rate / 100, 2,",",".") }}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="{{$margin}}" size="7" value="{{ -$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 - $invoiceLine->product->cost1 - $invoiceLine->product->cost2 - $invoiceLine->product->cost3 + $invoiceLine->product->price }}" >
				{{ number_format(-$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 - $invoiceLine->product->cost1 - $invoiceLine->product->cost2 - $invoiceLine->product->cost3 + $invoiceLine->product->price, 2,",",".") }}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="{{$price}}" size="8" value="{{$invoiceLine->product->price}}" >
				{{ number_format($invoiceLine->product->price,2,",",".") }}
			</td>
			</tr>
			@php
			$id++;
			$productId++;
			$name++;
			$amount++;
			$hours++;
			$dueDate++;
			$cost++;
			$taxRate++;
			$margin++;
			$price++;
			@endphp
			@endforeach
			<tr>
				<td   class="table-list-header-right" colspan="7"></td>
				<td   class="table-list-header-right">
					desconto: 
				</td>
				<td   class="table-list-header-right">
					<b>- {{number_format($invoice->discount, 2,",",".")}}</b>
				</td>
			</tr>
			<tr>
				<td   class="table-list-header-right" colspan="7">
				<td   class="table-list-header-right">
					TOTAL: 
				</td>
				</td>
				<td   class="table-list-header-right">
					<b>R$ {{number_format($invoice->totalPrice, 2,",",".") }}</b>
				</td>
			</tr>
		</table>
		<br>
		<br>
		<label class="labels" for="" >DESCONTO:</label>
		<input type="number" min="0" step="any" name="discount" size="20" value="{{$invoice->discount}}"><span class="fields"></span>
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