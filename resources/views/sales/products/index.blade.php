@extends('layouts/index')

@if ($variation == 'receita')
    @section('title', 'PRODUTOS')
@else
    @section('title', 'ITENS DE DESPESA')
@endif

@section('image-top')
    <i class="fas fa-box-open"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="request('trash')" :parameter="'product'" :variation="$variation" />
    <x-buttons.create model="product" parameter="variation" :value="$variation" :principalColor="$principalColor" />
@endsection

@section('filter')
    <x-table.filter :action="route('product.index')" :reset-url="route('product.index', ['variation' => $variation])" :filters-active="$filtersActive" :total-filtered="$total"
        :total-total="$totalTotal">
        <input type="hidden" name="variation" value="{{ $variation }}">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome do produto" />
        <x-filter.select name="category" :options="$categories" placeholder="Todas as categorias" />
        @if ($variation == 'despesa')
            <x-filter.select name="group" :options="$groups" placeholder="Todos os grupos" />
        @endif
        <x-filter.select name="status" :options="$status" placeholder="Todas as situações" />
    </x-table.filter>
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'FOTO', 'class' => 'col-1'],
        ['label' => 'NOME', 'class' => 'col-5'],
        ['label' => 'GRUPO', 'class' => 'col-2'],
        ['label' => 'ESTOQUE', 'class' => 'col-1'],
        ['label' => 'PREÇO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @foreach ($products as $product)
        <div class="row row-link border-bottom align-items-center"
            data-href="{{ route('product.show', ['product' => $product->id, 'variation' => $variation]) }}">
            <div class="col-1">
                <div class="product-image-small">
                    <img src="{{ $product->image && $product->image->path ? asset($product->image->path) : asset('images/products.png') }}"
                        width="100%" height="100%" alt="{{ $product->name }}">
                </div>
            </div>
            <div class="col-5 fw-bold">
                {{ $product->name }}
            </div>
            <div class="col-2 text-center">
                {{ $product->group ?: '-' }}
            </div>
            <div class="col-1 text-center">
                {{ $product->stock }}
            </div>
            <div class="col-1 text-end" @style(['color: red' => $product->price < 0])>
                {{ formatCurrencyReal($product->price) }}
            </div>
            <div class="col-2 text-center">
                @if ($product->status == 'disponível')
                    <x-table.badge label="disponível" :colors="['#E8F5E9', '#2E7D32']" />
                @elseif ($product->status == 'indisponível')
                    <x-table.badge label="indisponível" :colors="['#FFEBEE', '#C62828']" />
                @else
                    <x-table.badge :label="$product->status" />
                @endif
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endsection
