@extends('layouts.index')

@section('title', 'Grupos de Acervo')

@section('buttons')
    <x-buttons.create model="collections-group" />
@endsection

@section('table')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-4'],
        ['label' => 'DESCRIÇÃO', 'class' => 'col-6'],
        ['label' => 'AÇÕES', 'class' => 'col-2 text-center'],
    ]" />

    @forelse($groups as $group)
        <div class="row border-bottom align-items-center py-2">
            <div class="col-4 fw-bold">
                {{ $group->name }}
            </div>
            <div class="col-6 text-start">
                {{ $group->description }}
            </div>
            <div class="col-2 text-center d-flex gap-2 justify-content-center">
                <a href="{{ route('collections-group.edit', $group) }}" class="btn btn-sm text-white me-2"
                    style="background-color: {{ $principalColor }}">Editar</a>
                <form action="{{ route('collections-group.destroy', $group) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('Tem certeza?')">Excluir</button>
                </form>
            </div>
        </div>
    @empty
        <div class="row">
            <div class="col text-center py-3">
                Nenhum grupo cadastrado.
            </div>
        </div>
    @endforelse
@endsection
