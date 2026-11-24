@extends('layouts.index')

@section('title', 'Tipos de Coleção')

@section('buttons')
    <x-buttons.create model="collection-types" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'CATEGORIA', 'class' => 'col-2'],
        ['label' => 'CAMPOS DOS ITENS', 'class' => 'col-4'],
        ['label' => 'AÇÕES', 'class' => 'col-3 text-center'],
    ]" />

    @forelse($types as $type)
        <div class="row border-bottom align-items-center py-2">
            <div class="col-3 fw-bold">
                {{ $type->name }}
            </div>
            <div class="col-2 text-center">
                {{ $type->category }}
            </div>
            <div class="col-4">
                @forelse ($type->fields as $field)
                    <x-custom-fields.pill :field="$field" />
                @empty
                    <span class="text-muted">-</span>
                @endforelse
            </div>
            <div class="col-3 text-center d-flex gap-2 justify-content-center">
                <a href="{{ route('collection-types.edit', $type) }}" class="btn btn-sm text-white me-2"
                    style="background-color: {{ $principalColor }}">Editar</a>
                <x-buttons.delete :action="route('collection-types.destroy', $type)" />
            </div>
        </div>
    @empty
        <div class="row">
            <div class="col text-center py-3">
                Nenhum tipo cadastrado.
            </div>
        </div>
    @endforelse
@endsection
