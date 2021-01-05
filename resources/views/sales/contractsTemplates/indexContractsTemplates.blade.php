@extends('layouts/master')

@section('title','MODELOS DE CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contractTemplate.index')}}">
	VER CONTRATOS
</a>
<a class="button-primary"  href="{{route('contractTemplate.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>TÍTULO </b>
			</td>
			<td   class="table-list-header">
				<b>CONTRATANTE </b>
			</td>
			<td   class="table-list-header">
				<b>SITUAÇÃO</b>
			</td>
		</tr>

		@foreach ($contractsTemplates as $contractTemplate)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('contractTemplate.show', ['contractTemplate' => $contractTemplate->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button-round">
					<a href=" {{ route('contractTemplate.edit', ['contractTemplate' => $contractTemplate->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $contractTemplate->name }}
			</td>

			<td class="table-list-right">
				{{ $contractTemplate->contact->name}}
			</td>
			
			<td class="table-list-right">
				{{ $contractTemplate->status }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $contractsTemplates->links() }}
	</p>
	<br>
	@endsection