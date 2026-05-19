@extends('layouts.master')

@section('title', 'Detalhes do Tipo de Coleção')

@section('main')
    <h1>Detalhes do Tipo de Coleção</h1>
    <div class="mb-3">
        <strong>Nome:</strong> {{ $collectionType->name }}
    </div>
    <a href="{{ route('collection-types.edit', $collectionType) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('collection-types.indexCollectionTypes') }}" class="btn btn-secondary">Voltar</a>
@endsection
