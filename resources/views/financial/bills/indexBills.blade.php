@extends('layouts/master')

@section('title','DESPESAS')

@section('image-top')
{{ asset('imagens/bill.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalBills}}</span>
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('bill.create')}}">
	<i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<form action="{{route('bill.index')}}" method="post" style="text-align: right;color: #874983">
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
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<br>
<div>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width:15%">
				ID
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

		@foreach ($bills as $bill)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{route('bill.show', ['bill' => $bill])}}">
						<i class='fa fa-eye' style="color:white"></i>
					</a>
				</button>
				<button class="button-round">
					<a href=" {{route('bill.edit', ['bill' => $bill])}}">
						<i class='fa fa-edit' style="color:white"></i>
					</a>
				</button>
				{{$bill->identifier}}
			</td>
			<td class="table-list-center">
				{{$bill->contact->name}}
			</td>
			<td class="table-list-center">
				{{$bill->account->name}}
			</td>
			<td class="table-list-center">
				{{date('d/m/Y', strtotime($bill->pay_day))}}
			</td>
			<td class="table-list-center">
				R$ {{number_format($bill->installment_value, 2,",",".")}}
			</td>
			@if($bill->status == 'aprovada' AND $bill->pay_day < date('Y-m-d'))
			<td class="td-late">
				atrasada
			</td>
			@else
			{{formatInvoiceStatus($bill)}}
			@endif
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{$bills->links()}}
	</p>
	<br>
	@endsection