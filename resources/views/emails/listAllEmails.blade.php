@extends('layouts/master')

@section('title','Emails Extras')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Precisa de um novo email?
<a href="/emails/novo"><br><br>
	<button type="button" class="button-header">SOLICITAR EMAIL</button> </a>

@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">Você possui <span class="labels">{{$totalEmails }} contas de email</span></p>
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
			
			@if ($user->perfil == "administrador")
			<button class="button">
				<a href=" {{ route('emails.show', ['email' => $email->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-cogs'></i></a>
			</button>
			@endif
			{{ $email->email}}
		</td>
		
		
		<td class="table-list-left"> <b>{{ $user->name }} </b></td>
		<td class="table-list-center"><b> 1GB </b></td>
		<td class="table-list-center"><b>{{ $email->email_password }} </b></td>
		@if ($email->status == "desativado")
		<td class="button-delete"><b>{{ $email->status  }}</b></td>
		@else
		<td class="button-active"><b>{{ $email->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
@endsection
