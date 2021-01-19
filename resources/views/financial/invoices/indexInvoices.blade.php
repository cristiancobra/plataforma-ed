@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('invoice.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width:15%">
				<b>ID</b>
			</td>
			<td   class="table-list-header" style="width:20%">
				<b>OPORTUNIDADE</b>
			</td>
			<td   class="table-list-header" style="width:15%">
				<b>CONTRATANTE </b>
			</td>
			<td   class="table-list-header" style="width:15%">
				<b>EMPRESA</b>
			</td>
			<td   class="table-list-header" style="width:10%">
				<b>VENCIMENTO</b>
			</td>
			<td   class="table-list-header" style="width:10%">
				<b>VALOR</b>
			</td>
			<td   class="table-list-header" style="width:10%">
				<b>SITUAÇÃO</b>
			</td>
		</tr>

		@foreach ($invoices as $invoice)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('invoice.show', ['invoice' => $invoice]) }}">
						<i class='fa fa-eye' style="color:white"></i>
					</a>
				</button>
				<button class="button-round">
					<a href=" {{ route('invoice.edit', ['invoice' => $invoice]) }}">
						<i class='fa fa-edit' style="color:white"></i>
					</a>
				</button>
				{{ $invoice->id }}
			</td>
			<td class="table-list-center">
				{{ $invoice->opportunity->name}}
			</td>
			<td class="table-list-center">
				{{ $invoice->opportunity->contact->name}}
			</td>
			<td class="table-list-center">
				{{ $invoice->account->name}}
			</td>
			<td class="table-list-center">
				{{ date('d/m/Y', strtotime($invoice->pay_day)) }}
			</td>
			<td class="table-list-center">
				R$ {{number_format($invoice->totalPrice, 2,",",".") }}
			</td>
			{{formatInvoiceStatus($invoice)}}
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $invoices->links() }}
	</p>
	<br>
	@endsection