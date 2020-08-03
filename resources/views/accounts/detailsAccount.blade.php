@extends('layouts/master')

@section('title','EMPRESA')

@section('image-top')
{{ asset('imagens/novo-email.png') }} 
@endsection

@section('description')

detalhes da empresa

@endsection

@section('main')
<h1 style="text-align:left;color: #874983;padding-left: 30px"><b> Nome: </b> {{ $account->name }} </h1>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Email: </b> {{ $account->email }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Telefone: </b> {{ $account->phone }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Site: </b> {{ $account->site }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Endereço: </b> {{ $account->adrress }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Cidade: </b> {{ $account->adrress_city }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Estado: </b> {{ $account->adrress_state }} </p>]
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  País: </b> {{ $account->adrress_country }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Tipo: </b> {{ $account->type }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Qtde empregados: </b> {{ $account->employees }} </p>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b>  Usuários: </b><br></p>


<br>
<p style="text-align:left;color: #874983;padding-left: 30px"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($user->created_at)) }} </p>

<div style="text-align:center;color: #874983;padding: 10px;margin-left: 15px; display: inline-block">
	<button class="button"><a href=""  style="text-decoration: none;color: black"><i class='fa fa-edit'></i>Editar informações</a></button>
</div>
<div style="text-align:center;color: #874983;padding: 10px; display: inline-block">
	<form action="" method="post">
		@csrf
		@method('delete')
		<input class="button-delete" type="submit" value="APAGAR">
	</form>
</div>
<br>
<p style="text-align: left;margin-left: 30px;color: #874983;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
@endsection