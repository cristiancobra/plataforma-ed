@extends('layouts/master')

@if($typeCompanies == 'cliente')
@section('title','EMPRESAS')
@elseif($typeCompanies == 'fornecedor')
@section('title','FORNECEDORES')
@elseif($typeCompanies == 'concorrente')
@section('title','CONCORRENTES')
@endif

@section('image-top')
{{asset('imagens/empresa.png')}} 
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('company.create', ['typeCompanies' => $typeCompanies])}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header">
                Nome
            </td>
            <td   class="table-list-header">
                Email
            </td>
            <td   class="table-list-header">
                Telefone
            </td>
            <td   class="table-list-header">
                Cidade 
            </td>
            <td   class="table-list-header">
                Dono
            </td>
        </tr>

		@foreach ($companies as $company)
		<tr style="font-size: 14px">
			<td class="table-list-left">
				<a class="white" href=" {{route('company.show', [
					'company' => $company,
					'typeCompanies' => $company->type,
				])}}">
					<button class="button-round">
						<i class='fa fa-eye'></i>
					</button>
				</a>
				<a class="white" href=" {{route('company.edit', [
				'company' => $company,
				'typeCompanies' => $company->type,
			])}}">
					<button class="button-round">
						<i class='fa fa-edit'></i>
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
