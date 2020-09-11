@extends('layouts/master')

@section('title','PINTEREST')

@section('image-top')
{{ asset('imagens/pinterest.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('report.create') }}">NOVO RELATÓRIO</a>
<a class="btn btn-primary" href="{{ route('pinterest.create') }}">NOVA CONTA</a>
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

	@foreach ($pinterests as $pinterest)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button" >
				<a href=" {{ $pinterest->URL_name}}"  target="_blank"  >
					<i class='fab fa-pinterest'></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('pinterest.show', ['pinterest' => $pinterest->id]) }}" >
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $pinterest->page_name}}
		</td>
		<td class="table-list-center">
			<b>{{ $pinterest->users->name}}</b>
		</td>

		@if ($pinterest->status == "desativado")
		<td class="button-disable"><b>{{ $pinterest->status  }}</b></td>
		@elseif ($pinterest->status == "ativo")
		<td class="button-active"><b>{{ $pinterest->status  }}</b></td>
		@else ($pinterest->status == "pendente")
		<td class="button-delete"><b>{{ $pinterest->status  }}</b></td>
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
