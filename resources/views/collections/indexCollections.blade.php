@extends('layouts/index')

@section('title', 'ACERVO')

@section('image-top')
    <i class="fa fa-archive"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'collection'" />
    <x-buttons.create model="collection" />
@endsection


@section('filter')

    <x-table.filter :action="route('collection.index')" :reset-url="route('collection.index')" :filters-active="$filtersActive" :total-filtered="$totalFiltered" :total-total="$totalTotal">
        <x-filter.input name="name" placeholder="nome do item" />
        <x-filter.input name="patrimony_number" placeholder="nº patrimônio" />
        <x-filter.input name="brand" placeholder="marca" />
        <x-filter.input name="location" placeholder="localização" />
        <x-filter.select name="category" :options="$categorySelectOptions" placeholder="Todas as categorias" />
        <x-filter.select name="type" :options="$typeSelectOptions" placeholder="Todos os tipos" />
        <x-filter.select name="user_id" :options="$userSelectOptions" placeholder="Registrado por" />
        <x-filter.select name="contact_id" :options="$contactsSelectOptions" placeholder="Todos os responsáveis" />
        <x-filter.select name="collections_group_id" :options="$collectionsGroupSelectOptions" placeholder="Todos os acervos" />
        <x-filter.select name="status" :options="$statusSelectOptions" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-2'],
        ['label' => 'ACERVO', 'class' => 'col-2'],
        ['label' => 'CATEGORIA', 'class' => 'col-1'],
        ['label' => 'TIPO', 'class' => 'col-1'],
        ['label' => 'PATRIMÔNIO', 'class' => 'col-1'],
        ['label' => 'REGISTRADO POR', 'class' => 'col-1'],
        ['label' => 'LOCALIZAÇÃO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-1'],
        ['label' => 'VER', 'class' => 'col-1'],
    ]" />
    @foreach ($collections as $collection)
        <div class="row border-bottom align-items-center">
            <div class="col-2 fw-bold">
                {{ $collection->name }}
            </div>
            <div class="col-2 text-center">
                {{ $collection->collectionsGroup->name ?? '-' }}
            </div>
            <div class="col-1 text-center">
                {{ optional($collection->collectionType)->category ?? '-' }}
            </div>
            <div class="col-1 text-center">
                {{ optional($collection->collectionType)->name ?? '-' }}
            </div>
            <div class="col-1 text-center">
                {{ $collection->patrimony_number ?? '-' }}
            </div>
            <div class="col-1 text-center">
                <x-user.avatar :user="$collection->user" :principal-color="$principalColor" />
            </div>
            <div class="col-1 text-start">
                {{ $collection->currentLocation->location ?? '-' }}
            </div>
            <div class="col-1">
                @switch($collection->status)
                    @case('available')
                        <span class="badge bg-success">Disponível</span>
                    @break

                    @case('in use')
                        <span class="badge bg-primary">Em Uso</span>
                    @break

                    @case('maintenance')
                        <span class="badge bg-warning text-dark">Manutenção</span>
                    @break

                    @case('discarded')
                        <span class="badge bg-secondary">Descartado</span>
                    @break

                    @default
                        {{ $collection->status }}
                @endswitch
            </div>
            <div class="col-1 text-center">
                @if ($collection->contact)
                    <a href="{{ route('contact.show', ['contact' => $collection->contact->id]) }}" title="Ver contato">
                        {{ $collection->contact->name }}
                    </a>
                @else
                    -
                @endif
            </div>
            <div class="col-1 text-center">
                <x-buttons.details :href="route('collection.show', ['collection' => $collection->id])" title="Visualizar acervo" :color="$principalColor" :size="32" />
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    {{ $collections->appends(request()->query())->links() }}
@endsection
