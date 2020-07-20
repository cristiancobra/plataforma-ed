@extends('layouts/details')

@section('title','Usuário')

@section('content')

<br><br><p class="titulo-branco"> Usuário</p>
<p class="destaque_amarelo"><a style="color: yellow" href="/usuarios">VER TODOS OS USUÁRIOS</a></p>
<br>
<br>

<h1 style="text-align:left;color: white;padding-left: 30px"><b> Nome: </b> {{ $user->name }} </h1>
<p style="text-align:left;color: white;padding-left: 30px"> <b>  Email: </b> {{ $user->email }} </p>
<p style="text-align:left;color: white;padding-left: 30px"> <b>  Domínio: </b> {{ $user->dominiol }} </p>
<p style="text-align:left;color: white;padding-left: 30px"> <b>  ID da Plataforma: </b> {{ $user->id }} </p>
<p style="text-align:left;color: white;padding-left: 30px"> <b>  ID do CRM: </b> {{ $user->idcrm }} </p>
<p style="text-align:left;color: white;padding-left: 30px"> <b>  Senha: </b> {{ $user->default_password }} </p>
<p style="text-align:left;color: white;padding-left: 30px"> <b>  Perfil: </b> {{ $user->perfil }} </p>
<br>
<p style="text-align:left;color: white;padding-left: 30px"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>
<div class="imagem">
	<img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
</div>

@endsection