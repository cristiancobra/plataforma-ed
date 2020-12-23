@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalOpportunities}} </span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('opportunity.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-right: 6%">
		Você possui <span class="labels">{{$totalOpportunities }} oportunidades </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>NOME </b>
			</td>
			<td   class="table-list-header">
				<b>CONTATO </b>
			</td>
			<td   class="table-list-header">
				<b>RESPONSÁVEL </b>
			</td>
			<td   class="table-list-header">
				<b>FAZER CONTATO </b>
			</td>
			<td   class="table-list-header">
				<b>ETAPA DA VENDA</b>
			</td>
			<td   class="table-list-header">
				<b>STATUS</b>
			</td>
		</tr>

		@foreach ($opportunities as $opportunity)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('opportunity.show', ['opportunity' => $opportunity->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button-round">
					<a href=" {{ route('opportunity.edit', ['opportunity' => $opportunity->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $opportunity->name }}
			</td>
			<td class="table-list-center">
				{{ $opportunity->contact->name }}
			</td>
			<td class="table-list-center">
				{{ $opportunity->user->name }}
			</td>
			<td class="table-list-center">
				@isset($opportunity->date_conclusion)
				{{date('d/m/Y', strtotime($opportunity->date_conclusion))}}
				@else
				sem data
				@endisset
			</td>
			<td class="table-list-center">
				{{$opportunity->stage}}
			</td>
			{{formatStatus($opportunity)}}
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $opportunities->links() }}
	</p>
	<br>
	@endsection