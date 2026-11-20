@extends('layouts.index')

@section('title', 'CAMPOS DO ACERVO')

@section('image-top')
    <i class="fas fa-sliders-h"></i>
@endsection

@section('buttons')
    <x-buttons.create model="collection-field" title="Novo campo" :principalColor="$principalColor" />
@endsection

@section('table')
    <p class="text-muted">
        Campos extras que aparecem no cadastro dos itens de acervo. Um campo pode valer para todos os itens
        ou só para um tipo de acervo. Desativar um campo esconde ele dos formulários, mas mantém os valores já
        preenchidos.
    </p>

    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'ORDEM', 'class' => 'col-1 text-center'],
        ['label' => 'CAMPO', 'class' => 'col-3'],
        ['label' => 'TIPO DO CAMPO', 'class' => 'col-2 text-center'],
        ['label' => 'VALE PARA', 'class' => 'col-2 text-center'],
        ['label' => 'OBRIGATÓRIO', 'class' => 'col-1 text-center'],
        ['label' => 'AÇÕES', 'class' => 'col-3 text-center'],
    ]" />

    @forelse($fields as $field)
        <div class="row border-bottom align-items-center py-2 {{ $field->active ? '' : 'text-muted' }}"
            @if (!$field->active) style="opacity: .6" @endif>
            <div class="col-1 text-center">{{ $field->position }}</div>
            <div class="col-3 fw-bold">
                {{ $field->label }}
                @if (!$field->active)
                    <span class="badge bg-secondary ms-1">desativado</span>
                @endif
                @if ($field->type === \App\Enums\CustomFieldType::Select)
                    <div class="small fw-normal text-muted">{{ implode(', ', $field->options ?? []) }}</div>
                @endif
            </div>
            <div class="col-2 text-center">{{ $field->type->label() }}</div>
            <div class="col-2 text-center">{{ $field->collectionType->name ?? 'Todos os tipos' }}</div>
            <div class="col-1 text-center">{{ $field->required ? 'Sim' : 'Não' }}</div>
            <div class="col-3 text-center d-flex gap-2 justify-content-center">
                <a href="{{ route('collection-field.edit', $field) }}" class="btn btn-sm text-white"
                    style="background-color: {{ $principalColor }}">Editar</a>
                @if ($field->active)
                    <form action="{{ route('collection-field.destroy', $field) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                            data-confirm='Desativar o campo "{{ $field->label }}"? Os valores já preenchidos serão mantidos.'
                            onclick="return confirm(this.dataset.confirm)">Desativar</button>
                    </form>
                @else
                    <form action="{{ route('collection-field.activate', $field) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Reativar</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="row">
            <div class="col text-center py-3">
                Nenhum campo personalizado cadastrado.
            </div>
        </div>
    @endforelse
@endsection
