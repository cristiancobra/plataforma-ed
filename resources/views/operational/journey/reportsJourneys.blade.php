@extends('layouts/master')

@section('title','JORNADAS')

@section('image-top')
{{ asset('imagens/journey.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('journey.index')}}">
	VOLTAR
</a>
@endsection

@section('main')
<form action=" {{route('journey.reports')}} " method="post" style="text-align: right;color: #874983">
	@csrf
	<select class="select"name="user_id">
		<option  class="fields" value="">
			2020
		</option>
	</select>
	<input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 50%">
			<b>FUNCIONÁRIO </b>
		</td>
		@foreach ($months as $month)
		<td   class="table-list-header" style="width: 10%">
			{{$month}}
		</td>
		@endforeach
		<td   class="table-list-header" style="width: 10%">
			<b>TOTAL </b>
		</td>
	</tr>
	<br>
	@php
	$counterArray = 1;

	foreach ($users as $user) {
	$counterMonth = 1;
	$totalUser = 0;

	echo "<tr style='font-size: 14px'>
		<td class='table-list-left'>
			{{$user->contact->name}}
		</td>
		";
		while ($counterMonth <= 12) {
		echo "<td class='table-list-center'>";
		echo number_format($resultUsers[$counterArray] / 3600, 1, ',','.');
		echo "</td>";
		$totalUser = $totalUser + $resultUsers[$counterArray];
		$counterMonth++;
		$counterArray++;
		}
	echo "<td class='table-list-center' style='color:white;background-color: #874983'>";
		echo number_format($totalUser / 3600, 1, ',','.');
	echo "</td>
		</tr>";
	}
	@endphp
</table>
<br>

<table class="table-list">
	<tr>
		<td   class="table-list-header" style="width: 50%">
			<b>CATEGORIA </b>
		</td>
		@foreach ($months as $month)
		<td   class="table-list-header" style="width: 10%">
			{{$month}}
		</td>
		@endforeach
		<td   class="table-list-header" style="width: 10%">
			<b>TOTAL </b>
		</td>
	</tr>
	@php
	$counterArray = 1;

	foreach ($departments as $department) {
	$counterMonth = 1;
	$totalCategory = 0;

	echo "<tr style='font-size: 14px'>
		<td class='table-list-left'>
			$department
		</td>
		";
		while ($counterMonth <= 12) {
		echo "<td class='table-list-center'>";
		echo number_format($resultCategories[$counterArray] / 3600, 1, ',','.');
		echo "</td>";
		$totalCategory = $totalCategory + $resultCategories[$counterArray];
		$counterMonth++;
		$counterArray++;
		}
	echo "<td class='table-list-center' style='color:white;background-color: #874983'>";
		echo number_format($totalCategory / 3600, 1, ',','.');
	echo "</td>
		</tr>";
	}
	@endphp
</table>
<br>
<br>
@endsection