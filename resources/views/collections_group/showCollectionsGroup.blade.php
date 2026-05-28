@extends('layouts.master')

@section('title', 'Detalhes do Grupo de Acervo')

@section('main')
    <h1>Detalhes do Grupo de Acervo</h1>
    <div class="mb-3">
        <strong>Nome:</strong> {{ $collections_group->name }}
    </div>
    <div class="mb-3">
        <strong>Descrição:</strong> {{ $collections_group->description }}
    </div>
    <a href="{{ route('collections-group.edit', $collections_group) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('collections-group.index') }}" class="btn btn-secondary">Voltar</a>
@endsection
