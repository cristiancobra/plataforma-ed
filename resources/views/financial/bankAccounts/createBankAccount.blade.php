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
	<form action=" {{route('bankAccount.store')}} " method="post" style="color: #874983">
		@csrf
		<label for="" >DONO: </label>
		<select name="account_id">
			@foreach ($accounts as $account)
			<option  class="fields" value="{{ $account->id }}">
				{{ $account->name }}
			</option>
			@endforeach
		</select>
		<br>
		<br>
		<br>
		<label for="" >Nome / apelido: </label>
		<input type="text" name="name" value="{{old('name')}}">
		@if ($errors->has('name'))
		<span class="text-danger">{{$errors->first('name')}}</span>
		@endif
		<br>
		<label for="" >Banco: </label>
		{{createDoubleSelect('bank_code', 'fields', returnBanks())}}
		<br>
		<label for="" >Número da agência:</label>
		<input type="text" name="agency" value="{{old('agency')}}">
		<br>
		<label for="" >Número da conta: </label>
		<input type="text" name="account_number" value="{{old('account')}}">
		<br>
		<label for="" >Saldo inicial: </label>
		<input type="decimal" name="opening_balance" value="0">
		<br>
		<br>
		<label for="" >Observações: </label>
		<textarea id="observations" name="observations" rows="10" cols="90" value="{{old('observations')}}">
		</textarea>
		<!------------------------------------------- SCRIPT CKEDITOR---------------------- -->
		<script src="//cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
		<script>
CKEDITOR.replace('observations');
		</script>
		<br>
		<br>
		<label for="">Tipo: </label>
		{{createSelect('type', 'fields', returnBankAccountType())}}
		<br>
		<br>
		<input class="btn btn-secondary" type="submit" value="CRIAR">
	</form>
</div>
<br>
<br>
@endsection