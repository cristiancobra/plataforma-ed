@extends('layouts/master')

@section('title','Email')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Precisa de um novo email?
<a href="/emails"><br><br>
	<button type="button" class="button">VER TODOS OS EMAILS</button> </a>

@endsection

@section('main')
<br>
<br>
<h1 style="text-align:left;color: #874983;padding-left: 30px"><b> Email: </b> {{ $email->email }}  </h1>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Domínio: </b> {{ $email->dominio }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  ID da Plataforma: </b> {{ $email->id }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Senha: </b> {{ $email->default_password }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Perfil: </b> {{ $email->id }} </p>
<br>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
	<button class="button"><a href=" {{ route('emails.edit', ['email' => $email->id]) }} "  style="text-decoration: none;color: black"><i class='fa fa-edit'></i>Editar informações</a></button>
</div>
<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
	<form action="{{ route('emails.destroy', ['email' => $email->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="button-delete" type="submit" value="APAGAR">
	</form>
</div>
<br>
<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>

@endsection