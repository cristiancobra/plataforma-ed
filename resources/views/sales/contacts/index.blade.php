@extends('layouts/index')

@section('title','CONTATOS')

@section('image-top')
{{asset('images/contact.png')}} 
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('contact.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('filter')
<form id="filter" action="{{route('contact.index')}}" method="get" style="text-align: right;display: inline">
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