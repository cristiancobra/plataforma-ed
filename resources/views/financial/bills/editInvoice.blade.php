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
	<form action=" {{route('invoice.update', ['invoice' =>$invoice])}} " method="post" style="color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >IDENTIFICADOR:</label>
		<span class="fields">{{$invoice->identifier}}</span>
		<br>
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			<option  class="fields" value="{{$invoice->account_id}}">
				{{$invoice->account->name}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >VENDEDOR: </label>
		<select name="user_id">
			<option  class="fields" value="{{$invoice->user->id}}">
				{{$invoice->user->contact->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{ $user->id }}">
				{{ $user->contact->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label class="labels" for="" >OPORTUNIDADE: </label>
		<input type="hidden" name="opportunity_id" value="{{$invoice->opportunity_id}}">
		<span class="fields">{{$invoice->opportunity->name}}</span>
		<br>
		<label class="labels" for="" >EMPRESA CONTRATANTE:</label>
		<span class="fields">{{$invoice->opportunity->company->name}}</span>
		<button class="button-round">
			<a href="{{route('company.show', ['company' => $invoice->opportunity->company_id])}}">
				<i class='fa fa-eye' style="color:white"></i>
			</a>
		</button>
		<br>
		<label class="labels" for="" >CONTATO:</label>
		<span class="fields">{{$invoice->opportunity->contact->name}}</span>
		<a href="{{route('contact.show', ['contact' => $invoice->opportunity->contact_id])}}">
			<i class='fa fa-eye' style="color:white"></i>
		</a>
		<br>
		<label class="labels" for="" >CONTRATO: </label>
		<select name="contract_id">
			<option  class="fields" value="{{$invoice->contract_id}}">
				{{$invoice->contract_id}}
			</option>
			@foreach ($contracts as $contract)
			<option  class="fields" value="{{ $contract->id }}">
				{{ $contract->id }} - {{ $contract->name }}
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
		{{$invoice->description}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<label class="labels" for="" >PRODUTOS ATUAIS:</label>
		@if($invoice->status != "rascunho" AND $invoice->status != "esboço")
		<br>
		<span class="fa fa-exclamation-triangle"></span>  Itens de faturas aprovadas não podem ser alteradas.
		<br>
		<br>
		@endif
		<table class="table-list">
			<tr>
				<td   class="table-list-header">
					QTDE
				</td>
				<td   class="table-list-header">
					FOTO
				</td>
				<td   class="table-list-header">
					NOME
				</td>
				<td   class="table-list-header">
					HORAS
				</td>
				<td   class="table-list-header">
					PRAZO
				</td>
				<td   class="table-list-header">
					CUSTOS
				</td>
				<td   class="table-list-header">
					IMPOSTO
				</td>
				<td   class="table-list-header">
					MARGEM
				</td>
				<td   class="table-list-header">
					PREÇO
				</td>
			</tr>

			@foreach ($invoiceLines as $invoiceLine)
			<tr style="font-size: 14px">
			<input type="hidden" name="invoiceLine_id[]" size="16" value="{{$invoiceLine->id}}">
			<input type="hidden" name="product_id[]" size="16" value="{{$invoiceLine->product->id}}">
			<td class="table-list-center">
				@if($invoice->status != "rascunho" AND $invoice->status != "esboço")
				{{$invoiceLine->amount}}
				@else
				<input type="number" name="product_amount[]" size="4" value="{{$invoiceLine->amount}}">
				<span class="fields"></span>
				@endif
			</td>
			<td class="table-list-right">
				<image src="{{$invoiceLine->product->image}}" style="width:50px;height:50px; margin: 5px"></a>
			</td>
			<td class="table-list-left">
				<button class="button">
					<a href=" {{route('product.show', ['product' => $invoiceLine->product->id])}}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{route('product.edit', ['product' => $invoiceLine->product->id])}}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				<span class="fields">{{$invoiceLine->product->name}}</span>
			</td>
			<td class="table-list-center">
				<input type="hidden" name="product_due_date[]" size="4" value="{{$invoiceLine->product->due_date}}">
				{{number_format($invoiceLine->product->due_date)}}
			</td>
			<td class="table-list-center">
				<input type="hidden" name="product_work_hours[]" size="4" value="{{$invoiceLine->product->work_hours}}">
				{{number_format($invoiceLine->product->work_hours)}}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="product_cost[]" size="7" value="{{ $invoiceLine->product->cost1 + $invoiceLine->product->cost2 + $invoiceLine->product->cost3}}" >
				{{number_format($invoiceLine->product->cost1 + $invoiceLine->product->cost2 + $invoiceLine->product->cost3, 2,",",".") }}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="product_tax_rate[]" size="7" value="{{$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100}}" >
				{{number_format($invoiceLine->product->price * $invoiceLine->product->tax_rate / 100, 2,",",".") }}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="product_margin[]" size="7" value="{{-$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 - $invoiceLine->product->cost1 - $invoiceLine->product->cost2 - $invoiceLine->product->cost3 + $invoiceLine->product->price}}">
				{{number_format(-$invoiceLine->product->price * $invoiceLine->product->tax_rate / 100 - $invoiceLine->product->cost1 - $invoiceLine->product->cost2 - $invoiceLine->product->cost3 + $invoiceLine->product->price, 2,",",".")}}
			</td>
			<td class="table-list-right">
				<input type="hidden" name="product_price[]" size="8" value="{{$invoiceLine->product->price}}">
				{{number_format($invoiceLine->product->price,2,",",".")}}
			</td>
			</tr>
			@endforeach
			<tr>
				<td   class="table-list-header-right" colspan="7"></td>
				<td   class="table-list-header-right">
					desconto: 
				</td>
				<td   class="table-list-header-right">
					- {{number_format($invoice->discount, 2,",",".")}}
				</td>
			</tr>
			<tr>
				<td   class="table-list-header-right" colspan="7">
				<td   class="table-list-header-right">
					TOTAL: 
				</td>
				</td>
				<td   class="table-list-header-right">
					R$ {{number_format($invoice->totalPrice, 2,",",".") }}
				</td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		@if($invoice->status == "rascunho" OR $invoice->status == "esboço")
		<label class="labels" for="" >ADICIONAR PRODUTOS:</label>
		<table class="table-list">
			<tr>
				<td   class="table-list-header">
					QTDE
				</td>
				<td   class="table-list-header">
					FOTO
				</td>
				<td   class="table-list-header">
					NOME
				</td>
				<td   class="table-list-header">
					HORAS
				</td>
				<td   class="table-list-header">
					PRAZO
				</td>
				<td   class="table-list-header">
					CUSTOS
				</td>
				<td   class="table-list-header">
					IMPOSTO
				</td>
				<td   class="table-list-header">
					MARGEM
				</td>
				<td   class="table-list-header">
					PREÇO
				</td>
			</tr>

			@foreach($products as $product)
			<tr style="font-size: 14px">

			<input type="hidden" name="new_product_id[]" value="{{$product->id}}"><span class="fields"></span>
			<td class="table-list-center">
				<input type="number" name="new_product_amount[]" size="4"><span class="fields"></span>
			</td>

			<td class="table-list-right">
				<image src="{{$product->image}}" style="width:50px;height:50px; margin: 5px"></a>
			</td>

			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('product.show', ['product' => $product->id]) }}">
						<i class='fa fa-eye' style="color:white"></i>
					</a>
				</button>
				<button class="button-round">
					<a href=" {{ route('product.edit', ['product' => $product->id]) }}">
						<i class='fa fa-edit' style="color:white"></i>
					</a>
				</button>
				{{$product->name}}
			</td>

			<td class="table-list-center">
				<input type="hidden" name="new_product_due_date[]" size="4" value="{{$product->due_date}}">
				{{number_format($product->due_date)}}
			</td>
			<td class="table-list-center">
				<input type="hidden" name="new_product_work_hours[]" size="4" value="{{$product->work_hours}}">
				{{number_format($product->work_hours)}} dia(s)
			</td>

			<td class="table-list-right">
				<input type="hidden" name="new_product_cost[]" size="7" value="{{ $product->cost1 + $product->cost2 + $product->cost3}}" >
				{{number_format($product->cost1 + $product->cost2 + $product->cost3, 2,",",".")}}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="new_product_tax_rate[]" size="7" value="{{ $product->price * $product->tax_rate / 100 }}" >
				{{number_format($product->price * $product->tax_rate / 100, 2,",",".")}}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="new_product_margin[]" size="7" value="{{-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price }}" >
				{{number_format(-$product->price * $product->tax_rate / 100 - $product->cost1 - $product->cost2 - $product->cost3 + $product->price, 2,",",".")}}
			</td>

			<td class="table-list-right">
				<input type="hidden" name="new_product_price[]" size="7" value="{{$product->price}}" >
				{{number_format($product->price, 2,",",".")}}
			</td>

			</tr>
			@endforeach
		</table>
		@endif
		<br>
		<br>
		<label class="labels" for="" >DESCONTO:</label>
		<input type="number" min="0" step="any" name="discount" size="20" value="{{$invoice->discount}}"><span class="fields"></span>
		<br>
		<br>
		<label class="labels" for="" >MEIO DE PAGAMENTO: </label>
		{{editSelect('payment_method', 'fields', returnPaymentMethods(),$invoice->payment_method)}}
		<br>
		<label class="labels" for="" >NÚMERO DE PARCELAS: </label>
		<input type="number"  class="fields" style="text-align: right" name="number_installment_total" value="{{$invoice->number_installment_total}}">
		<br>
		<br>
		<label class="labels" for="">SITUAÇÃO:</label>
		{{editSelect('status', 'fields', returnInvoiceStatus(), $invoice->status)}}
		<br>
		<br>
		<input class="button-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">

	</form>
</div>
<br>
<br>
@endsection