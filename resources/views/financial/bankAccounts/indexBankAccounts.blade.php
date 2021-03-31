@extends('layouts/master')

@section('title','CONTAS BANCÁRIAS')

@section('image-top')
{{ asset('imagens/bankAccount.png') }} 
@endsection

@section('description')
Total: <span class="labels"></span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('bankAccount.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<br>
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 25%">
				NOME
			</td>
			<td   class="table-list-header" style="width: 15%">
				AGÊNCIA
			</td>
			<td   class="table-list-header" style="width: 15%">
				CONTA
			</td>
			<td   class="table-list-header" style="width: 15%">
				CHAVE PIX
			</td>
			<td   class="table-list-header" style="width: 15%">
				DONO
			</td>
			<td   class="table-list-header" style="width: 15%">
				SITUAÇÃO
			</td>
		</tr>

		@foreach ($bankAccounts as $bankAccount)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<a class="white" href=" {{route('bankAccount.show', ['bankAccount' => $bankAccount->id])}}">
					<button class="button-round">
						<i class='fa fa-eye'></i>
					</button>
				</a>
				<a class="white" href=" {{route('bankAccount.edit', ['bankAccount' => $bankAccount->id])}}">
					<button class="button-round">
						<i class='fa fa-edit'></i>
					</button>
				</a>
				{{$bankAccount->name}}
			</td>
			<td class="table-list-center">
				{{$bankAccount->agency}}
			</td>
			<td class="table-list-center">
				{{$bankAccount->account_number}}
			</td>
			<td class="table-list-center">
				{{$bankAccount->pix}}
			</td>
			<td class="table-list-center">
				{{$bankAccount->account->name}}
			</td>
			{{formatBankAccountStatus($bankAccount)}}
		</tr>
		@endforeach
	</table>
	<br>
	@endsection