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
<form action="{{route('invoice.index')}}" method="post" style="text-align: right;color: #874983">
	@csrf
	<input type="text" name="name" placeholder="nome da tarefa" value="">
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
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
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
				{{$invoice->identifier}}
			</td>
			<td class="table-list-center">
				{{$invoice->opportunity->name}}
			</td>
			<td class="table-list-center">
				{{$invoice->opportunity->contact->name}}
			</td>
			<td class="table-list-center">
				{{$invoice->account->name}}
			</td>
			<td class="table-list-center">
				{{date('d/m/Y', strtotime($invoice->pay_day))}}
			</td>
			<td class="table-list-center">
				R$ {{number_format($invoice->installment_value, 2,",",".")}}
			</td>
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