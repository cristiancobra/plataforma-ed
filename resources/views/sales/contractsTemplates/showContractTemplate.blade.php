@extends('layouts/master')

@section('title','MODELOS DE CONTRATO')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('contractTemplate')}}
@endsection

@section('main')
<br>
<h1 class="name">
	{{$contractTemplate->name}}
</h1>
<p class="labels">
	EMPRESA: {{$contractTemplate->account->name}}
</p>
<br>
<p class="labels">
	TEXTO DO CONTRATO:
</p>
<p>
	{!!html_entity_decode($contractTemplate->text)!!}
</p>
<br>
<br>
<p class="labels"> <b> Criado em:  </b> {{ date('d/m/Y H:i', strtotime($contractTemplate->created_at)) }} </p>

<div style="text-align:right;padding: 2%">
	<form   style="text-decoration: none;display: inline-block" action="{{ route('contractTemplate.destroy', ['contractTemplate' => $contractTemplate->id]) }}" method="post">
		@csrf
		@method('delete')
		<input class="btn btn-danger" type="submit" value="APAGAR">
	</form>
	<a class="btn btn-secondary" href=" {{ route('contractTemplate.edit', ['contractTemplate' => $contractTemplate->id]) }} "  style="text-decoration: none;color: white;display: inline-block">
		<i class='fa fa-edit'></i>EDITAR</a>
	<a class="btn btn-secondary" href="{{route('contractTemplate.index')}}"><i class="fas fa-arrow-left"></i></a>
</div>
<br>
<br>
<br>
@endsection