@extends('layouts/listAll')

@section('title','Transações')

@section('content')

<br><br><br><p class="titulo-branco"> Listar movimentações bancárias</p>
<br>

<table style="color:white; text-align: left; padding: 20px">
	<b><tr>
			<td   style="text-align:center"> <b>ID</b></td>
			<td   style="text-align:center"> <b>Empresa </b></td>
			<td   style="text-align:center"> <b>Fatura </b></td>
			<td   style="text-align:center"> <b> Descrição</b></td>
			<td   style="text-align:center"> <b> Data</b></td>			
			<td   style="text-align:center"> <b>Valor</b></td>
		</tr></b>


	@foreach ($transactions as $transaction)

	<tr style="font-size: 14px">
		<td style="padding-left: 10px;padding-right: 10px; font-size: 9px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white">  {{ $transaction->id }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""><b>  {{ $transaction->contact_id }}  </b></td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white"">  {{ $transaction->document_id}}  </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $transaction->description  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $transaction->paid_at  }} </td>
		<td style="padding-left: 10px;padding-right: 10px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: white""> {{ $transaction->amount  }} </td>
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