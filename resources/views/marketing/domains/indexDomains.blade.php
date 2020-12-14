@extends('layouts/master')

@section('title','DOMÍNIOS')

@section('image-top')
{{ asset('imagens/domain.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('site.index')}}">
	SITES
</a>
<a class="button-primary"  href="{{route('domain.create')}}">
	CRIAR
</a>
@endsection

@section('main')
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalDomains }} produtos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>DOMÍNIO </b>
			</td>
			<td   class="table-list-header">
				<b>EMPRESA</b>
			</td>
			<td   class="table-list-header">
				<b>PROVEDOR</b>
			</td>
			<td   class="table-list-header">
				<b>DATA DE RENOVAÇÃO:</b>
			</td>
			<td   class="table-list-header">
				<b>SITUAÇÃO</b>
			</td>
		</tr>

		@foreach ($domains as $domain)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button-round">
					<a href=" {{ route('domain.show', ['domain' => $domain->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button-round">
					<a href=" {{ route('domain.edit', ['domain' => $domain->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{$domain->name}}
			</td>
			<td class="table-list-center">
				{{$domain->account->name}}
			</td>
			<td class="table-list-center">
				{{$domain->provider}}
			</td>
			<td class="table-list-center">
				{{$domain->due_date}}
			</td>
			<td class="table-list-center">
				{{$domain->status}}
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