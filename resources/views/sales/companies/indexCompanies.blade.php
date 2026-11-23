@extends('layouts/index')

@section('title', 'ORGANIZAÇÕES')

@section('image-top')
    <i class="fa fa-building"></i>
@endsection

@section('buttons')
    <x-buttons.create model="company" parameter="typeCompanies" :value="$typeCompanies" :principalColor="$principalColor" />
@endsection

@section('filter')
    <x-table.filter :action="route('company.index')" :reset-url="route('company.index', ['typeCompanies' => $typeCompanies])"
        :filters-active="$filtersActive" :total-filtered="$total" :total-total="$totalTotal">
        <input type="hidden" name="typeCompanies" value="{{ $typeCompanies }}">
        <x-filter.input name="name" placeholder="nome" />
        <x-filter.select name="city" :options="$cities" placeholder="Todas as cidades" />
        <x-filter.select name="state" :options="$states" placeholder="Todos os estados" />
        <x-filter.select name="country" :options="$countries" placeholder="Todos os países" />
        <x-filter.select name="status" :options="$statuses" placeholder="Todas as situações" />
        <x-filter.select name="cadin_estadual" :options="$cadinOptions" placeholder="CADIN Estadual" />
        <x-filter.select name="cadin_federal" :options="$cadinOptions" placeholder="CADIN Federal" />
    </x-table.filter>
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'EMAIL', 'class' => 'col-2'],
        ['label' => 'CIDADE', 'class' => 'col-2'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ['label' => 'CADIN ESTADUAL', 'class' => 'col-1'],
        ['label' => 'CADIN FEDERAL', 'class' => 'col-1'],
        ['label' => 'CONSULTA', 'class' => 'col'],
    ]" />
    @foreach ($companies as $company)
        <div class="row row-link border-bottom align-items-center py-2" data-href="{{ route('company.show', ['company' => $company, 'typeCompanies' => $company->type]) }}">
            <div class="col-3 fw-bold">
                {{ $company->name }}
                @if ($company->cnpj)
                    <div class="small text-muted fw-normal">{{ $company->cnpj }}</div>
                @endif
            </div>
            <div class="col-2 text-center text-break small">
                {{ $company->email ?: '-' }}
            </div>
            <div class="col-2 text-center">
                {{ $company->city ?: '-' }}{{ $company->state ? ' / ' . $company->state : '' }}
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="$company->status" :colors="\App\Models\Company::statusColors($company->status)" />
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="\App\Models\Company::cadinLabel($company->cadin_estadual)"
                    :colors="\App\Models\Company::cadinColors($company->cadin_estadual)" />
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="\App\Models\Company::cadinLabel($company->cadin_federal)"
                    :colors="\App\Models\Company::cadinColors($company->cadin_federal)" />
            </div>
            <div class="col text-center small">
                {{ $company->cadin_checked_at?->format('d/m/Y') ?? '-' }}
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">
        {{ $companies->links() }}
    </div>
@endsection
