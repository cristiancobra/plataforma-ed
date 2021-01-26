@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('imagens/planning.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-secondary"  href="{{route('planning.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<br>
	<p style="text-align: left">
		<label class="labels" for="">PREVISÃO:</label>
	</p>
	<table class="table-list">
		<tr>
			<td class="table-list-left" style="width: 70%">
				RECEITAS:
			</td>
			<td class="table-list-right" style="width: 30%">
				R$ {{number_format($revenueMonthly, 2,",",".")}}
			</td>
		</tr>
	</table>
	<br>
	<p style="text-align: left">
		<label class="labels" for="">FLUXO DE CAIXA:</label>
	</p>
	<table class="table-list">
		<tr>
			<td class="table-list-left" style="width: 70%">
				RECEITAS:
			</td>
			<td class="table-list-right" style="width: 30%">
				R$ {{number_format($estimatedRevenueMonthly, 2,",",".")}}
			</td>
		</tr>
	</table>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header" style="width: 40%">
				<b>Nome </b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>Quantidade </b>
			</td>
			<td   class="table-list-header" style="width: 5%">
				<b>Horas previstas</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Custos</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Imposto</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Preço</b>
			</td>
			<td   class="table-list-header" style="width: 10%">
				<b>Margem</b>
			</td>
		</tr>

		@foreach ($plannings as $planning)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<button class="button">
					<a href=" {{ route('planning.show', ['planning' => $planning->id]) }}">
						<i class='fa fa-eye' style="color:white"></i></a>
				</button>
				<button class="button">
					<a href=" {{ route('planning.edit', ['planning' => $planning->id]) }}">
						<i class='fa fa-edit' style="color:white"></i></a>
				</button>
				{{ $planning->name }}
			</td>

			@if ($planning->due_date == 0)
			<td class="table-list-center">
				imediata
			</td>
			@else
			<td class="table-list-center">
				{{ $planning->due_date }} dias
			</td>
			@endif

			<td class="table-list-center">
				{{ number_format($planning->work_hours)}}
			</td>

			<td class="table-list-right">
				R$ {{ number_format($planning->cost1 + $planning->cost2 + $planning->cost3, 2,",",".") }}
			</td>

			<td class="table-list-right">
				R$ {{ number_format($planning->price * $planning->tax_rate / 100, 2,",",".") }}
			</td>

			<td class="table-list-right">
				R$ {{ number_format(-$planning->price * $planning->tax_rate /100 - $planning->cost1 - $planning->cost2 - $planning->cost3 + $planning->price, 2,",",".") }}
			</td>

			<td class="table-list-right">
				R$ {{ number_format($planning->price,2,",",".") }}
			</td>

		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{ $plannings->links() }}
	</p>
	<br>
	@endsection