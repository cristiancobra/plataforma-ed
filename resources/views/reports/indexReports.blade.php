@extends('layouts/master')

@section('title','VER RELATÓRIOS')

@section('image-top')
{{ asset('imagens/email.png') }} 
@endsection

@section('description')

Meus relatórios
<a href="/relatorios/novo"><br><br>
	<button type="button" class="button-header">CRIAR RELATÓRIO MATURIDADE DIGITAL</button> </a>

@endsection

@section('main')
<p class="subtitulo-roxo" style="text-align: right">Você possui <span class="labels">{{ $totalReports }} relatório(s)</span></p>
<table class="table-list">
	<tr>
		<td   class="table-list-header"><b>VER</b></td>
		<td   class="table-list-header"><b>TÍTULO</b></td>
		<td   class="table-list-header"><b>DATA </b></td>
		<td   class="table-list-header"><b>LOGOMARCA </b></td>
		<td   class="table-list-header"><b>PALETA</b></td>
		<td   class="table-list-header"><b>INSTAGRAM BUSINESS</b></td>
		<td   class="table-list-header"><b>STATUS</b></td>
	</tr>

	@foreach ($reports as $report)
	<tr style="font-size: 16px">
		<td class="table-list-center">
			<button class="button">
				<a href=" {{ route('reports.show', ['report' => $report->id]) }}"  style="text-decoration: none;color: black"><i class='fa fa-eye'></i></a>
			</button>
		</td>

		<td class="table-list-left"> <b>{{ $report->name}} </b></td>
		<td class="table-list-left"> <b>{{ $report->date }} </b></td>
		<td class="table-list-center"><b>{{ $report->logo}}</b></td>
		<td class="table-list-center"><b>{{ $report->palette }} </b></td>
		<td class="table-list-center"><b>{{ $report->instagram_businness }} </b></td>
		@if ($report->status == "desativado")
		<td class="button-disable"><b>{{ $report->status  }}</b></td>
		@elseif ($report->status == "ativo")
		<td class="button-active"><b>{{ $report->status  }}</b></td>
		@else ($report->status == "pendente")
		<td class="button-delete"><b>{{ $report->status  }}</b></td>
		@endif
	</tr>
	@endforeach
</table>
@endsection