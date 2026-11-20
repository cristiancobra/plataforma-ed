@extends('layouts.master')

@section('title', 'Detalhes do Tipo de Coleção')

@section('main')
    <h1>Detalhes do Tipo de Coleção</h1>
    <div class="mb-3">
        <strong>Nome:</strong> {{ $collectionType->name }}
    </div>
    <div class="mb-3">
        <strong>Campos dos itens:</strong>
        @forelse ($collectionType->fields as $field)
            <span class="badge bg-secondary">{{ $field->label }}</span>
        @empty
            nenhum
        @endforelse
    </div>
    <a href="{{ route('collection-types.edit', $collectionType) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('collection-types.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
