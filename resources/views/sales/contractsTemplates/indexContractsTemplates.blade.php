@extends('layouts/index')

@section('title', 'MODELOS DE CONTRATOS')

@section('image-top')
    <i class="fas fa-file-signature"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a class="circular-button primary" href="{{ route('contract.index') }}">
        VER CONTRATOS
    </a>
    <x-buttons.create model="contractTemplate" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'TÍTULO', 'class' => 'col-9'],
        ['label' => 'ÚLTIMA ALTERAÇÃO', 'class' => 'col-3'],
    ]" />
    @foreach ($contractsTemplates as $contractTemplate)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('contractTemplate.show', ['contractTemplate' => $contractTemplate->id]) }}">
            <div class="col-9 fw-bold small">
                <a href="{{ route('contractTemplate.edit', ['contractTemplate' => $contractTemplate->id]) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Editar" onclick="event.stopPropagation()"><i class="fa fa-edit"></i></a>
                {{ $contractTemplate->name }}
            </div>
            <div class="col-3 text-center small">{{ $contractTemplate->updated_at }}</div>
        </div>
    @endforeach
@endsection

@section('paginate', $contractsTemplates->links())
