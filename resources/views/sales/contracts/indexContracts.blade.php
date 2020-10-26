@extends('layouts/master')

@section('title','CONTRATOS')

@section('image-top')
{{ asset('imagens/contract.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('contract.create')}}">NOVO CONTRATO</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalContracts }} contratos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>TÍTULO </b></td>
			<td   class="table-list-header"><b>CONTRATANTE </b></td>
			<td   class="table-list-header"><b>SITUAÇÃO</b></td>
		</tr>

		@foreach ($contracts as $contract)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('contract.show', ['contract' => $contract->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('contract.edit', ['contract' => $contract->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $contract->name }}
			</td>

			<td class="table-list-right">
				{{ $contract->contact->name}}
			</td>
			
			<td class="table-list-right">
				{{ $contract->status }}
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