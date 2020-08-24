@extends('layouts/master')

@section('title','PAINEL FINANCEIRO')

@section('image-top')
{{ asset('imagens/colaborador.png') }} 
@endsection

@section('description')
XXXXXX
<a href="https://financeiro.empresadigital.net.br/"><br><br>
	<button type="button" class="button">ABRIR GERENCIADOR</button> </a>

@endsection

@section('main')
<center>
	<div style="width: 100%;padding-top: 2%">
		<div class="numbers">
			<p class="numeros_painel"  style="font-size: 22px">  R$  {{ number_format($totalIncomes,2,",",".") }}</p>
			<p class="subtitulo-branco"> entradas</p>
			<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">vender</a></p>
		</div>

		<div class="numbers">
			<p class="numeros_painel"  style="font-size: 22px">  R$ {{ number_format($totalExpenses,2,",",".") }}</p>
			<p class="subtitulo-branco"> saídas</p>
			<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">vender</a></p>
		</div>


		<div class="numbers">
			<p class="numeros_painel"  style="font-size: 22px">  R$  {{ number_format($total,2,",",".") }} </p>
			<p class="subtitulo-branco"> saldo</p>
			<p style="text-align: center; margin: 0px; padding: 0px"><a href="https://vendas.empresadigital.net.br/?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3DOpportunities%26action%3Dindex%26parentTab%3DComercial" style="color: yellow">vender</a></p>
		</div>
	</div>
</center>

<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>ID </b></td>
		<td   class="table-list-header"><b>Empresa </b></td>
		<td   class="table-list-header"><b>Fatura </b></td>
		<td   class="table-list-header"><b> Descrição</b></td>
		<td   class="table-list-header"><b> Data</b></td>			
		<td   class="table-list-header"><b>Valor</b></td>
	</tr>

	@foreach ($transactions  as $transaction)

	<tr style="font-size: 16px">
		<td class="table-list-left">{{ $transaction->id }} </td>
		<td class="table-list-left">{{ $transaction->contact_id }}  </b></td>
		<td class="table-list-left"> {{ $transaction->document_id}}  </td>
		<td class="table-list-left">{{ $transaction->description  }} </td>
		<td class="table-list-left">{{ $transaction->paid_at  }} </td>
		@if ($transaction->type === 'income')
		<td class="table-list-money-income">+{{ number_format($transaction->amount,2,",",".") }} </td>
		@else
		<td class="table-list-money-expense">-{{ number_format($transaction->amount,2,",",".") }} </td>
		@endif		
		<td class="table-list-left">
			<button class="button">
				<a href=" {{ route('transaction.show', ['transaction' => $transaction->id]) }} "   style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i></a>
			</button><br>	
		</td>
	</tr>
	@endforeach
</table>
@endsection