@extends('layouts/index')

@section('title','CONTATOS')

@section('image-top')
{{asset('images/contact.png')}} 
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary' title='Filtrar lista'>
    <i class='fa fa-filter' aria-hidden='true'></i>
</a>
<a class='circular-button primary'  href='{{route('contact.create')}}' title='Criar novo'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('filter')
<form id='filter' action='{{route('contact.index')}}' method='get' style='text-align: right'>
    <input type='text' name='name' placeholder='nome ou sobrenome' value=''>
    {{createFilterSelect('type', 'select', $types)}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    <br>
    <a class='text-button secondary' href='{{route('contact.index')}}'>
        LIMPAR
    </a>
    <input class='text-button primary' type='submit' value='FILTRAR'>
</form>
@endsection


@section('shortcuts')
<div class='col-lg-2 d-inline-block tasks-my' style="background-color: #52004d">
    <a style='text-decoration:none' href='{{route('contact.index', [
				'type' => 'funcionário',
				])}}'>
        <p class='panel-number'>
            {{$newsTotal}}
        </p>
        <p class='panel-text'>
            novos
        </p>
    </a>
</div>
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
<div class='row mt-5'>
    <div class='tb tb-header-start col-3'>
        NOME
    </div>
    <div class='tb tb-header col-3'>
        EMPRESA
    </div>
    <div class='tb tb-header col-3'>
        EMAIL
    </div>
    <div class='tb tb-header col-2'>
        TELEFONE
    </div>
    <div class='tb tb-header-end col-1'>
        ORIGEM
    </div>
</div>

@foreach ($contacts as $contact)
<div class='row'>
    <div class='tb col-3 justify-content-start'>
        <a class='white' href=' {{route('contact.show', ['contact' => $contact->id])}}'>
            {{$contact->name}}
        </a>
    </div>
    <div class='tb col-3 justify-content-start'>
        @if($contact->companies)
        @foreach ($contact->companies as $company)
        <a class='white' href=' {{route('company.show', ['company' => $company->id])}}'>
            {{$company->name}}
        </a>
        @endforeach
        @else
        Não possui
        @endif
    </div>
    <div class='tb col-3 justify-content-start'>
        <a class='white' href='mailto:{{$contact->email}}'>
        {{$contact->email}}
        </a>
    </div>
    <div class='tb col-2'>
        {{$contact->phone}}
    </div>
    <div class='tb col-1'>
        {{$contact->lead_source}}
    </div>
</div>
@endforeach
@endsection

@section('paginate', $contacts->links())