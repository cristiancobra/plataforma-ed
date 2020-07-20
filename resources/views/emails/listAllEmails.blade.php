@extends('layouts/listAll')

@section('title','Contatos')

@section('content')

<br><br><br><p class="titulo-branco"> Emails</p><br>
<p class="destaque_amarelo">Precisa de um novo email? </p>
<p class="destaque_amarelo"><a href="/emails/novo"> <button type="button">SOLICITAR EMAIL</button> </a></p><br><br>

<table style="color:white; text-align: left; padding: 20px">
	<b><tr>
			<td   style="text-align:center"> <b>ID</b></td>
			<td   style="text-align:center"> <b>Usuário </b></td>
			<td   style="text-align:center"> <b>Empresa </b></td>
			<td   style="text-align:center"> <b> Perfil</b></td>
			<td   style="text-align:center"> <b>Email</b></td>
			<td   style="text-align:center"> <b>Senha</b></td>
			<td   style="text-align:center"> <b>Status</b></td>
		</tr>

	@foreach ($emails as $email)

	<tr style="font-size: 14px">
		<td style="padding-left: 10px;padding-right: 10px; font-size: 9px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white">  {{ $email->id }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""><b>  {{ $users->emails->first() }}  </b></td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white"">  {{ $email->account_id }}  </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $email->perfil_id  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $email->email  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $email->email_password  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $email->status  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> 
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