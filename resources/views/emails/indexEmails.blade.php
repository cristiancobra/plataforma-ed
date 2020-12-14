@extends('layouts/master')

@section('title','Emails Extras')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('email.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<p style="text-align: center;width: 100%">
		Configure seu email no celular ou gerenciador de email:
		<br>
		<b>Servidor de entrada: </b>acadia.mxroute.com  --  IMAP Port: 993
		<br>
		<b>Servidor de saída: </b>acadia.mxroute.com   --   SMTP Port: 465
	</p>
</div>

<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalEmails }} contas </span> com <span class="labels">{{$totalGBs }}GBs </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>Conta</b>
			</td>
			<td   class="table-list-header">
				<b>Dono </b>
			</td>
			<td   class="table-list-header">
				<b>Espaço </b>
			</td>
			<td   class="table-list-header">
				<b>Senha</b>
			</td>
			<td   class="table-list-header">
				<b>Status</b>
			</td>
		</tr>

		@foreach ($emails as $email)
		<tr style="font-size: 16px">
			<td class="table-list-left">
					<a class="button-round" href=" https://empresadigital.net.br/webmail" target="_blank">
						<i class='fa fa-envelope'></i>
					</a>

				@if ($userAuth->perfil == "administrador")
					<a class="button-round" href=" {{ route('email.show', ['email' => $email->id]) }}">
						<i class='fa fa-eye'></i>
					</a>
				@endif
				{{ $email->email}}
			</td>
			<td class="table-list-left">
			</td>
			<td class="table-list-center">
				<b>{{ $email->storage}}</b>
			</td>
			<td class="table-list-center">
				<b>{{ $email->email_password }} </b>
			</td>
			@if ($email->status == "desativado")
			<td class="button-disable">
				<b>{{ $email->status  }}</b>
			</td>
			@elseif ($email->status == "ativo")
			<td class="button-active">
				<b>{{ $email->status  }}</b>
			</td>
			@else ($email->status == "pendente")
			<td class="button-delete">
				<b>{{ $email->status  }}</b>
			</td>
			@endif
		</tr>
		@endforeach
	</table>
</div>
<br>
@endsection
