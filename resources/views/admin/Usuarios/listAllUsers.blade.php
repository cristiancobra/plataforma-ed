@extends('layouts/listAll')

@section('title','Usuários da Plataforma')

@section('content')

<br><br><br><p class="titulo-branco"> Listar usuários</p>
<p class="destaque_amarelo"><a style="color: yellow" href="/usuarios/novo">NOVO USUÁRIO</a></p>
<p style="text-align: center;color: white;font-size: 14px">* se a <b>senha padrão</b> tiver sido alterada pelo usuário, atualize a senha novamente com a <b>senha padrão</b>. Peça para o usuário alterar sua senha no seu primeiro acesso.</p>
<br><br>
<table style="color:white; text-align: left; padding: 20px">
	<tr>
			<td   style="text-align:center"> <b>ID</b></td>
			<td   style="text-align:center"> <b>Nome </b></td>
			<td   style="text-align:center"> <b>Domínio</b></td>
			<td   style="text-align:center"> <b>Perfil</b></td>
			<td   style="text-align:center"> <b> Email</b></td>
			<td   style="text-align:center"> <b>Senha padrão*</b></td>
		</tr>
	
	@foreach ($users as $user)

	<tr style="font-size: 14px">
		<td style="padding-left: 10px;padding-right: 10px">  {{ $user->ID }} </td>
		<td style="padding-left: 10px;padding-right: 10px">  {{ $user->name }}  </td>
		<td style="padding-left: 10px;padding-right: 10px">  {{ $user->dominio }}  </td>
		<td style="padding-left: 10px;padding-right: 10px">  {{ $user->perfil }}  </td>
		<td style="padding-left: 10px;padding-right: 10px"> {{ $user->email  }} </td>
		<td style="padding-left: 10px;padding-right: 10px"> {{ $user->default_password  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; text-align: center"> 
			<a href=" {{ route('user.show', ['user' => $user->id]) }} "  style="color:yellow; text-align: center">Ver usuário</a></td>
		<td style="padding-left: 10px;padding-right: 10px; text-align: center"> 	
			<a href=" {{ route('user.edit', ['user' => $user->id]) }} "  style="color:yellow; text-align: center">Editar</a></td>
		<td>		
	<form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
				@csrf
				@method('delete')
				<input type="submit" value="Remover">
			</form>
		</td>
	</tr>


	@endforeach

</table>


<div class="imagem">
	<img src=" {{ asset('imagens/astronauta-estrela.png') }} " width="300px" height="300px">
</div>

@endsection