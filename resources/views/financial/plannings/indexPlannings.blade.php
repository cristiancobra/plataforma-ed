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
	<p class="subtitulo-roxo" style="text-align: right;padding-top: 2%;padding-right: 6%">
		Você possui <span class="labels">{{$totalPlannings }} produtos </span>
	</p>
	<br>
	<table class="table-list">
		<tr>
			<td   class="table-list-header"><b>Nome </b></td>
			<td   class="table-list-header"><b>Tipo </b></td>
			<td   class="table-list-header"><b>Entrega</b></td>
			<td   class="table-list-header"><b>Horas previstas</b></td>
			<td   class="table-list-header"><b>Custos</b></td>
			<td   class="table-list-header"><b>Imposto</b></td>
			<td   class="table-list-header"><b>Margem</b></td>
			<td   class="table-list-header"><b>Preço</b></td>
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

			<td class="table-list-right">
				{{ $planning->type }}
			</td>

			@if ($planning->due_date == 0)
			<td class="table-list-right">
				imediata
			</td>
			@else
			<td class="table-list-right">
				{{ $planning->due_date }} dias
			</td>
			@endif
			
			<td class="table-list-right">
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