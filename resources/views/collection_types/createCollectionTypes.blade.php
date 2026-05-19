@extends('layouts.master')

@section('title', 'Novo Tipo de Coleção')

@section('main')
    <form action="{{ route('collection-types.store') }}" method="POST">
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
            <label for="category" class="form-label">Categoria</label>
            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="físico" {{ old('category') == 'físico' ? 'selected' : '' }}>Físico</option>
                <option value="digital" {{ old('category') == 'digital' ? 'selected' : '' }}>Digital</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn text-white" style="background-color: {{ $principalColor }}">Salvar</button>
        <a href="{{ route('collection-types.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
