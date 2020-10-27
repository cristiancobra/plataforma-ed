@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/bill.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('bill.create')}}">NOVA FATURA</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalBills }} faturas </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>ID</b>
			</td>
			<td   class="table-list-header">
				<b>CONTRATANTE </b>
			</td>
			<td   class="table-list-header">
				<b>EMPRESA</b>
			</td>
			<td   class="table-list-header">
				<b>VENCIMENTO</b>
			</td>
			<td   class="table-list-header">
				<b>VALOR</b>
			</td>
			<td   class="table-list-header">
				<b>SITUAÇÃO</b>
			</td>
		</tr>

		@foreach ($bills as $bill)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('bill.show', ['bill' => $bill->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('bill.edit', ['bill' => $bill->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $bill->id }}
			</td>

			<td class="table-list-center">
				{{ $bill->contact->name}}
			</td>

			<td class="table-list-center">
				{{ $bill->account->name}}
			</td>

			<td class="table-list-center">
				{{ $bill->pay_day }}
			</td>

			<td class="table-list-center">
				{{ $bill->price }}
			</td>

			<td class="table-list-center">
				{{ $bill->status }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $bills->links() }}
	</p>
	<br>
	@endsection