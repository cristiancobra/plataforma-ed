@extends('layouts/master')

@section('title','Email')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Precisa de um novo email?
<a href="/emails"><br><br>
	<button type="button" class="button-header">VER TODOS OS EMAILS</button> </a>

@endsection

@section('main')
<br>
<br>
<div style="padding-left: 6%">
<h1 class="name"> {{ $email->email }}  </h1>
<p class="labels">DONO:<span class="fields">  </span></p>
<p class="labels">SENHA PADRÃO:<span class="fields">  {{ $email->email_password }} </span></p>
<p class="labels">ESPAÇO (GB):<span class="fields">  {{ $email->storage }} </span></p>
<p class="labels">SITUAÇAO:<span class="fields">  {{ $email->status }} </span></p>
<br>
<p class="fields">Criado em:  {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

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
</div>
@endsection