@extends('layouts/index')

@section('title', 'SITES')

@section('image-top')
    <i class="fas fa-window-maximize"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a class='circular-button primary' href='{{ route('domain.create') }}'>
        <i class='fa fa-list' aria-hidden='true'></i>
    </a>
    <a class='circular-button primary' href='{{ route('site.index') }}'>
        <i class='fa fa-plus' aria-hidden='true'></i>
    </a>
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'DOMÍNIOS', 'class' => 'col-4'],
        ['label' => 'LINKS', 'class' => 'col-3'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @foreach ($sites as $site)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('site.show', ['site' => $site->id]) }}">
            <div class="col-3 fw-bold small">
                <a href="{{ route('site.edit', ['site' => $site->id]) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Editar" onclick="event.stopPropagation()"><i class="fa fa-edit"></i></a>
                {{ $site->name }}
            </div>
            <div class="col-4 small">
                @foreach ($site->domains as $domain)
                    <a href="{{ route('domain.show', ['domain' => $domain->id]) }}" onclick="event.stopPropagation()">{{ $domain->name }}</a>@if (!$loop->last), @endif
                @endforeach
            </div>
            <div class="col-3 text-center">
                <a class="me-2" href="//{{ $site->link_view }}" target="_blank" title="Ver" onclick="event.stopPropagation()"><i class="fa fa-eye"></i></a>
                <a class="me-2" href="//{{ $site->link_edit }}" target="_blank" title="Editar" onclick="event.stopPropagation()"><i class="fa fa-edit"></i></a>
                <a href="//{{ $site->link_hosting }}" target="_blank" title="Hospedagem" onclick="event.stopPropagation()"><i class="fa fa-server"></i></a>
            </div>
            <div class="col-2 text-center">
                <x-table.badge :label="$site->status" :colors="$site->status == 'ativo' ? ['#E8F5E9', '#2E7D32'] : ['#FFEBEE', '#C62828']" />
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', $sites->links())
