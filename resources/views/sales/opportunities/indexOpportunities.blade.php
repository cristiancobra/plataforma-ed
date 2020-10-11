@extends('layouts/master')

@section('title','OPORTUNIDADES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('opportunitie.create')}}">NOVA OPORTUNIDADE</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalOpportunities }} produtos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Nome </b></td>
			<td   class="table-list-header"><b>Tipo </b></td>
			<td   class="table-list-header"><b>PREÇO</b></td>
			<td   class="table-list-header"><b>ETAPA DA VENDA</b></td>
		</tr>

		@foreach ($opportunities as $opportunitie)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('opportunitie.show', ['opportunitie' => $opportunitie->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('opportunitie.edit', ['opportunitie' => $opportunitie->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $opportunitie->name }}
			</td>

			<td class="table-list-right">
				{{ $opportunitie->type }}
			</td>
			
			<td class="table-list-right">
				R$ {{ number_format($opportunitie->price,2,",",".") }}
			</td>
			
			<td class="table-list-right">
				{{ $opportunitie->stage }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $opportunities->links() }}
	</p>
	<br>
	@endsection