@extends('layouts/listAll')

@section('title','Contatos')

@section('content')

<br><br><br><p class="titulo-branco"> Listar contatos</p>
<br>

<table style="color:white; text-align: left; padding: 20px">
	<b><tr>
			<td   style="text-align:center"> <b>ID</b></td>
			<td   style="text-align:center"> <b>Nome </b></td>
			<td   style="text-align:center"> <b>Sobrenome </b></td>
			<td   style="text-align:center"> <b> Descrição</b></td>
			<td   style="text-align:center"> <b>Cidade</b></td>
		</tr>


	@foreach ($contacts as $contact)

	<tr style="font-size: 14px">
		<td style="padding-left: 10px;padding-right: 10px; font-size: 9px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white">  {{ $contact->id }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""><b>  {{ $contact->first_name }}  </b></td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white"">  {{ $contact->last_name }}  </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $contact->description  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $contact->primary_address_city  }} </td>
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