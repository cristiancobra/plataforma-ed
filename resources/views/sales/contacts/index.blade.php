@extends('layouts/index')

@section('title', 'CONTATOS')

@section('image-top')
    <i class="fas fa-address-book"></i>
@endsection

@section('buttons')
    <a id='filter_button' class='circular-button secondary' title='Filtrar lista'>
        <i class='fa fa-filter' aria-hidden='true'></i>
    </a>
    <a class='circular-button primary' href='{{ route('contact.create') }}' title='Criar novo'>
        <i class='fa fa-plus' aria-hidden='true'></i>
    </a>
@endsection

@section('filter')
    <form id='filter' action='{{ route('contact.index') }}' method='get' style='text-align: right'>
        <input type='text' name='name' placeholder='nome ou sobrenome' value=''>
        {{ createFilterSelect('type', 'select', $types) }}
        {{ createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas') }}
        <br>
        <a class='text-button secondary' href='{{ route('contact.index') }}'>
            LIMPAR
        </a>
        <input class='text-button primary' type='submit' value='FILTRAR'>
    </form>
@endsection


@section('shortcuts')
    <div class='col-lg-2 d-inline-block tasks-my' style="background-color: #52004d">
        <a style='text-decoration:none' href='{{ route('contact.index', [
            'filter' => 'news',
        ]) }}'>
            <p class='panel-number'>
                {{ $newsTotal }}
            </p>
            <p class='panel-text'>
                novos
            </p>
        </a>
    </div>
    <div class='col-lg-2 d-inline-block tasks-my'>
        <a style='text-decoration:none'
            href='{{ route('contact.index', [
                'type' => 'equipe',
            ]) }}'>
            <p class='panel-number'>
                {{ $employessTotal }}
            </p>
            <p class='panel-text'>
                funcionários
            </p>
        </a>
    </div>
    <div class='col-lg-2 d-inline-block tasks-toDo'>
        <a style='text-decoration:none' href='{{ route('contact.index', [
            'type' => 'parceiro',
        ]) }}'>
            <p class='panel-number'>
                {{ $partnersTotal }}
            </p>
            <p class='panel-text'>
                parceiros
            </p>
        </a>
    </div>
    <div class='col-lg-2 d-inline-block tasks-now'>
        <a style='text-decoration:none' href='{{ route('contact.index', [
            'type' => 'cliente',
        ]) }}'>
            <p class='panel-number'>
                {{ $clientsTotal }}
            </p>
            <p class='panel-text'>
                clientes
            </p>
        </a>
    </div>

    <div class='col-lg-2 d-inline-block tasks-emergency'>
        <a style='text-decoration:none'
            href='{{ route('contact.index', [
                'type' => 'fornecedor',
            ]) }}'>
            <p class='panel-number'>
                {{ $suppliersTotal }}
            </p>
            <p class='panel-text'>
                fornecedores
            </p>
        </a>
    </div>
@endsection


@section('table')
    <style>
        .table-contacts-header {
            background-color: {{ $principalColor }};
            color: white;
            font-weight: 600;
            padding: 15px;
            border-radius: 5px 5px 0 0;
        }

        .table-contacts-row {
            background-color: white;
            transition: all 0.2s ease;
            border-bottom: 1px solid #e0e0e0;
        }

        .table-contacts-row:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }

        .table-contacts-cell {
            padding: 12px 15px;
        }
    </style>

    <div class='card shadow-sm mt-5'>
        <div class='row g-0 table-contacts-header'>
            <div class='col-3 table-contacts-cell'>
                <i class="fas fa-user me-2"></i>NOME
            </div>
            <div class='col-3 table-contacts-cell'>
                <i class="fas fa-building me-2"></i>ORGANIZAÇÃO
            </div>
            <div class='col-3 table-contacts-cell'>
                <i class="fas fa-envelope me-2"></i>EMAIL
            </div>
            <div class='col-2 table-contacts-cell'>
                <i class="fas fa-phone me-2"></i>TELEFONE
            </div>
            <div class='col-1 table-contacts-cell'>
                <i class="fas fa-tag me-1"></i>ORIGEM
            </div>
        </div>

        @foreach ($contacts as $contact)
            <div class='row g-0 table-contacts-row'>
                <div class='col-3 table-contacts-cell'>
                    <a href='{{ route('contact.show', ['contact' => $contact->id]) }}'
                        style='text-decoration: none; color: {{ $principalColor }}; font-weight: 500;'>
                        {{ $contact->name }}
                    </a>
                </div>
                <div class='col-3 table-contacts-cell'>
                    @if ($contact->companies && count($contact->companies) > 0)
                        @foreach ($contact->companies as $company)
                            <a href='{{ route('company.show', ['company' => $company->id]) }}'
                                style='text-decoration: none; color: #6c757d;'>
                                {{ $company->name }}
                            </a>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    @else
                        <span class='text-muted'>—</span>
                    @endif
                </div>
                <div class='col-3 table-contacts-cell'>
                    @if ($contact->email)
                        <a href='mailto:{{ $contact->email }}' style='text-decoration: none; color: #6c757d;'>
                            {{ $contact->email }}
                        </a>
                    @else
                        <span class='text-muted'>—</span>
                    @endif
                </div>
                <div class='col-2 table-contacts-cell text-muted'>
                    {{ $contact->phone ?? '—' }}
                </div>
                <div class='col-1 table-contacts-cell'>
                    @if ($contact->lead_source)
                        <span class='badge' style='background-color: {{ $complementaryColor }}; color: white;'>
                            {{ $contact->lead_source }}
                        </span>
                    @else
                        <span class='text-muted'>—</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('paginate', $contacts->links())
