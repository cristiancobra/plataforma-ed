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
    São partes deste contrato a contratada {{$account->name}} inscrita no CNPJ sob o XXXXXXXXXXXXX tendo como responsável ,
	inscrito no CPF sob o nº XXXXXXXXX. Localizada na XXXXXXXXXX, no XXXXXXXXXXXX, em XXXXXXX – XXXXXXXXXX,
	CEP XXXXXXXX E XXXXXXXXXX, daqui em diante denominado apenas como cliente, inscrito no no CPF sob o nº XXXXXXXXXXXxxx.
	Localizado na , CEP XXXXX , XXXX e
</p>
<p>
    a contratante {{$contact->name}} inscrita no CNPJ sob o XXXXXXXXXXXXX tendo como responsável ,
	inscrito no CPF sob o nº XXXXXXXXX. Localizada na XXXXXXXXXX, no XXXXXXXXXXXX, em XXXXXXX – XXXXXXXXXX,
	CEP XXXXXXXX E XXXXXXXXXX, daqui em diante denominado apenas como cliente, inscrito no no CPF sob o nº XXXXXXXXXXXxxx.
	Localizado na , CEP XXXXX , XXXX e
</p>
<p>
	{!!html_entity_decode($contract->text)!!}
</p>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($contract->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
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