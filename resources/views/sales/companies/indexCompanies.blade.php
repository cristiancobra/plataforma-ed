@extends('layouts/master')

@section('title','EMPRESAS')

@section('image-top')
{{ asset('imagens/empresa.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalCompanies}} </span>
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('company.create')}}">
	CRIAR
</a>
@endsection

@section('main')
<div>
	<table class="table-list">
		<tr>
			<td   class="table-list-header">
				<b>Nome</b>
			</td>
			<td   class="table-list-header">
				<b>Email</b>
			</td>
			<td   class="table-list-header">
				<b>Telefone</b>
			</td>
			<td   class="table-list-header">
				<b>Cidade </b>
			</td>
			<td   class="table-list-header">
				<b>Dono</b>
			</td>
		</tr>

		@foreach ($companies as $company)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<a class="white" href=" {{route('company.show', ['company' => $company])}}">
					<button class="button-round">
						<i class='fa fa-eye'></i>
					</button>
				</a>
				{{$company->name}}
			</td>
			<td class="table-list-left">
				{{$company->email}}
			</td>
			<td class="table-list-right">
				{{$company->phone}}
			</td>
			<td class="table-list-center">
				{{$company->city}}
			</td>
			<td class="table-list-center">
				{{$company->account->name}}
			</td>
		</tr>
		@endforeach
	</table>
	<p style="text-align: right">
		<br>
		{{$companies->links()}}
	</p>
	<br>
	@endsection