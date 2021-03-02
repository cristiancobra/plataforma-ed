@extends('layouts/master')

@section('title','CONTAS BANCÁRIAS')

@section('image-top')
{{ asset('imagens/bankAccount.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('bankAccount.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<form action="{{route('bankAccount.update', ['bankAccount' =>$bankAccount])}}" method="post" style="color: #874983">
		@csrf
		@method('put')
		<label for="" >DONO: </label>
		<select name="account_id">
			<option  class="fields" value="{{$bankAccount->account_id}}">
				{{$bankAccount->account->name}}
			</option>
			@foreach ($accounts as $account)
			<option  class="fields" value="{{$account->id}}">
				{{$account->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label for="" >Nome / apelido: </label>
		<input type="text" name="name" value="{{$bankAccount->name}}">
		@if ($errors->has('name'))
		<span class="text-danger">{{$errors->first('name')}}</span>
		@endif
		<br>
		<br>
		<label for="" >Banco: </label>
		<select name="bank_id">
			<option  class="fields" value="{{$bankAccount->account_id}}">
				{{$bankAccount->bank->name}}
			</option>
			@foreach ($banks as $bank)
			<option  class="fields" value="{{$bank->id}}">
				{{$bank->name}}
			</option>
			@endforeach
		</select>
		<br>
		<label for="" >Data de abertura: </label>
		<input type="date" name="date_creation" value="{{$bankAccount->date_creation}}">
		<br>
		<label for="" >Data de fechamento: </label>
		<input type="date" name="date_closing" value="{{$bankAccount->date_closing}}">
		<br>
		<br>
		<br>
		<label for="" >Tipo de conta: </label>
		<input type="text" name="type" value="{{$bankAccount->type}}">
		<br>
		<label for="" >Número da agencia:: </label>
		<input type="text" name="agency" value="{{$bankAccount->agency}}">
		<br>
		<label for="" >Número da conta:: </label>
		<input type="text" name="account_number" value="{{$bankAccount->account_number}}">
		<br>
		<label for="" >Saldo inicial: </label>
		<input type="decimal" name="opening_balance" value="{{$bankAccount->opening_balance}}">
		<br>
		<br>
		<label for="" >Observações: </label>
		<textarea id="observations" name="observations" rows="10" cols="90" value="{{$bankAccount->opening_balance}}">
{{$bankAccount->observations}}
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('observations');
		</script>
		<br>
		<label for="">Stituação: </label>
		{{editSelect('status', 'fields', returnBankAccountStatus(), $bankAccount->status)}}
		<br>
		<br>
		<input class="btn btn-secondary" style="display:inline-block" type="submit" value="ATUALIZAR">
    </form>
</div>
<br>
<br>
@endsection
