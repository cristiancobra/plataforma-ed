@extends('layouts/index')

@section('title', 'DOMÍNIOS')

@section('image-top')
    <i class="fas fa-globe"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a class="circular-button primary" href="{{ route('site.index') }}">
        <i class="fa fa-globe" aria-hidden="true"></i>
    </a>
    <x-buttons.create model="domain" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'DOMÍNIO', 'class' => 'col-3'],
        ['label' => 'ORGANIZAÇÃO', 'class' => 'col-2'],
        ['label' => 'SITE', 'class' => 'col-2'],
        ['label' => 'PROVEDOR', 'class' => 'col-2'],
        ['label' => 'RENOVAÇÃO', 'class' => 'col-2'],
        ['label' => 'SITUAÇÃO', 'class' => 'col'],
    ]" />
    @foreach ($domains as $domain)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('domain.show', ['domain' => $domain->id]) }}">
            <div class="col-3 fw-bold small">
                <a href="{{ route('domain.edit', ['domain' => $domain->id]) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Editar" onclick="event.stopPropagation()"><i class="fa fa-edit"></i></a>
                {{ $domain->name }}
            </div>
            <div class="col-2 text-center small">{{ $domain->account->name }}</div>
            <div class="col-2 text-center small">{{ $domain->site->name ?? '-' }}</div>
            <div class="col-2 text-center small">{{ $domain->provider }}</div>
            <div class="col-2 text-center small">{{ dateBr($domain->due_date) }}</div>
            <div class="col text-center">
                <x-table.badge :label="$domain->status" :colors="$domain->status == 'ativo' ? ['#E8F5E9', '#2E7D32'] : ['#FFEBEE', '#C62828']" />
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', $domains->links())
