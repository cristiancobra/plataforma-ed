@extends('layouts/master')

@section('title','Email')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('email.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<div>
	<h1 class="name">
		{{$email->email}}
	</h1>
	<p class="labels">
		DONO:<span class="fields">{{$email->user->contact->name}}</span>
	</p>
	<p class="labels">
		EMPRESA:<span class="fields">{{$email->account->name}}</span>
	</p>
	<br>
	<p class='labels'>
		TÍTULO:<span class='fields'>{{$email->title}}</span>
	</p>
	<br>
	<div class='labels' style='background-color: #d7bde2 ;padding: 1%'>
		MENSAGEM:
		<br>
		<br>
		{!!html_entity_decode($email->message)!!}
	</div>
	<br>
	<br>
	<br>
	<br>
	<p class="labels">
		SENHA PADRÃO:<span class="fields">{{$email->email_password}}</span>
	</p>
	<p class="labels">
		ESPAÇO (GB):<span class="fields"> {{$email->storage}}</span>
	</p>
	<p class="labels">
		SITUAÇAO:<span class="fields">{{$email->status}}</span>
	</p>
	<br>
	<p class="fields">Criado em:  {{date('d/m/Y H:i', strtotime($email->created_at))}}
	</p>

	<div style="text-align:right;padding: 2%">
		<form   style="text-decoration: none;color: black;display: inline-block" action="{{route('email.destroy', ['email' => $email->id])}}" method="post">
			@csrf
			@method('delete')
			<input class="btn btn-danger" type="submit" value="APAGAR">
		</form>
		<a class="button-secondary" href=" {{route('email.edit', ['email' => $email->id])}} "  style="text-decoration: none;color: white;display: inline-block">
			<i class='fa fa-edit'></i>EDITAR
		</a>
		<a class="button-secondary" href="{{route('email.index')}}">
			VOLTAR
		</a>
	</div>
	<br>
	<p style="text-align: left;margin-left: 30px;color: white;font-size: 14px">* se a senha padrão tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
</div>
@endsection