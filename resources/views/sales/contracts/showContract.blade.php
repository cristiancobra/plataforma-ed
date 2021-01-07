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
	<span class="labels">{{$userContact->name}}</span>
	<button class="button-round">
		<a href=" {{ route('contact.edit', ['contact' => $userContact->contact_id]) }}">
			<i class='fa fa-edit' style="color:white"></i></a>
	</button>
	,
	inscrito no CPF sob o nº
	<span class="labels">{{formatCpf($userContact->contact->cpf)}}</span>,
	residente em
	<span class="labels">{{$userContact->contact->address}}</span>,
	em
	<span class="labels">{{$userContact->contact->city}}</span>,
	/
	<span class="labels">{{$userContact->contact->state}}</span>,
	CEP:
	<span class="labels">{{formatZipCode($userContact->contact->zip_code)}}</span> e,
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
	<span class="labels">{{$contract->contact->address_city}}</span>,
	/
	<span class="labels">{{$contract->contact->address_state}}</span>,
	CEP:
	<span class="labels">{{formatZipCode($contract->contact->zip_code)}}</span>.
</p>
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