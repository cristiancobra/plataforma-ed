@extends('layouts/master')

@section('title','FUNCIONÁRIOS')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalUsers}} </span>
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('user.index')}}">
	VOLTAR
</a>
<a class="button-primary"  href="{{route('user.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<table class="table-list">
	<tr>
		<td   class="table-list-header">
			<b>Colaborador </b>
		</td>
		<td   class="table-list-header"> 
			<b>Empresa </b>
		</td>
		<td   class="table-list-header">
			<b> Email</b>
		</td>
	</tr>

	@foreach ($users as $user)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<a  class="white" href="https://nuvem.empresadigital.net.br/index.php/apps/spreed/" target="_blank">
				<button class="button-round">
					<i class='fas fa-comment-dots'></i>
				</button>
			</a>

			<a  class="white" href=" {{ route('user.show', ['user' => $user->id]) }}">
				<button class="button-round">
					<i class='fa fa-eye'></i>
				</button>
			</a>
			@auth
			<a  class="white" href=" {{ route('tutorial_plataforma', ['user' => $user]) }}">
							<button class="button-round" style="background-color: green">
					<i class='fa fa-plus'></i>
				</button>
			</a>
			@endauth
			
			{{ $user->name }}
		</td>

		<td class="table-list-left">
			@foreach ($user->accounts as $account)
			<a class="white"  href=" {{ route('account.show', ['account' => $account->id]) }}">
				<button class="button-round">
					<i class='fa fa-eye'></i>
				</button> 
			</a>
			{{ $account->name }}</li>
			<br>
			</a>
			@endforeach
		</td>

		<td class="table-list-left">
			<a  class="white"  href=" mailto:{{ $user->email }} " target="_blank">
				<button class="button-round">
					<i class='fa fa-envelope'></i>
				</button> {{ $user->email  }}
			</a>
		</td>
	</tr>
	@endforeach
</table>
<br>
<p style="text-align: right">
	<br>
	{{ $users->links() }}
</p>
<br>
@endsection