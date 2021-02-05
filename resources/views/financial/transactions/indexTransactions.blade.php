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
<br>
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 20%">
				<b>DATA</b>
			</td>
			<td   class="table-list-header" style="width: 20%">
				<b>CONTA</b>
			</td>
			<td   class="table-list-header" style="width: 20%">
				<b>EMPRESA</b>
			</td>
			<td   class="table-list-header" style="width: 20%">
				<b>FATURA</b>
			</td>
			<td   class="table-list-header" style="width: 20%">
				<b>VALOR</b>
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
				{{$transaction->invoice_id}}
			</td>
			<td class="table-list-right">
				R$ {{number_format($transaction->value,2,",",".")}}
			</td>
		</tr>
		@endforeach
	</table>
	<br>
	@endsection