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
			<td   class="table-list-header">
				<b>ID</b>
			</td>
			<td   class="table-list-header">
				<b>OPORTUNIDADE</b>
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
			<td class="table-list-center">
				@if ($invoice->status == "cancelada")
				<button class="btn btn-dark">
					<b>{{ $invoice->status  }}</b>
				</button>
				@elseif ($invoice->status == "pendente")
				<button class="btn btn-warning">
					<b>{{ $invoice->status  }}</b>
				</button>
				@elseif ($invoice->status == "aprovada")
				<button class="btn btn-info">
					<b>{{ $invoice->status  }}</b>
				</button>
				@elseif ($invoice->status == "concluida")
				<button class="btn btn-success">
					<b>{{ $invoice->status  }}</b>
				</button>
				@endif
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