@extends('layouts/master')

@section('title','SPOTIFY')

@section('image-top')
{{ asset('imagens/spotify.png
.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('report.create') }}">NOVO RELATÓRIO</a>
<a class="btn btn-primary" href="{{ route('spotify.create') }}">NOVA CONTA</a>
@endsection

@section('main')
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome do perfil</b></td>
		<td   class="table-list-header"><b>Dono </b></td>
		<td   class="table-list-header"><b>Status</b></td>
		<td   class="table-list-header" style="width: 30%"><b>Avaliação</b></td>
	</tr>

	@foreach ($spotifys as $spotify)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button" >
				<a href=" {{ $spotify->URL_name}}"  target="_blank" >
					<i class='fab fa-spotify'></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('spotify.show', ['spotify' => $spotify->id]) }}" >
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $spotify->page_name}}
		</td>
		<td class="table-list-center">
			<b>{{ $spotify->account->name}}</b>
		</td>

		@if ($spotify->status == "desativado")
		<td class="button-disable"><b>{{ $spotify->status  }}</b></td>
		@elseif ($spotify->status == "ativo")
		<td class="button-active"><b>{{ $spotify->status  }}</b></td>
		@else ($spotify->status == "pendente")
		<td class="button-delete"><b>{{ $spotify->status  }}</b></td>
		@endif

		<td class="table-list-left">
		<div class="progress-bar progress-bar-animated" role="progressbar" aria-valuenow="50"
			 aria-valuemin="0" aria-valuemax="100" style="display: inline-block;margin-left: 1rem;margin-top:0.4rem;margin-bottom: -0.5rem;width:40%">
			50%
		</div>
	</td>
</tr>
@endforeach
</table>
<br>
@endsection
