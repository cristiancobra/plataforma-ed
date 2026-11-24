@extends('layouts/index')

@section('title', 'IMAGENS')

@section('image-top')
    <i class="fas fa-image"></i>
@endsection


@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'image'" />
    <x-buttons.create model="image" :principalColor="$principalColor" />
@endsection

@section('filter')
    <x-table.filter :action="route('image.index')" :reset-url="route('image.index')" :filters-active="$filtersActive" :total-filtered="$images->total()" :total-total="$totalTotal">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome da imagem" />
        <x-filter.select name="type" :options="$types" placeholder="Todos os tipos" />
        <x-filter.select name="user_id" :options="$users->mapWithKeys(fn ($u) => [$u->id => optional($u->contact)->name])->all()" placeholder="Todos os usuários" />
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'IMAGEM', 'class' => 'col-1'],
        ['label' => 'NOME', 'class' => 'col-5'],
        ['label' => 'TIPO', 'class' => 'col-2'],
        ['label' => 'ENVIADO POR', 'class' => 'col-2'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @foreach ($images as $image)
        <div class="row row-link border-bottom align-items-center py-2" data-href="{{ route('image.show', ['image' => $image->id]) }}">
            <div class="col-1">
                <div class="product-image-small">
                    <img src="{{ asset('storage/' . $image->path) }}" width="100%" height="100%" alt="{{ $image->name }}">
                </div>
            </div>
            <div class="col-5 fw-bold small">
                {{ $image->name }}
            </div>
            <div class="col-2 text-center">
                <x-table.badge :label="$image->type" />
            </div>
            <div class="col-2 text-center">
                @if ($image->contact)
                    <a href="{{ route('contact.show', ['contact' => $image->contact->id]) }}" title="Ver contato">
                        {{ $image->contact->name }}
                    </a>
                @else
                    <x-user.avatar :user="$image->user" :principal-color="$principalColor" />
                @endif
            </div>
            <div class="col-2 text-center">
                @if ($image->status == 'disponível')
                    <x-table.badge label="disponível" :colors="['#E8F5E9', '#2E7D32']" />
                @elseif ($image->status == 'indisponível')
                    <x-table.badge label="indisponível" :colors="['#FFEBEE', '#C62828']" />
                @else
                    <x-table.badge :label="$image->status" />
                @endif
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    {{ $images->appends(request()->query())->links() }}
@endsection
