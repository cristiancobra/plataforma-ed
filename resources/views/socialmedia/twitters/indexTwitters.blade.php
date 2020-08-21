@extends('layouts/master')

@section('title','TWITTER')

@section('image-top')
{{ asset('imagens/twitter.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('report.create') }}">NOVO RELATÓRIO</a>
<a class="btn btn-primary" href="{{ route('twitter.create') }}">NOVA CONTA</a>
@endsection

@section('main')
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome do perfil</b></td>
		<td   class="table-list-header"><b>Dono </b></td>
		<td   class="table-list-header"><b>Status</b></td>
		<td   class="table-list-header"><b>Avaliação</b></td>
	</tr>

	@foreach ($twitters as $twitter)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button" >
				<a href=" {{ $twitter->URL_name}}"  target="_blank"  style="text-decoration: none;color: black">
					<i class='fab fa-twitter'></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('twitter.show', ['twitter' => $twitter->id]) }}" style="text-decoration: none;color: black">
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $twitter->page_name}}
		</td>
		<td class="table-list-center"><b>{{ $twitter->users()->first()->name}}</b></td>

		@if ($twitter->status == "desativado")
		<td class="button-disable"><b>{{ $twitter->status  }}</b></td>
		@elseif ($twitter->status == "ativo")
		<td class="button-active"><b>{{ $twitter->status  }}</b></td>
		@else ($twitter->status == "pendente")
		<td class="button-delete"><b>{{ $twitter->status  }}</b></td>
		@endif

		@if ($twitter->score == "desativado")
		<td class="button-disable"><b>{{ $twitter->status  }}</b></td>
		@elseif ($twitter->status == "ativo")
		<td class="button-active"><b>{{ $twitter->status  }}</b></td>
		@else ($twitter->status == "pendente")
		<td class="button-delete"><b>{{ $twitter->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
<br>
@endsection
