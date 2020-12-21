@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('opportunitie.index')}}">
	VOLTAR
</a>
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
<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
@if($opportunitie->date_start == null)
indefinida
@else
<span class="fields">{{ date('d/m/Y', strtotime($opportunitie->date_start)) }}</span>
@endif
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
@if($opportunitie->pay_day == null)
indefinida
@else
<span class="fields">{{ date('d/m/Y', strtotime($opportunitie->pay_day)) }}</span>
@endif
<br>
<br>
<div style="background-color: #d7bde2 ;padding: 1%">
	<label class="labels" for="" >ETAPA DA VENDA:</label>
	<span class="fields">{{$opportunitie->stage }}</span>
	<br>
	<label class="labels" for="" >PRÓXIMO CONTATO:</label>
	@if($opportunitie->date_conclusion == null)
	indefinido
	@else
	<span class="fields">{{ date('d/m/Y', strtotime($opportunitie->date_conclusion)) }}</span>
	@endif
</div>
<br>
<br>
<label class="labels" for="" >DESCRIÇÃO:</label>
<span class="fields">    {!!html_entity_decode($opportunitie->description)!!}</span>
<br>
<br>
<label class="labels" for="" >PROSPECÇÃO:</label>
<br>
<br>
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
		<td   class="table-list-header" style="width: 10%">
			<b>SITUAÇÃO</b>
		</td>
	</tr>

	@foreach ($invoices as $invoice)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			<button class="button-round">
				<a href=" {{ route('invoice.show', ['invoice' => $invoice->id]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{ route('invoice.edit', ['invoice' => $invoice->id]) }}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			{{ $invoice->id }}
		</td>

		<td class="table-list-center">
			{{ date('d/m/Y', strtotime($invoice->date_creation)) }}
		</td>

		<td class="table-list-center">
			{{ date('d/m/Y', strtotime($invoice->pay_day)) }}
		</td>

		<td class="table-list-right">
			R$ {{number_format($invoice->totalPrice, 2,",",".") }}
		</td>

		<td class="table-list-center">
			@if ($invoice->status == "cancelada")
			<button class="btn btn-dark">
				<b>{{ $invoice->status  }}</b>
			</button>
			@elseif ($invoice->status == "pendente")
			<button class="btn btn-warning">
				<b>{{ $invoice->status  }}</b>
			</button>
			@elseif ($invoice->status == "fazendo agora")
			<button class="btn btn-info">
				<b>{{ $invoice->status  }}</b>
			</button>
			@elseif ($invoice->status == "concluida")
			<button class="btn btn-success">
				<b>{{ $invoice->status  }}</b>
			</button>
			@endif
		</td>
	</tr>
	@endforeach
</table>
<br>
<br>
<a class="btn btn-secondary" href="{{ route('task.create', [
				'taskName' =>"Prospecção",
				'opportunitieId' => $opportunitie->id,
				'opportunitieName' => $opportunitie->name,
//				'taskDescription' => $task->description,
//				'taskUserName' => $task->user->name,
//				'taskUserId' => $task->user->id,
				'taskAccountName' => $opportunitie->account->name,
				'taskAccountId' => $opportunitie->account->id,
				])}}">
	NOVA TAREFA
</a>
<br>
<br>
<br>
<label class="labels" for="" >FATURAS:</label>
<br>
<br>
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
		<td   class="table-list-header" style="width: 10%">
			<b>SITUAÇÃO</b>
		</td>
	</tr>

	@foreach ($invoices as $invoice)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			<button class="button-round">
				<a href=" {{ route('invoice.show', ['invoice' => $invoice->id]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{ route('invoice.edit', ['invoice' => $invoice->id]) }}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			{{ $invoice->id }}
		</td>

		<td class="table-list-center">
			{{ date('d/m/Y', strtotime($invoice->date_creation)) }}
		</td>

		<td class="table-list-center">
			{{ date('d/m/Y', strtotime($invoice->pay_day)) }}
		</td>

		<td class="table-list-right">
			R$ {{number_format($invoice->totalPrice, 2,",",".") }}
		</td>

		<td class="table-list-center">
			@if ($invoice->status == "cancelada")
			<button class="btn btn-dark">
				<b>{{ $invoice->status  }}</b>
			</button>
			@elseif ($invoice->status == "pendente")
			<button class="btn btn-warning">
				<b>{{ $invoice->status  }}</b>
			</button>
			@elseif ($invoice->status == "fazendo agora")
			<button class="btn btn-info">
				<b>{{ $invoice->status  }}</b>
			</button>
			@elseif ($invoice->status == "concluida")
			<button class="btn btn-success">
				<b>{{ $invoice->status  }}</b>
			</button>
			@endif
		</td>
	</tr>
	@endforeach
</table>
<br>
<a class="btn btn-secondary" href="{{ route('invoice.create', [
				'opportunitieName' => $opportunitie->name,
				'opportunitieId' => $opportunitie->id,
				'opportunitieDescription' => $opportunitie->description,
//				'opportunitieUserName' => $opportunitie->user->name,
//				'opportunitieUserId' => $opportunitie->user->id,
				'opportunitieAccountName' => $opportunitie->account->name,
				'opportunitieAccountId' => $opportunitie->account->id,
				])}}">
	NOVA FATURA
</a>
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