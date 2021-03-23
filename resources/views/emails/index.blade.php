@extends('layouts/master')

@section('title','EMAILS')

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
		Servidor de entrada: acadia.mxroute.com  --  IMAP Port: 993
		<br>
		Servidor de saída: acadia.mxroute.com   --   SMTP Port: 465
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
				TÍTULO
			</td>
			<td   class="table-list-header">
				ESCRITO POR 
			</td>
			<td   class="table-list-header">
				Espaço 
			</td>
			<td   class="table-list-header">
				Senha
			</td>
			<td   class="table-list-header">
				Status
			</td>
		</tr>

		@foreach ($emails as $email)
		<tr style="font-size: 16px">
			<td class="table-list-left">
					<a class="button-round" href=" https://empresadigital.net.br/webmail" target="_blank">
						<i class='fa fa-envelope'></i>
					</a>
					<a class="button-round" href=" {{route('email.show', ['email' => $email])}}">
						<i class='fa fa-eye'></i>
					</a>
				{{$email->title}}
			</td>
			<td class="table-list-center">
				{{$email->user->contact->name}}
			</td>
			<td class="table-list-center">
				{{$email->storage}}
			</td>
			<td class="table-list-center">
				{{$email->email_password}} 
			</td>
			@if ($email->status == "desativado")
			<td class="button-disable">
				{{$email->status }}
			</td>
			@elseif ($email->status == "ativo")
			<td class="button-active">
				{{$email->status }}
			</td>
			@else ($email->status == "pendente")
			<td class="button-delete">
				{{$email->status }}
			</td>
			@endif
		</tr>
		@endforeach
	</table>
</div>
<br>
@endsection
