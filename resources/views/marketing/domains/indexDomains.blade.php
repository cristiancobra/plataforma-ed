@extends('layouts/master')

@section('title','DOMÍNIOS')

@section('image-top')
{{ asset('imagens/domain.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('domain.create')}}">NOVA OPORTUNIDADE</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalDomains }} produtos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Nome </b></td>
			<td   class="table-list-header"><b>Tipo </b></td>
			<td   class="table-list-header"><b>PREÇO</b></td>
			<td   class="table-list-header"><b>ETAPA DA VENDA</b></td>
		</tr>

		@foreach ($domains as $domain)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('domain.show', ['domain' => $domain->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('domain.edit', ['domain' => $domain->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $domain->name }}
			</td>

			<td class="table-list-right">
				{{ $domain->type }}
			</td>
			
			<td class="table-list-right">
				R$ {{ number_format($domain->price,2,",",".") }}
			</td>
			
			<td class="table-list-right">
				{{ $domain->stage }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $domains->links() }}
	</p>
	<br>
	@endsection