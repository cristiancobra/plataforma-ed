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
            <x-custom-fields.pill :field="$field" />
        @empty
            nenhum
        @endforelse
    </div>
    @if ($globalFields->isNotEmpty())
        <div class="mb-3">
            <strong>Campos gerais (todos os tipos):</strong>
            @foreach ($globalFields as $field)
                <x-custom-fields.pill :field="$field" />
            @endforeach
        </div>
    @endif
    <a href="{{ route('collection-types.edit', $collectionType) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('collection-types.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
