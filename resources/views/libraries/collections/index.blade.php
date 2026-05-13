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
    <x-table.filter :action="route('collection.index')" :reset-url="route('collection.index')">
        <x-filter.input name="name" placeholder="nome do item" />
        <x-filter.input name="patrimony_number" placeholder="nº patrimônio" />
        <x-filter.input name="brand" placeholder="marca" />
        <x-filter.select name="category" :options="$categories" placeholder="Todas as categorias" />
        <x-filter.select name="type" :options="$types" placeholder="Todos os tipos" />
        <x-filter.select-user name="user_id" :users="$users" placeholder="Responsável" />
        <x-filter.input name="location" placeholder="localização" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-2'],
        ['label' => 'CATEGORIA', 'class' => 'col-1'],
        ['label' => 'TIPO', 'class' => 'col-2'],
        ['label' => 'PATRIMÔNIO', 'class' => 'col-2'],
        ['label' => 'REGISTRADO POR', 'class' => 'col-1'],
        ['label' => 'LOCALIZAÇÃO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-1'],
        ['label' => 'CONTATO', 'class' => 'col-1'],
        ['label' => 'VER', 'class' => 'col-1 text-center'],
    ]" />
    @foreach ($collections as $collection)
        <div class="row border-bottom py-2 align-items-center">
            <div class="col-2 fw-bold">
                {{ $collection->name }}
            </div>
            <div class="col-1 text-center">
                {{ $collection->category }}
            </div>
            <div class="col-2 text-center">
                {{ $collection->type }}
            </div>
            <div class="col-2 text-center">
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
