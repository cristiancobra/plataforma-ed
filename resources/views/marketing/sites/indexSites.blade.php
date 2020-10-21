@extends('layouts/master')

@section('title','SITES')

@section('image-top')
{{ asset('imagens/financeiro.png') }} 
@endsection

@section('description')
<a class="btn btn-primary"  href="{{route('site.create')}}">NOVO SITE</a>
<a class="btn btn-primary"  href="{{route('domain.create')}}">NOVO DOMÍNIO</a>
@endsection

@section('main')
<div>
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalSites }} produtos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>NOME </b></td>
			<td   class="table-list-header"><b>DOMÍNIOS </b></td>
			<td   class="table-list-header"><b>LINKS</b></td>
			<td   class="table-list-header"><b>SITUAÇÃO</b></td>
		</tr>

		@foreach ($sites as $site)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('site.show', ['site' => $site->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('site.edit', ['site' => $site->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $site->name }}
			</td>

		<td class="table-list-left">
			@foreach ($site->domains as $domain)
			<a class="white"  href=" {{ route('domain.show', ['domain' => $domain->id]) }}">
				<button class="button">
					<i class='fa fa-eye'></i>
				</button> 
			</a>
			{{ $domain->name }}</li>
			<br>
			</a>
			@endforeach
		</td>
			
			<td class="table-list-right">
				<button class="button">
					<a href=" {{ $site->link_view }}" target="_blank">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ $site->link_edit }}"  target="_blank">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
			</td>

			<td class="table-list-right">
			{{ $site->status }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $sites->links() }}
	</p>
	<br>
	@endsection