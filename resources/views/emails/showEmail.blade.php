@extends('layouts/master')

@section('title','Email')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('email.index')}}">VER EMAILS</a>
@endsection

@section('main')
<br>
<br>
<div style="padding-left: 6%">
	<h1 class="name"> {{ $email->email }}  </h1>
	<p class="labels">DONO:<span class="fields">{{ $email->users->name }} </span></p>
	<p class="labels">SENHA PADRÃO:<span class="fields">  {{ $email->email_password }} </span></p>
	<p class="labels">ESPAÇO (GB):<span class="fields">  {{ $email->storage }} </span></p>
	<p class="labels">SITUAÇAO:<span class="fields">  {{ $email->status }} </span></p>
	<br>
	<p class="fields">Criado em:  {{ date('d/m/Y H:i', strtotime($email->created_at)) }} </p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{ route('email.destroy', ['email' => $email->id]) }}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="btn btn-secondary" href=" {{ route('email.edit', ['email' => $email->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
			<i class='fa fa-edit'></i>EDITAR</a>
		<a class="btn btn-secondary" href="{{route('email.index')}}">VOLTAR</a>
	</div>
	<br>
	<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>
@endsection