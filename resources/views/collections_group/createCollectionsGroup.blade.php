@extends('layouts.master')

@section('title', 'Novo Grupo de Acervo')

@section('main')
    <form action="{{ route('collections-group.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descrição</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn text-white" style="background-color: {{ $principalColor }}">Salvar</button>
        <a href="{{ route('collections-group.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
