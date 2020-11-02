@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('invoice.create')}}">NOVA FATURA</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalInvoices }} faturas </span>
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

		@foreach ($invoices as $invoice)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('invoice.show', ['invoice' => $invoice->id]) }}">
						<i class='fa fa-eye' style="color:white"></i>
					</a>
				</button>
				<button class="button">
					<a href=" {{ route('invoice.edit', ['invoice' => $invoice->id]) }}">
						<i class='fa fa-edit' style="color:white"></i>
					</a>
				</button>
				{{ $invoice->id }}
			</td>

			<td class="table-list-center">
				{{ $invoice->contact->name}}
			</td>

			<td class="table-list-center">
				{{ $invoice->account->name}}
			</td>

			<td class="table-list-center">
				{{ $invoice->pay_day }}
			</td>

			<td class="table-list-center">
				{{ $invoice->price }}
			</td>

			<td class="table-list-center">
				{{ $invoice->status }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $invoices->links() }}
	</p>
	<br>
	@endsection