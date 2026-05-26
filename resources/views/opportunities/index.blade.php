@extends('layouts/index')

@section('title', $title)

@section('image-top')
    <i class="fa fa-bullseye"></i>
@endsection

@section('buttons')
    <x-buttons.filter />
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'opportunity'" />

    <x-buttons.create model="opportunity" parameter="department" :value="$department" />
@endsection



@section('filter')
    <x-table.filter :action="route('opportunity.index')" :reset-url="route('opportunity.index')" :filters-active="$filtersActive" :total-filtered="$totalFiltered" :total-total="$totalTotal">
        <x-filter.input name="name" placeholder="nome da oportunidade" />
        <x-filter.select name="contact_id" :options="$contactSelectOptions" placeholder="Todos os contatos" />
        <x-filter.select name="company_id" :options="$companiesSelectOptions" placeholder="Todas as empresas" />
        <x-filter.select name="user_id" :options="$userSelectOptions" placeholder="Registrado por" />
        <x-filter.select name="stage" :options="$stagesSelectOptions" placeholder="Todas as etapas" />
        <x-filter.select name="status" :options="$statusSelectOptions" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('shortcuts')
    @if ($department == 'desenvolvimento')
    @else
        <div class='col shortcut prospecting'>
            <a style='text-decoration:none'
                href='{{ route('opportunity.index', [
                    'stage' => 'prospecção',
                    'status' => 'ativo',
                ]) }}'>
                <h2>
                    {{ $totalProspection }}
                </h2>
                <h3>
                    prospecções
                </h3>
            </a>
        </div>
        <div class='col shortcut presentation'>
            <a style='text-decoration:none'
                href='{{ route('opportunity.index', [
                    'stage' => 'apresentação',
                    'status' => 'ativo',
                ]) }}'>
                <h2>
                    {{ $totalPresentation }}
                </h2>
                <h3>
                    apresentações
                </h3>
            </a>
        </div>

        <div class='col shortcut proposal'>
            <a style='text-decoration:none'
                href='{{ route('opportunity.index', [
                    'stage' => 'proposta',
                    'status' => 'ativo',
                ]) }}'>
                <h2>
                    {{ $totalProposal }}
                </h2>
                <h3>
                    propostas
                </h3>
            </a>
        </div>

        <div class='col shortcut contract'>
            <a style='text-decoration:none'
                href='{{ route('opportunity.index', [
                    'stage' => 'contrato',
                    'status' => 'ativo',
                ]) }}'>
                <h2>
                    {{ $totalContract }}
                </h2>
                <h3>
                    contratos
                </h3>
            </a>
        </div>

        <div class='col shortcut bill'>
            <a style='text-decoration:none'
                href='{{ route('opportunity.index', [
                    'stage' => 'cobrança',
                    'status' => 'ativo',
                ]) }}'>
                <h2>
                    {{ $totalBill }}
                </h2>
                <h3>
                    cobrança
                </h3>
            </a>
        </div>

        <div class='col shortcut production'>
            <a style='text-decoration:none'
                href='{{ route('opportunity.index', [
                    'stage' => 'produção',
                    'status' => 'ativo',
                ]) }}'>
                <h2>
                    {{ $totalProduction }}
                </h2>
                <h3>
                    produção
                </h3>
            </a>
        </div>
    @endif
@endsection



@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'CONTATO', 'class' => 'col-2'],
        ['label' => 'ORGANIZAÇÃO', 'class' => 'col-2'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-1'],
        ['label' => 'PRAZO', 'class' => 'col-1'],
        ['label' => 'ETAPA DA VENDA', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ['label' => 'VER', 'class' => 'col-1'],
    ]" />
    @foreach ($opportunities as $opportunity)
        <div class="row border-bottom py-2 align-items-center">
            <div class="col-3 fw-bold">
                {{ $opportunity->name }}
            </div>
            <div class="col-2">
                @if (isset($opportunity->contact->name))
                    {{ $opportunity->contact->name }}
                @else
                    Não possui
                @endif
            </div>
            <div class="col-2">
                @if (isset($opportunity->company->name))
                    {{ $opportunity->company->name }}
                @else
                    Pessoa física
                @endif
            </div>
            <div class="col-1 text-center">
                <x-user.avatar :user="$opportunity->user" />
            </div>
            <div class="col-1 text-center">
                {{ dateBr($opportunity->date_due) }}
            </div>
            <div class="col-1 text-center">
                {{ formatStage($opportunity) }}
            </div>
            <div class="col-1 text-center">
                {{ formatStatus($opportunity) }}
            </div>
            <div class="col-1 text-center">
                <x-buttons.details :href="route('opportunity.show', ['opportunity' => $opportunity->id])" title="Visualizar oportunidade" color="primary" :size="32" />
            </div>
        </div>
    @endforeach
@endsection


@section('paginate', $opportunities->links())


@section('js-scripts')
@endsection
