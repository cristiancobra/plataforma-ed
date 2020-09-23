@extends('layouts/master')

@section('title','RELATÓRIOS')

@section('image-top')
{{ asset('imagens/report.png') }} 
@endsection

@section('description')
<a class="btn btn-primary" href="{{route('report.create')}}">NOVO RELATÓRIO</a>
@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right">Você possui <span class="labels">{{ $totalReports }} relatório(s)</span></p>
<table class="table-list">
	<tr>
		<td   class="table-list-header">
			<b>VER</b>
		</td>
		<td   class="table-list-header">
			<b>TÍTULO</b>
		</td>
		<td   class="table-list-header">
			<b>DONO </b>
		</td>
		<td   class="table-list-header">
			<b>DATA </b>
		</td>
		<td   class="table-list-header">
			<b>STATUS</b>
		</td>
	</tr>

	@foreach ($reports as $report)
	<tr style="font-size: 16px">
		<td class="table-list-center">
			<button class="button">
				<a href=" {{ route('report.show', ['report' => $report->id]) }}"  
				   <i class='fa fa-eye'></i>
				</a>
			</button>
		</td>

		<td class="table-list-left"> 
			<b>{{ $report->name}} </b>
		</td>
		<td class="table-list-left">
			<b>{{ $report->account->name}} </b>
		</td>
		<td class="table-list-center"> <b>{{ $report->date }} </b>
		</td>
		@if ($report->status == "desativado")
		<td class="button-disable"><b>{{ $report->status  }}</b>
		</td>
		@elseif ($report->status == "ativo")
		<td class="button-active"><b>{{ $report->status  }}</b>
		</td>
		@else ($report->status == "pendente")
		<td class="button-delete"><b>{{ $report->status  }}</b>
		</td>
		@endif
	</tr>
	@endforeach
</table>
<br>
<br>
@endsection