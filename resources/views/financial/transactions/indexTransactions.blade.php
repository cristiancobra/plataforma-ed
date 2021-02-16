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
	<div  style="display: inline-block">
		<p style="text-align: left">
			<label class="labels" for="">PREVISÃO:</label>
			<br>
			RECEITAS:	+ {{formatCurrencyReal($estimatedRevenueMonthly)}}
			<br>
			DESPESAS: - {{formatCurrencyReal($estimatedExpenseMonthly)}}
			<br>
			SALDO: {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
		</p>
	</div>
	<div>
		<p style="text-align: left">
			<label class="labels" for="">REALIZADO:</label>
			<br>
			RECEITAS:	+ {{formatCurrencyReal($revenueMonthly)}}
			<br>
			DESPESAS: - {{formatCurrencyReal($expenseMonthly)}}
			<br>
			SALDO: {{formatCurrencyReal($revenueMonthly - $expenseMonthly)}}
		</p>
	</div>
	<div>
		<p style="text-align: left">
			<label class="labels" for="">DISPONÍVEL EM CAIXA:</label>
			<br>
			@foreach($bankAccounts as $bankAccount)
			{{$bankAccount->name}}: {{formatCurrencyReal($bankAccount->opening_balance)}}
			<br>
			@endforeach
		</p>
	</div>
</div>
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
</div>
<br>
@endsection