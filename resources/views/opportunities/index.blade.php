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
    @if ($department != 'desenvolvimento')
        <x-shortcut :href="route('opportunity.index', ['stage' => 'prospecção', 'status' => 'ativo'])" :number="$totalProspection" label="prospecções" />
        <x-shortcut :href="route('opportunity.index', ['stage' => 'apresentação', 'status' => 'ativo'])" :number="$totalPresentation" label="apresentações" />
        <x-shortcut :href="route('opportunity.index', ['stage' => 'proposta', 'status' => 'ativo'])" :number="$totalProposal" label="propostas" />
        <x-shortcut :href="route('opportunity.index', ['stage' => 'contrato', 'status' => 'ativo'])" :number="$totalContract" label="contratos" />
        <x-shortcut :href="route('opportunity.index', ['stage' => 'cobrança', 'status' => 'ativo'])" :number="$totalBill" label="cobrança" />
        <x-shortcut :href="route('opportunity.index', ['stage' => 'produção', 'status' => 'ativo'])" :number="$totalProduction" label="produção" />
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
        ['label' => 'SITUAÇÃO', 'class' => 'col'],
    ]" />
    @php
        $stageColors = App\Models\Opportunity::stageColors();
        $statusColors = App\Models\Opportunity::statusColors();
    @endphp
    @foreach ($opportunities as $opportunity)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('opportunity.show', ['opportunity' => $opportunity->id]) }}">
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
                @if (strtotime($opportunity->date_due) > 0)
                    {{ dateBr($opportunity->date_due) }}
                @else
                    indefinido
                @endif
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="$opportunity->stage" :colors="$stageColors[$opportunity->stage] ?? null" />
            </div>
            <div class="col text-center">
                <x-table.badge :label="$opportunity->status" :colors="$statusColors[$opportunity->status] ?? null" />
            </div>
        </div>
    @endforeach
@endsection


@section('paginate', $opportunities->links())


@section('js-scripts')
@endsection
