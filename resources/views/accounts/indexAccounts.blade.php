@extends('layouts/master')

@section('title','EMPRESAS')

@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('account.create')}}">ADICIONAR EMPRESA</a>
@endsection

@section('main')
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalAccounts }} empresas </span>
	</p>
	<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Empresa </b></td>
		<td   class="table-list-header"><b>Usuários </b></td>
	</tr>

	@foreach ($accounts as $account)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<a  class="white" href=" {{ route('account.show', ['account' => $account->id]) }}">
				<button class="button">
					<i class='fa fa-eye'></i>
				</button>
			</a>
			{{ $account->name }}
		</td>

		<td class="table-list-left">
			@foreach ($account->users as $user)
			<a  class="white" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank">
				<button class="button">
					<i class='fas fa-comment-dots'></i>
				</button>
			</a>

			<a  class="white" href=" {{ route('user.show', ['user' => $user->id]) }}">
				<button class="button">
					<i class='fa fa-eye'></i>
				</button>
			</a>
			{{ $user->name }}
			<br>
			@endforeach	
		</td>
		@endforeach
</table>
	<p style="text-align: right">
		<br>
		{{ $accounts->links() }}
	</p>
	<br>
@endsection
