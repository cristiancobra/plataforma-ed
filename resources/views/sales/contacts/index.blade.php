@extends('layouts/index')

@section('title','CONTATOS')

@section('image-top')
{{asset('images/contact.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary' title='Filtrar lista'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button primary"  href="{{route('contact.create')}}" title='Criar novo'>
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('filter')
<form id="filter" action="{{route('contact.index')}}" method="get" style="text-align: right">
    <input type="text" name="name" placeholder="nome ou sobrenome" value="">
    {{createFilterSelect('type', 'select', $types)}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    <br>
    <a class="text-button secondary" href='{{route('contact.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
@endsection


@section('shortcuts')
<div class='col-lg-2 d-inline-block tasks-my'>
    <a style='text-decoration:none' href='{{route('contact.index', [
				'type' => 'funcionário',
				])}}'>
        <p class='panel-number'>
            {{$employessTotal}}
        </p>
        <p class='panel-text'>
            funcionários
        </p>
    </a>
</div>
<div class='col-lg-2 d-inline-block tasks-toDo'>
    <a style='text-decoration:none' href='{{route('contact.index', [
				'type' => 'parceiro',
				])}}'>
        <p class='panel-number'>
            {{$partnersTotal}}
        </p>
        <p class='panel-text'>
            parceiros
        </p>
    </a>
</div>
<div class='col-lg-2 d-inline-block tasks-now'>
<a style='text-decoration:none' href='{{route('contact.index', [
				'type' => 'cliente',
				])}}'>
        <p class='panel-number'>
            {{$clientsTotal}}
        </p>
        <p class='panel-text'>
            clientes
        </p>
    </a>
</div>

<div class='col-lg-2 d-inline-block tasks-emergency'>
<a style='text-decoration:none' href='{{route('contact.index', [
				'type' => 'fornecedor',
				])}}'>
        <p class='panel-number'>
            {{$suppliersTotal}}
        </p>
        <p class='panel-text'>
            fornecedores
        </p>
    </a>
</div>
@endsection


@section('table')
<div class="row mt-5">
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width: 25%">
                NOME
            </td>
            <td   class="table-list-header" style="width: 35%">
                EMPRESA
            </td>
            <td   class="table-list-header" style="width: 25%">
                EMAIL
            </td>
            <td   class="table-list-header" style="width: 15%">
                TELEFONE
            </td>
        </tr>

        @foreach ($contacts as $contact)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <a class="white" href=" {{route('contact.show', ['contact' => $contact->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('contact.edit', ['contact' => $contact->id])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$contact->name}}
            </td>
            <td class="table-list-left">
                @if($contact->companies)
                @foreach ($contact->companies as $company)
                <a class="white" href=" {{route('company.show', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-eye'></i>
                    </button>
                </a>
                <a class="white" href=" {{route('company.edit', ['company' => $company->id])}}">
                    <button class="button-round">
                        <i class='fa fa-edit'></i>
                    </button>
                </a>
                {{$company->name}}
                <br>
                @endforeach
                @else
                Não possui
                @endif
            </td>
            <td class="table-list-left">
                {{$contact->email}}
                <a class="white" href="">
                    <button class="button-round">
                        <i class='fa fa-envelope'></i>
                    </button>
                </a>
            </td>
            <td class="table-list-right">
                {{$contact->phone}}
            </td>
        </tr>
        @endforeach
    </table>
    @endsection
    
    @section('paginate', $contacts->links())