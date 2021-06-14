@extends('layouts/master')

@section('title','RELATÓRIOS')

@section('image-top')
{{asset('imagens/report.png')}} 
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('report.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<table class="table-list">
	<tr>
		<td   class="table-list-header">
			VER
		</td>
		<td   class="table-list-header">
			TÍTULO
		</td>
		<td   class="table-list-header">
			DONO 
		</td>
		<td   class="table-list-header">
			DATA 
		</td>
		<td   class="table-list-header">
			STATUS
		</td>
	</tr>

	@foreach ($reports as $report)
	<tr style="font-size: 16px">
		<td class="table-list-center">
			<button class="button">
				<a href=" {{ route('report.show', ['report' => $report]) }}"> 
				   <i class='fa fa-eye'></i>
				</a>
			</button>
		</td>

		<td class="table-list-left"> 
			{{ $report->name}} 
		</td>
		<td class="table-list-left">
			{{ $report->account->name}} 
		</td>
		<td class="table-list-center"> {{ $report->date }} 
		</td>
		@if ($report->status == "desativado")
		<td class="button-disable">{{ $report->status  }}
		</td>
		@elseif ($report->status == "ativo")
		<td class="button-active">{{ $report->status  }}
		</td>
		@else ($report->status == "pendente")
		<td class="button-delete">{{ $report->status  }}
		</td>
		@endif
	</tr>
	@endforeach
</table>
<br>
<br>
@endsection
