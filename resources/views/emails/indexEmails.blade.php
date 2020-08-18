@extends('layouts/master')

@section('title','Emails Extras')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('email.create')}}"">SOLICITAR EMAIL</a>
@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
	Você possui <span class="labels">{{$totalEmails }} contas </span>
	<br>
	com <span class="labels">{{$totalGBs }}GBs </span>
</p>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Conta</b></td>
		<td   class="table-list-header"><b>Dono </b></td>
		<td   class="table-list-header"><b>Espaço </b></td>
		<td   class="table-list-header"><b>Senha</b></td>
		<td   class="table-list-header"><b>Status</b></td>
	</tr>

	@foreach ($emails as $email)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button">
				<a href=" https://empresadigital.net.br/webmail" target="_blank"  style="text-decoration: none;color: black">
					<i class='fa fa-envelope'></i></a>
			</button>

			@if ($userAuth->perfil == "administrador")
			<button class="button">
				<a href=" {{ route('email.show', ['email' => $email->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-cogs'></i></a>
			</button>
			@endif
			{{ $email->email}}
		</td>

		<td class="table-list-left"> <b>{{ $email->users->name }} </b></td>
		<td class="table-list-center"><b>{{ $email->storage}}</b></td>
		<td class="table-list-center"><b>{{ $email->email_password }} </b></td>
		@if ($email->status == "desativado")
		<td class="button-disable"><b>{{ $email->status  }}</b></td>
		@elseif ($email->status == "ativo")
		<td class="button-active"><b>{{ $email->status  }}</b></td>
		@else ($email->status == "pendente")
		<td class="button-delete"><b>{{ $email->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
<br>
@endsection
