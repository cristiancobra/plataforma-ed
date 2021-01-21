@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contract.index')}}">
	VOLTAR
</a>
<a class="button-primary"  href="{{route('contract.pdf', ['contract' => $contract->id])}}">
	PDF
</a>
@endsection

@section('main')
<br>
<h1 class="name" style="text-align: center">
	{{$contract->name}}
</h1>
<br>
<h3>
	Objeto do contrato
</h3>
<p>
    É objeto deste contrato a {{$contract->name}} nos termos aqui descritos.
</p>
<br>
<h3>
	Identificação das partes
</h3>
<p>
	São partes deste contrato a empresa contratada 
	<span class="labels">{{$contract->account->name}}</span>
	<button class="button-round">
		<a href=" {{ route('account.edit', ['account' => $contract->account->id]) }}">
			<i class='fa fa-edit' style="color:white"></i></a>
	</button>
	inscrita no CNPJ sob o nº
	<span class="labels">{{formatCnpj($contract->account->cnpj)}}</span>.
	Localizada na
	<span class="labels">{{$contract->account->address}}</span>,
	em
	<span class="labels">{{$contract->account->city}}</span>,
	–
	<span class="labels">{{$contract->account->state}}</span>,
	CEP
	<span class="labels">{{formatZipCode($contract->account->zip_code)}}</span>,
	representada por
	<span class="labels">{{$contract->userContact->name}}</span>
	<button class="button-round">
		<a href=" {{route('contact.edit', ['contact' => $contract->userContact->id])}}">
			<i class='fa fa-edit' style="color:white"></i></a>
	</button>
	,
	inscrito no CPF sob o nº
	<span class="labels">{{formatCpf($contract->userContact->cpf)}}</span>,
	residente em
	<span class="labels">{{$contract->userContact->address}}</span>,
	em
	<span class="labels">{{$contract->userContact->city}}</span>,
	/
	<span class="labels">{{$contract->userContact->state}}</span>,
	CEP:
	<span class="labels">{{formatZipCode($contract->userContact->zip_code)}}</span> e,
</p>
<br>
<p>
	a empresa contratante
	<span class="labels">{{$contract->company->name}}</span>
	<button class="button-round">
		<a href=" {{ route('company.edit', ['company' => $contract->company->id]) }}">
			<i class='fa fa-edit' style="color:white"></i></a>
	</button>
	inscrita no CNPJ sob o nº
	<span class="labels">{{formatCnpj($contract->company->cnpj)}}</span>.
	Localizada na
	<span class="labels">{{$contract->company->address}}</span>,
	em
	<span class="labels">{{$contract->company->city}}</span>,
	–
	<span class="labels">{{$contract->company->state}}</span>,
	CEP
	<span class="labels">{{formatZipCode($contract->company->zip_code)}}</span>,
	representada por
	<span class="labels">{{$contract->contact->name}}</span>
	<button class="button-round">
		<a href=" {{route('contact.edit', ['contact' => $contract->contact->id])}}">
			<i class='fa fa-edit' style="color:white"></i></a>
	</button>
	,
	inscrito no CPF sob o nº
	<span class="labels">{{formatCpf($contract->contact->cpf)}}</span>,
	residente em
	<span class="labels">{{$contract->contact->address}}</span>,
	em
	<span class="labels">{{$contract->contact->city}}</span>,
	/
	<span class="labels">{{$contract->contact->state}}</span>,
	CEP:
	<span class="labels">{{formatZipCode($contract->contact->zip_code)}}</span>.
</p>
<br>
<h3>
	Serviços/produtos contratados
</h3>
<p>
	Segue abaixo a lista de itens contratados e suas especificidades:
</p>
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 5%">
			<b>QTDE
			</b></td>
		<td   class="table-list-header" style="width: 55%">
			<b>NOME</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>PRAZO</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>IMPOSTO </b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>UNITÁRIO</b>
		</td>
		<td   class="table-list-header" style="width: 10%">
			<b>TOTAL</b>
		</td>
	</tr>

	@foreach ($invoiceLines as $invoiceLine)
	<tr style="font-size: 14px">
		<td class="table-list-center">
			{{$invoiceLine->amount}}
		</td>
		<td class="table-list-left">
			{{$invoiceLine->product->name}}
		</td>
		<td class="table-list-center">
			{{$invoiceLine->subtotalDeadline}} dia(s)
		</td>
		<td class="table-list-right">
			{{number_format($invoiceLine->subtotalTax_rate, 2,",",".")}}
		</td>
		<td class="table-list-right">
			{{number_format($invoiceLine->product->price,2,",",".")}}
		</td>
		<td class="table-list-right">
			{{number_format($invoiceLine->subtotalPrice,2,",",".")}}
		</td>
	</tr>

	<tr style="font-size: 12px">
		<td class="table-list-left" colspan="5">
			{!!html_entity_decode($invoiceLine->product->description)!!}
		</td>
	</tr>
	@endforeach

	<tr>
		<td   class="table-list-header-right" colspan="4">
		</td>
		<td   class="table-list-header-right">
			desconto: 
		</td>
		<td   class="table-list-header-right">
			<b>- {{number_format($contract->invoice->discount, 2,",",".") }}</b>
		</td>
	</tr>
	<tr>
		<td   class="table-list-header-right" colspan="4">

		<td   class="table-list-header-right">
			TOTAL: 
		</td>
		</td>
		<td   class="table-list-header-right">
			<b>R$ {{number_format($contract->invoice->totalPrice, 2,",",".") }}</b>
		</td>
	</tr>
</table>
<br>
<label class="labels" for="" >MEIO DE PAGAMENTO: </label>
<span class="fields">{{$contract->invoice->payment_method}}</span>
<br>
<label class="labels" for="" >PARCELAMENTO: </label>
@if($contract->invoice->number_installment == 1)
<span class="fields">À vista</span>
@else
<span class="fields">{{$contract->invoice->number_installment}} x {{$contract->invoice->number_installment_value}}</span>
@endif
<br>
<br>
</p>
<br>
<h3>
	Condições gerais
</h3>
<p>
	{!!html_entity_decode($contract->text)!!}
</p>
<br>
<br>
<p class="labels"> <b> Criado em:  </b>{{date('d/m/Y H:i', strtotime($contract->created_at))}}</p>

<div style="text-align:right">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('contract.destroy', ['contract' => $contract->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('contract.edit', ['contract' => $contract->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('contract.index')}}">VOLTAR</a>
</div>
<br>

@endsection