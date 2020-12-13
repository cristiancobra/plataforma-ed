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
<form action=" {{route('journey.reports')}} " method="post" style="padding: 20px;text-align: right;color: #874983">
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

	@foreach ($users as $user)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			{{$user->name}}
		</td>
		<td class="table-list-left">
			{{number_format($user->janeiro / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->fevereiro / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->março / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->abril / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->maio / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->junho / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->julho / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->agosto / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->setembro / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->outubro / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->novembro / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center">
			{{number_format($user->dezembro / 3600, 1, ',','.')}}
		</td>
		<td class="table-list-center" style="color:white;background-color: #874983">
		</td>
	</tr>
	@endforeach
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

	@foreach ($categories as $category)
	<tr style="font-size: 14px">
		<td class="table-list-left">
			{{$category}}
		</td>
		@while($counter <= 12)
		<td class="table-list-left">
			{{$resultCategories[$counter++]}}
		</td>
		@endwhile
		<td class="table-list-center" style="color:white;background-color: #874983">
		</td>
	</tr>
	@endforeach
</table>
<br>
<br>
@endsection