@extends('layouts/listAll')

@section('title','Usuários da Plataforma')

@section('content')

<br><br><br><p class="titulo-branco"> Listar usuários</p>
<br>

<table style="color:white; text-align: left; padding: 40px">
	<b><tr>
			<td   style="text-align:center"> <b>ID</b></td>
			<td   style="text-align:center"> <b>Nome </b></td>
			<td   style="text-align:center"> <b> Email</b></td>
			<td   style="text-align:center"> <b>Senha</b></td>
		</tr></b>


	@foreach ($users as $user)

	<tr>
		<td style="padding-left: 20px;padding-right: 20px">  {{ $user->ID }} </td>
		<td style="padding-left: 20px;padding-right: 20px">  {{ $user->name }}  </td>
		<td style="padding-left: 20px;padding-right: 20px"> {{ $user->email  }} </td>
		<td style="padding-left: 20px;padding-right: 20px"> {{ $user->password  }} </td>
		<td style="padding-left: 20px;padding-right: 20px"> 
			<a href=" {{ route('user.show', ['user' => $user->id]) }} "  style="color:yellow; text-align: center">Ver usuário</a>
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