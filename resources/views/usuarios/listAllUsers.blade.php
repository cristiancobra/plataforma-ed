@extends('layouts/master')

@section('title','EQUIPE')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
Aumente sua EQUIPE
<a href="/usuarios/novo"><br><br>
<button type="button" class="button-header">ADICIONAR COLABORADOR</button> </a>

@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">Sua equipe possui atualmente <span class="labels">{{$totalUsers }} colaboradores</span></p>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Colaborador </b></td>
		<td   class="table-list-header"> <b>Empresa </b></td>
		<td   class="table-list-header"> <b> Email</b></td>
	</tr>

	@foreach ($users as $user)

	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button">
				<a href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank" style="text-decoration: none;color: black">
					<i class='fas fa-comment-dots'></i> </a>
			</button>
			<button class="button">
				<a href=" {{ route('user.show', ['user' => $user->id]) }} "  style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $user->name }}
		</td>

		<td class="table-list-left">
			@foreach ($user->accounts as $account)
			<button class="button">
				<a href=" {{ route('accounts.show', ['account' => $account->id]) }} "  style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i></a>
			</button> {{ $account->name }}</li><br>
			@endforeach
		</td>
		
		<td class="table-list-left"><button class="button">
				<a href=" mailto:{{ $user->email }} " target="_blank" style="text-decoration: none;color: black">
					<i class='fa fa-envelope'></i> </a>
			</button> {{ $user->email  }}
		</td>
	</tr>
	@endforeach

</table>

@endsection