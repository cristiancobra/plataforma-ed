@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
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
<span class="fields">{{$opportunitie->contact->name}}</span>
<br>
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
<span class="fields">    {!!html_entity_decode($opportunitie->description)!!}</span>
<br>
<br>
<label class="labels" for="" >FATURAS:</label>

@if ($invoices->count() == 0)
<br>
<a class="btn btn-secondary" href="{{ route('invoice.create') }}">
	NOVA FATURA
</a>
<br>
@else
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 5%">
			<b>ID</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>DATA CRIAÇÃO </b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>DATA PAGAMENTO</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>VALOR TOTAL</b>
		</td>
	</tr>

	@foreach ($invoices as $invoice)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			{{ $invoice->id }}
		</td>

		<td class="table-list-left">
			{{ $invoice->date_creation}}
		</td>

		<td class="table-list-right">
			{{ $invoice->pay_day}}
		</td>

		<td class="table-list-right">
			{{ $invoice->totalBalance}}
		</td>
	</tr>
	@endforeach
</table>
@endif
<br>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$opportunitie->status }}</span>
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