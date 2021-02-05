@extends('layouts/master')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{asset('imagens/transaction.png')}} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('transaction.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action=" {{ route('transaction.update', ['transaction' =>$transaction->id]) }} " method="post" style="color: #874983">
		@csrf
		@method('put')
		<label class="labels" for="" >EMPRESA: </label>
		<select name="account_id">
			<option  class="fields" value="{{ $transaction->account->id }}">
				{{ $transaction->account->name }}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<label class="labels" for="" >REGISTRADO POR:</label>
		<select name="user_id">
			<option  class="fields" value="{{$transaction->user_id}}">
				{{$transaction->user->contact->name}}
			</option>
			@foreach ($users as $user)
			<option  class="fields" value="{{$user->id}}">
				{{$user->name}}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<label for="" >CONTA: </label>
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
			<option  class="fields" value="{{$transaction->type}}">
				{{$transaction->type}}
			</option>
			<option  class="fields" value="crédito">
				crédito
			</option>
			<option  class="fields" value="débito">
				débito
			</option>
		</select>
		<br>
		<label class="labels" for="" >DATA:</label>
		<input type="date" name="pay_day" size="20" value="{{$transaction->pay_day}}"><span class="fields"></span>
		<br>
		<label for="" >VALOR: </label>
		<input type="decimal" name="value" value="{{$transaction->value}}">
		@if ($errors->has('value'))
		<span class="text-danger">{{ $errors->first('value') }}</span>
		@endif
		<br>
		<br>
		<label class="labels" for="" >OBSERVAÇÕES:</label>
		<br>
		<textarea id="description" name="observations" rows="5" cols="90"  value="{{old('observations')}}">
		{{$transaction->observations}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('description');
		</script>
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="ATUALIZAR">
	</form>
</div>
<br>
<br>
@endsection