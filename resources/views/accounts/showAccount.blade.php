@extends('layouts/master')

@section('title','EMPRESA')

@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('account.index')}}">VER EMPRESAS</a>
@endsection

@section('main')
<br>
<h1 style="text-align:left;color: #874983;padding-left: 30px">
	<b> Nome: </b> {{ $account->name }}
</h1>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Colaboradores: </b>
</p>
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
<br>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Email: </b> {{ $account->email }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Telefone: </b> {{ $account->phone }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Site: </b> {{ $account->site }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Endereço: </b> {{ $account->address }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Cidade: </b> {{ $account->address_city }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Estado: </b> {{ $account->address_state }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  País: </b> {{ $account->address_country }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Tipo: </b> {{ $account->type }}
</p>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b>  Qtde empregados: </b> {{ $account->employees }}
</p>
<br>
<p style="text-align:left;color: #874983;padding-left: 30px">
	<b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($account->created_at)) }}
</p>

<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
	<a href="{{ route('account.edit', ['account' => $account->id]) }}"  style="text-decoration: none;color: black">
		<button class="btn btn-secondary">
			<i class='fa fa-edit'></i>EDITAR
		</button>	
	</a>
</div>
<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
	<form action="" method="post">
		@csrf
		@method('delete')
		<input class="button-delete" type="submit" value="APAGAR">
	</form>
</div>
<br>
@endsection