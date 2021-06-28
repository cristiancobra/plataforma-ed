@extends('layouts/master')

@section('title','LINKEDIN')

@section('image-top')
{{ asset('images/linkedin.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{ route('report.create') }}">NOVO RELATÓRIO</a>
<a class="btn btn-primary" href="{{ route('linkedin.create') }}">NOVA CONTA</a>
@endsection

@section('main')
<br>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>Nome do perfil</b></td>
		<td   class="table-list-header"><b>Dono </b></td>
		<td   class="table-list-header"><b>Status</b></td>
	</tr>

	@foreach ($linkedins as $linkedin)
	<tr style="font-size: 16px">
		<td class="table-list-left">
			<button class="button" >
				<a href=" {{ $linkedin->URL_name}}"  target="_blank">
					<i class='fab fa-linkedin-in'></i></a>
			</button>
			<button class="button">
				<a href=" {{ route('linkedin.show', ['linkedin' => $linkedin->id]) }}">
					<i class='fa fa-eye'></i></a>
			</button>
			{{ $linkedin->page_name}}
		</td>
		<td class="table-list-center"><b>{{ $linkedin->account->name}}</b></td>

		@if ($linkedin->status == "desativado")
		<td class="button-disable"><b>{{ $linkedin->status  }}</b></td>
		@elseif ($linkedin->status == "ativo")
		<td class="button-active"><b>{{ $linkedin->status  }}</b></td>
		@else ($linkedin->status == "pendente")
		<td class="button-delete"><b>{{ $linkedin->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
@endsection
