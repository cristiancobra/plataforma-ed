@extends('layouts/master')

@section('title','TRANSAÇÕES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('transaction.create')}}">NOVA TRANSAÇÃO</a>

@endsection

@section('main')
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Fatura </b></td>
		<td   class="table-list-header"><b>Fatura </b></td>
		<td   class="table-list-header"><b> Descrição</b></td>
		<td   class="table-list-header"><b> Data</b></td>			
		<td   class="table-list-header"><b>Valor</b></td>
	</tr>

	@foreach ($transactions as $transaction)

	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button">
				<a href="{{ route('transaction.show', ['transaction' => $transaction->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i>
				</a>
			</button>
			{{ $transaction->document_id}} </td>
		<td class="table-list-left">{{ $transaction->contact_id }}  </b></td>
		<td class="table-list-left">{{ $transaction->description  }} </td>
		<td class="table-list-left">{{ $transaction->paid_at  }} </td>
		<td class="table-list-left">{{ $transaction->amount  }} </td>
	</tr>
	@endforeach
</table>

@endsection