@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalInvoices}}</span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('invoice.create', ['typeInvoice' => 'receita'])}}">
	CRIAR RECEITA
</a>
<a class="button-primary"  href="{{route('invoice.create', ['typeInvoice' => 'despesa'])}}">
	CRIAR DESPESA
</a>
@endsection

@section('main')
<form action="{{route('invoice.index')}}" method="post" style="text-align: right;color: #874983">
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
	<select class="select" name="contact_id">
		<option  class="select" value="">
			Qualquer cliente
		</option>
		@foreach ($contacts as $contact)
		<option  class="select" value="{{$contact->id}}">
			{{$contact->name}}
		</option>
		@endforeach
		<option  class="fields" value="">
			todas
		</option>
	</select>
	<select class="select"name="user_id">
		<option  class="select" value="">
			Qualquer funcionário
		</option>
		@foreach ($users as $user)
		<option  class="select" value="{{$user->id}}">
			{{$user->name}}
		</option>
		@endforeach
	</select>
	{{createFilterSelect('status', 'select', returnInvoiceStatus())}}
	{{returnType('status', 'select', 'invoice')}}
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
<div>
	<table class="table-list">
		<tr>
			<td>
				<br>
				<p style="text-align: left">
					<label class="labels" for="">PREVISÃO:</label>
				</p>
			</td>
			<td>
				<br>
				<p style="text-align: right">
					<label class="labels" for="">MÊS:</label>
				</p>
			</td>
			<td>
				<br>
				<p style="text-align: right">
					<label class="labels" for="">ANO:</label>
				</p>
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				RECEITAS:
			</td>
			<td class="table-list-right" style="width: 15%">
				+ {{formatCurrencyReal($estimatedRevenueMonthly)}}
			</td>
			<td class="table-list-right" style="width: 15%">
				+ {{formatCurrencyReal($estimatedRevenueYearly)}}
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				DESPESAS:
			</td>
			<td class="table-list-right" style="width: 10%;color:red">
				- {{formatCurrencyReal($estimatedExpenseMonthly)}}
			</td>
			<td class="table-list-right" style="width: 10%;color:red">
				- {{formatCurrencyReal($estimatedExpenseYearly)}}
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				SALDO:
			</td>
			<td class="table-list-right" style="width: 15%">
				{{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
			</td>
			<td class="table-list-right" style="width: 15%">
				{{formatCurrencyReal($estimatedRevenueYearly - $estimatedExpenseYearly)}}
			</td>
		</tr>
	</table>
</div>
<div>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width:10%">
				ID
			</td>
			<td   class="table-list-header" style="width:30%">
				OPORTUNIDADE
			</td>
			<td   class="table-list-header" style="width:15%">
				CONTRATANTE 
			</td>
			<td   class="table-list-header" style="width:15%">
				EMPRESA
			</td>
			<td   class="table-list-header" style="width:10%">
				VENCIMENTO
			</td>
			<td   class="table-list-header" style="width:10%">
				VALOR
			</td>
			<td   class="table-list-header" style="width:10%">
				SITUAÇÃO
			</td>
		</tr>

		@foreach ($invoices as $invoice)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{route('invoice.show', ['invoice' => $invoice])}}">
						<i class='fa fa-eye' style="color:white"></i>
					</a>
				</button>
				<button class="button-round">
					<a href=" {{route('invoice.edit', ['invoice' => $invoice])}}">
						<i class='fa fa-edit' style="color:white"></i>
					</a>
				</button>
				{{$invoice->identifier}}
			</td>
			@if($invoice->type == 'receita')
			<td class="table-list-center">
				{{$invoice->opportunity->name}}
			</td>
			<td class="table-list-center">
				{{$invoice->opportunity->company->name}}
			</td>
			@else
			<td class="table-list-center">
				Compra de produto
			</td>
			<td class="table-list-center">
				sem contato
			</td>
			@endif
			<td class="table-list-center">
				{{$invoice->account->name}}
			</td>
			<td class="table-list-center">
				{{date('d/m/Y', strtotime($invoice->pay_day))}}
			</td>
			@if($invoice->type == 'receita')
			<td class="table-list-right">
				{{formatCurrencyReal($invoice->installment_value)}}
			</td>
			@else
			<td class="table-list-right" style="color: red">
				- {{formatCurrencyReal($invoice->installment_value)}}
			</td>
			@endif
			@if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
			<td class="td-late">
				atrasada
			</td>
			@else
			{{formatInvoiceStatus($invoice)}}
			@endif
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $invoices->links() }}
	</p>
	<br>
	@endsection