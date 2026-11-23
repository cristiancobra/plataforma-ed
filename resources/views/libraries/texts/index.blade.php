@extends('layouts/index')

@section('title', 'DOCUMENTOS')

@section('image-top')
    <i class="fa fa-file"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'text'" />
    <x-buttons.create model="text" />
@endsection


@section('filter')
    <x-table.filter :action="route('text.index')" :reset-url="route('text.index')" :filters-active="$filtersActive" :total-filtered="$texts->total()" :total-total="$totalTotal">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome ou título" />
        <x-filter.select name="type" :options="$types" placeholder="Todos os tipos" />
        <x-filter.select name="department" :options="$departments" placeholder="Todos os departamentos" />
        <x-filter.select name="user_id" :options="$users->mapWithKeys(fn ($u) => [$u->id => optional($u->contact)->name])->all()" placeholder="Todos os usuários" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('table')
    @php
        $statusColors = [
            'rascunho' => ['#FFF8E1', '#F57F17'],
            'revisão' => ['#E3F2FD', '#1565C0'],
            'aprovada' => ['#E8F5E9', '#2E7D32'],
            'desativada' => ['#ECEFF1', '#546E7A'],
        ];
        $businessModel = [
            ['label' => 'PROPOSTA DE VALOR', 'texts' => $valueOffer ? collect([$valueOffer]) : collect(), 'type' => 'proposta de valor', 'multiple' => false],
            ['label' => 'APRESENTAÇÃO DA EMPRESA', 'texts' => $about ? collect([$about]) : collect(), 'type' => 'apresentação da empresa', 'multiple' => false],
            ['label' => 'PONTOS FORTES', 'texts' => $strengths, 'type' => 'força', 'multiple' => true],
        ];
    @endphp

    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'MODELO DE NEGÓCIO', 'class' => 'col-3'],
        ['label' => 'TEXTO', 'class' => 'col-7'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @foreach ($businessModel as $item)
        @forelse ($item['texts'] as $text)
            <div class="row row-link border-bottom align-items-center py-2" data-href="{{ route('text.edit', ['text' => $text]) }}">
                <div class="col-3 fw-bold">
                    @if ($loop->first)
                        {{ $item['label'] }}
                    @endif
                </div>
                <div class="col-7 small">
                    {{ $text->text }}
                </div>
                <div class="col-2 text-center">
                    <x-table.badge :label="$text->status" :colors="$statusColors[$text->status] ?? null" />
                </div>
            </div>
            @if ($item['multiple'] && $loop->last)
                <div class="row border-bottom align-items-center py-2">
                    <div class="col-3"></div>
                    <div class="col-9">
                        <a href="{{ route('text.create', ['type' => $item['type']]) }}" class="small">
                            <i class="fa fa-plus me-1"></i>adicionar
                        </a>
                    </div>
                </div>
            @endif
        @empty
            <div class="row row-link border-bottom align-items-center py-2" data-href="{{ route('text.create', ['type' => $item['type']]) }}">
                <div class="col-3 fw-bold">
                    {{ $item['label'] }}
                </div>
                <div class="col-7 small text-muted">
                    não possui — <i class="fa fa-plus"></i> criar
                </div>
                <div class="col-2 text-center">
                    <x-table.badge />
                </div>
            </div>
        @endforelse
    @endforeach

    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-4'],
        ['label' => 'TÍTULO', 'class' => 'col-3'],
        ['label' => 'DEPARTAMENTO', 'class' => 'col-1'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-1'],
        ['label' => 'TIPO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @foreach ($texts as $text)
        <div class="row row-link border-bottom align-items-center py-2" data-href="{{ route('text.show', ['text' => $text]) }}">
            <div class="col-4 fw-bold small">
                {{ $text->name }}
            </div>
            <div class="col-3 text-center small">
                {{ $text->title ?: '-' }}
            </div>
            <div class="col-1 text-center small">
                {{ $text->department ?: '-' }}
            </div>
            <div class="col-1 text-center">
                <x-user.avatar :user="$text->user" :principal-color="$principalColor" />
            </div>
            <div class="col-1 text-center">
                <x-table.badge :label="$text->type" />
            </div>
            <div class="col-2 text-center">
                <x-table.badge :label="$text->status" :colors="$statusColors[$text->status] ?? null" />
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    {{ $texts->appends(request()->query())->links() }}
@endsection
