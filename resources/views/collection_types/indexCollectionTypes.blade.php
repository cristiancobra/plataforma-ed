@extends('layouts.index')

@section('title', 'Tipos de Coleção')

@section('buttons')
    <x-buttons.create model="collection-types" />
@endsection

@section('table')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->category }}</td>
                    <td>
                        <a href="{{ route('collection-types.edit', $type) }}" class="btn btn-sm text-white"
                            style="background-color: {{ $principalColor }}">Editar</a>
                        <form action="{{ route('collection-types.destroy', $type) }}" method="POST"
                            style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">Nenhum tipo cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
