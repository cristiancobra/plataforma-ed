@extends('layouts/index')

@if($typeCompanies == 'cliente')
@section('title','EMPRESAS')
@elseif($typeCompanies == 'fornecedor')
@section('title','FORNECEDORES')
@elseif($typeCompanies == 'cliente e fornecedor')
@section('title','CLIENTE FORNECEDOR')
@elseif($typeCompanies == 'concorrente')
@section('title','CONCORRENTES')
@endif

@section('image-top')
{{asset('images/empresa.png')}} 
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('company.create', ['typeCompanies' => $typeCompanies])}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('table')
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
                País
            </td>
            <td   class="table-list-header">
                Cidade 
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
            <td class="table-list-center">
                {{$company->email}}
            </td>
            <td class="table-list-center">
                {{$company->country}}
            </td>
            <td class="table-list-center">
                {{$company->city}}
            </td>
        </tr>
        @endforeach
    </table>

    @section('paginate', $companies->links())

    @endsection
