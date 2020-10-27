@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/opportunities.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('opportunitie.index')}}">VER OPORTUNIDADES</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $opportunitie->name }}
</h1>
<label class="labels" for="" >DONO: </label>
<span class="fields">{{$opportunitie->account->name }}</span>
<br>
<label class="labels" for="" >CONTATO: </label>
<span class="fields">{{$opportunitie->contact_id}}</span>
<br>
<label class="labels" for="" >CATEGORIA:</label>
<span class="fields">{{$opportunitie->category }}</span>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
<span class="fields">{{$opportunitie->date_start }}</span>
<br>
<label class="labels" for="" >DATA DE FECHAMENTO:</label>
<span class="fields">{{$opportunitie->date_conclusion }}</span>
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
<span class="fields">{{$opportunitie->pay_day }}</span>
<br>
<br>
<label class="labels" for="" >ETAPA DA VENDA:</label>
<span class="fields">{{$opportunitie->stage }}</span>
<br>
<br>
<label class="labels" for="" >DESCRIÇÃO:</label>
<span class="fields">{{$opportunitie->description }}</span>
<br>
<br>
<label class="labels" for="" >PRODUTOS: </label>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome </b></td>
		<td   class="table-list-header"><b>Quantidade </b></td>
		<td   class="table-list-header"><b>Horas previstas</b></td>
		<td   class="table-list-header"><b>Custos</b></td>
		<td   class="table-list-header"><b>Imposto</b></td>
		<td   class="table-list-header"><b>Preço</b></td>
		<td   class="table-list-header"><b>Margem</b></td>
	</tr>
	
	@while ($opportunitie->$name != null)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			{{ $opportunitie->$name }}
		</td>

		<td class="table-list-center">
			{{ $opportunitie->$amount }}
		</td>

		<td class="table-list-center">
			{{ number_format($opportunitie->$hours)}}
		</td>

		<td class="table-list-right">
			{{ number_format($opportunitie->$cost, 2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($opportunitie->$tax_rate, 2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($opportunitie->$price,2,",",".") }}
		</td>

		<td class="table-list-right">
			{{ number_format($opportunitie->$price - $opportunitie->$tax_rate - $opportunitie->$cost, 2,",",".") }}
		</td>

		@php
		$name++;
		$amount++;
		$hours++;
		$cost++;
		$tax_rate++;
		$price++;
		@endphp
		@endwhile
	</tr>
	<tr>
		<td   class="table-list-header">
			<b></b>
		</td>
		<td   class="table-list-header">
			<b>{{$opportunitie->totalAmount}}</b>
		</td>
		<td   class="table-list-header">
			<b>{{number_format($opportunitie->totalHours) }}</b>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($opportunitie->totalCost, 2,",",".") }}</b>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($opportunitie->totalTax_rate, 2,",",".") }}</b>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($opportunitie->totalPrice, 2,",",".") }}</b>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($opportunitie->totalMargin, 2,",",".") }}</b>
		</td>
	</tr>
</table>
<br>
<p style="text-align: right">
<label class="labels" for="">DESPESAS MENSAIS:</label>
<span class="fields">R$ {{number_format($opportunitie->expenses, 2,",",".") }}</span>
</p>
<p style="text-align: right">
<label class="labels" for="">SALDO:</label>
<span class="fields">R$ {{number_format($opportunitie->totalBalance, 2,",",".") }}</span>
</p>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$opportunitie->status }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($opportunitie->created_at)) }} </p>
<br>
<br>
<label class="labels" for="" >PREÇO:</label>
<span class="fields">{{$opportunitie->price }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($opportunitie->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('opportunitie.destroy', ['opportunitie' => $opportunitie->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('opportunitie.edit', ['opportunitie' => $opportunitie->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('opportunitie.index')}}">VOLTAR</a>
</div>
<br>

@endsection