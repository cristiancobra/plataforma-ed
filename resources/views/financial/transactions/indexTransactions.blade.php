@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('imagens/transaction.png') }} 
@endsection

@section('description')
Total: <span class="labels"></span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('transaction.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<table class="table-list">
		<tr>
			<td>
				<br>
				<p style="text-align: left">
					<label class="labels" for="">PREVISÃO:</label>
				</p>
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				RECEITAS:
			</td>
			<td class="table-list-right" style="width: 30%">
				+ {{formatCurrencyReal($estimatedRevenueMonthly)}}
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				DESPESAS:
			</td>
			<td class="table-list-right" style="width: 30%;color:red">
				- {{formatCurrencyReal($estimatedExpenseMonthly)}}
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				SALDO:
			</td>
			<td class="table-list-right" style="width: 30%">
				{{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
			</td>
		</tr>
		<tr>
			<td>
				<br>
				<p style="text-align: left">
					<label class="labels" for="">REALIZADO:</label>
				</p>
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				RECEITAS:
			</td>
			<td class="table-list-right" style="width: 30%">
				+ {{formatCurrencyReal($revenueMonthly)}}
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				DESPESAS:
			</td>
			<td class="table-list-right" style="width: 30%;color:red">
				- {{formatCurrencyReal($expenseMonthly)}}
			</td>
		</tr>
		<tr>
			<td class="table-list-left" style="width: 70%">
				SALDO:
			</td>
			<td class="table-list-right" style="width: 30%">
				{{formatCurrencyReal($revenueMonthly - $expenseMonthly)}}
			</td>
		</tr>
	</table>
	<br>
	<table class="table-list">
		<tr>
			<td>
				<br>
				<p style="text-align: left">
					DISPONÍVEL EM CAIXA:
				</p>
			</td>
		</tr>
		@foreach($bankAccounts as $bankAccount)
		<tr>
			<td class="table-list-left" style="width: 70%">
				{{$bankAccount->name}}
			</td>
			<td class="table-list-right" style="width: 30%">
				{{formatCurrencyReal($estimatedRevenueMonthly)}}
			</td>
		</tr>
		@endforeach
	</table>
	<br>
	<br>
	<div>
		<table class="table-list">
			<tr>
				<td   class="table-list-header" style="width: 20%">
					DATA
				</td>
				<td   class="table-list-header" style="width: 20%">
					CONTA
				</td>
				<td   class="table-list-header" style="width: 20%">
					EMPRESA
				</td>
				<td   class="table-list-header" style="width: 20%">
					FATURA
				</td>
				<td   class="table-list-header" style="width: 20%">
					VALOR
				</td>
			</tr>

			@foreach ($transactions as $transaction)
			<tr style="font-size: 14px">
				<td class="table-list-left">
					<a class="white" href=" {{route('transaction.show', ['transaction' => $transaction->id])}}">
						<button class="button-round">
							<i class='fa fa-eye'></i>
						</button>
					</a>
					<a class="white" href=" {{route('transaction.edit', ['transaction' => $transaction->id])}}">
						<button class="button-round">
							<i class='fa fa-edit'></i>
						</button>
					</a>
					{{$transaction->pay_day}}
				</td>
				<td class="table-list-center">
					{{$transaction->bankAccount->name}}
				</td>
				<td class="table-list-center">
					{{$transaction->account->name}}
				</td>
				<td class="table-list-center">
					<a class="white" href=" {{route('invoice.show', ['invoice' => $transaction->invoice_id])}}">
						<button class="button-round">
							<i class='fa fa-eye'></i>
						</button>
					</a>
					{{$transaction->invoice_id}}
				</td>
				@if($transaction->type == "débito")
				<td class="table-list-right" style="color:red">
					@else
				<td class="table-list-right">
					@endif
					{{formatCurrencyReal($transaction->value)}}
				</td>
			</tr>
			@endforeach
		</table>
		<br>
		@endsection