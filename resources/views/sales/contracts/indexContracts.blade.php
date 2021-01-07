@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('contractTemplate.index')}}">
	MODELOS
</a>
<a class="button-primary"  href="{{route('contract.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				TÍTULO
			</td>
			<td   class="table-list-header">
				CONTRATADA
			</td>
			<td   class="table-list-header">
				CONTRATANTE
			</td>
			<td   class="table-list-header">
				RESPONSÁVEL
			</td>
			<td   class="table-list-header">
				SITUAÇÃO
			</td>
		</tr>

		@foreach ($contracts as $contract)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('contract.show', ['contract' => $contract->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button-round">
					<a href=" {{ route('contract.edit', ['contract' => $contract->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{$contract->name}}
			</td>
			<td class="table-list-center">
				{{$contract->account->name}}
			</td>
			<td class="table-list-center">
				{{$contract->contact->name}}
			</td>
			<td class="table-list-center">
				{{$contract->contact->name}}
			</td>
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $contracts->links() }}
	</p>
	<br>
	@endsection