@extends('layouts/master')

@section('title','YOUTUBE')

@section('image-top')
{{ asset('images/youtube.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('report.create') }}">NOVO RELATÓRIO</a>
<a class="btn btn-primary" href="{{ route('youtube.create') }}">NOVA CONTA</a>
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

	@foreach ($youtubes as $youtube)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button" >
				<a href=" {{ $youtube->URL_name}}"  target="_blank">
					<i class='fab fa-youtube'></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('youtube.show', ['youtube' => $youtube->id]) }}">
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $youtube->page_name}}
		</td>
		<td class="table-list-center">
			<b>{{ $youtube->account->name}}</b>
		</td>

		@if ($youtube->status == "desativado")
		<td class="button-disable"><b>{{ $youtube->status  }}</b></td>
		@elseif ($youtube->status == "ativo")
		<td class="button-active"><b>{{ $youtube->status  }}</b></td>
		@else ($youtube->status == "pendente")
		<td class="button-delete"><b>{{ $youtube->status  }}</b></td>
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
