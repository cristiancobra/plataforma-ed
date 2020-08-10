@extends('layouts/master')

@section('title','ENTRADAS')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
Aumente sua EQUIPE
<a href="/usuarios/novo"><br><br>
<button type="button" class="button">ADICIONAR USUÁRIO EMAIL</button> </a>

@endsection

@section('main')
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>ID </b></td>
		<td   class="table-list-header"><b>Empresa </b></td>
			<td   class="table-list-header"><b>Fatura </b></td>
			<td   class="table-list-header"><b> Descrição</b></td>
			<td   class="table-list-header"><b> Data</b></td>			
			<td   class="table-list-header"><b>Valor</b></td>
		</tr>


	@foreach ($transactions as $transaction)

	<tr style="font-size: 16px">
		<td class="table-list-left">{{ $transaction->id }} </td>
		<td class="table-list-left">{{ $transaction->contact_id }}  </b></td>
		<td class="table-list-left"> {{ $transaction->document_id}}  </td>
		<td class="table-list-left">{{ $transaction->description  }} </td>
		<td class="table-list-left">{{ $transaction->paid_at  }} </td>
		<td class="table-list-left">{{ $transaction->amount  }} </td>
		<td class="table-list-left">
			<button class="button">
			<a href=" {{ route('transaction.show', ['transaction' => $transaction->id]) }} "   style="text-decoration: none;color: black">
			<i class='fa fa-eye'></i></a>
			</button><br>	
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