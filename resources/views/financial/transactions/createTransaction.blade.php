@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('imagens/transaction.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('transaction.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>

@if(Session::has('failed'))
<div class="alert alert-danger">
	{{ Session::get('failed') }}
	@php
	Session::forget('failed');
	@endphp
</div>
@endif
<div>
	<form action=" {{route('transaction.store')}} " method="post" style="color: #874983">
		@csrf
		<label for="" >EMPRESA: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label for="" >REGISTRADO POR:</label>
		<select name="user_id">
			<option  class="fields" value="{{Auth::user()->id}}">
				{{Auth::user()->contact->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->id}}">
				{{$user->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label for="" >CONTA:</label>
		<select name="bank_account_id">
			@foreach ($bankAccounts as $bankAccount)
			<option  class="fields" value="{{$bankAccount->id}}">
				{{$bankAccount->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label for="" >FATURA: </label>
		<select name="invoice_id">
			<option  class="fields" value="{{$transaction->invoice_id}}">
				{{$transaction->invoice_id}}
			</option>
			@foreach ($invoices as $invoice)
			<option  class="fields" value="{{$invoice->id}}">
				{{$invoice->id}}
			</option>
			@endforeach
		</select>
		<br>
		<label for="" >TIPO: </label>
		<select name="type">
			<option  class="fields" value="crédito">
				crédito
			</option>
			<option  class="fields" value="débito">
				débito
			</option>
		</select>
		<br>
		<br>
		<label class="labels" for="" >DATA:</label>
		<input type="date" name="pay_day" value="{{date('d-m-y')}}">
		@if ($errors->has('pay_day'))
		<span class="text-danger">{{ $errors->first('pay_day') }}</span>
		@endif
		<br>
		<label for="" >VALOR: </label>
		<input type="decimal" name="value" value="">
		@if ($errors->has('value'))
		<span class="text-danger">{{ $errors->first('value') }}</span>
		@endif
		<br>
		<br>
		<label for="" >Observações: </label>
		<textarea id="observations" name="observations" rows="5" cols="90" value="{{old('observations')}}">
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('observations');
		</script>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>
<br>
<br>
@endsection