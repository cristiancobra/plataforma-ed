@extends('layouts.master')

@section('title', 'Editar Tipo de Coleção')

@section('main')
    <form action="{{ route('collection-types.update', $collectionType) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $collectionType->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoria</label>
            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                <option value="" selected disabled>Selecione...</option>
                <option value="físico" {{ old('category', $collectionType->category) == 'físico' ? 'selected' : '' }}>Físico
                </option>
                <option value="digital" {{ old('category', $collectionType->category) == 'digital' ? 'selected' : '' }}>
                    Digital</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn text-white" style="background-color: {{ $principalColor }}">Atualizar</button>
        <a href="{{ route('collection-types.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
