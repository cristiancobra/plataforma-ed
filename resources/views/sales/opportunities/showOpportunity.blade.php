@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('opportunity.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<br>
<h1 class="name">
	{{ $opportunity->name }}
</h1>
<label class="labels" for="" >EMPRESA: </label>
<span class="fields">{{$opportunity->account->name }}</span>
<br>
<label class="labels" for="" >CONTATO: </label>
<span class="fields">{{$opportunity->contact->name}}</span>
<br>
<br>
<label class="labels" for="" >DATA DE CRIAÇÃO:</label>
@if($opportunity->date_start == null)
indefinida
@else
<span class="fields">{{ date('d/m/Y', strtotime($opportunity->date_start)) }}</span>
@endif
<br>
<label class="labels" for="" >DATA DE PAGAMENTO:</label>
@if($opportunity->pay_day == null)
indefinida
@else
<span class="fields">{{ date('d/m/Y', strtotime($opportunity->pay_day)) }}</span>
@endif
<br>
<br>
<div style="background-color: #d7bde2 ;padding: 1%">
	<label class="labels" for="" >ETAPA DA VENDA:</label>
	<span class="fields">{{$opportunity->stage }}</span>
	<br>
	<label class="labels" for="" >PRÓXIMO CONTATO:</label>
	@if($opportunity->date_conclusion == null)
	indefinido
	@else
	<span class="fields">{{ date('d/m/Y', strtotime($opportunity->date_conclusion)) }}</span>
	@endif
</div>
<br>
<br>
<label class="labels" for="" >DESCRIÇÃO:</label>
<span class="fields">{!!html_entity_decode($opportunity->description)!!}</span>
<br>
<br>
<label class="labels" for="" >PROSPECÇÃO:</label>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 20%">
			<b>DATA CRIAÇÃO </b>
		</td>
		<td   class="table-list-header" style="width: 40%">
			<b>DESCRIÇÃO </b>
		</td>
		<td   class="table-list-header" style="width: 15%">
			<b>DATA CONCLUSÃO</b>
		</td>
		<td   class="table-list-header" style="width: 15%">
			<b>VALOR TOTAL</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>SITUAÇÃO</b>
		</td>
	</tr>

	@foreach ($tasks as $task)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			<button class="button-round">
				<a href=" {{ route('task.show', ['task' => $task->id]) }}">
					<i class='fa fa-eye' style="color:white"></i></a>
			</button>
			<button class="button-round">
				<a href=" {{ route('task.edit', ['task' => $task->id]) }}">
					<i class='fa fa-edit' style="color:white"></i></a>
			</button>
			{{date('d/m/Y', strtotime($task->date_start))}}
		</td>
		<td class="table-list-left">
			{!!html_entity_decode($task->description)!!}
		</td>
		<td class="table-list-center">
			{{date('d/m/Y', strtotime($task->date_conclusion))}}
		</td>
		<td class="table-list-right">
			R$ {{number_format($task->totalPrice, 2,",",".")}}
		</td>
		<td class="table-list-center">
			@if ($task->status == "cancelado")
			<button class="btn btn-dark">
				<b>{{ $task->status  }}</b>
			</button>
			@elseif ($task->status == "fazer")
			<button class="btn btn-warning">
				<b>{{ $task->status  }}</b>
			</button>
			@elseif ($task->status == "fazendo")
			<button class="btn btn-info">
				<b>{{ $task->status  }}</b>
			</button>
			@elseif ($task->status == "aguardar")
			<button class="btn btn-success">
				<b>{{ $task->status  }}</b>
			</button>
			@elseif ($task->status == "feito")
			<button class="btn btn-success">
				<b>{{ $task->status  }}</b>
			</button>
			@endif
		</td>
	</tr>
	@endforeach
</table>
<br>
<a class="btn btn-secondary" href="{{ route('task.create', [
				'taskName' =>"Prospecção",
				'opportunityId' => $opportunity->id,
				'opportunityName' => $opportunity->name,
				'opportunityContactName' => $opportunity->contact->name,
				'opportunityContactId' => $opportunity->contact->id,
				'taskAccountName' => $opportunity->account->name,
				'taskAccountId' => $opportunity->account->id,
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
				'opportunityName' => $opportunity->name,
				'opportunityId' => $opportunity->id,
				'opportunityDescription' => $opportunity->description,
//				'opportunityUserName' => $opportunity->user->name,
//				'opportunityUserId' => $opportunity->user->id,
				'opportunityAccountName' => $opportunity->account->name,
				'opportunityAccountId' => $opportunity->account->id,
				])}}">
	NOVA FATURA
</a>
<br>
<br>
<label class="labels" for="">SITUAÇÃO:</label>
<span class="fields">{{$opportunity->status }}</span>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($opportunity->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('opportunity.destroy', ['opportunity' => $opportunity->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('opportunity.edit', ['opportunity' => $opportunity->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('opportunity.index')}}">VOLTAR</a>
</div>
<br>

@endsection