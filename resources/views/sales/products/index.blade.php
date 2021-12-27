@extends('layouts/master')

@if($variation == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

@section('image-top')
{{asset('images/products.png')}} 
@endsection

@section('buttons')
{{createButtonTrashIndex(request('trash'), 'product', $variation)}}
<a id='filter_button' class='circular-button secondary'>
    <i class='fa fa-filter' aria-hidden='true'></i>
</a>
<a class='circular-button primary'  href='{{route('product.create', ['variation' => $variation])}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endsection

@section('main')
<div class="container">
    <div class="row">
        <form id='filter' action='{{route('product.index', ['variation' => $variation])}}' method='post' style='text-align: right;display:none'>
            @csrf
            <input type='text' name='name' placeholder='nome do produto' value=''>
            {{createFilterSelect('category', 'select', $categories)}}
            {{createFilterSelect('group', 'select', $groups)}}
            {{createFilterSelect('status', 'select', $status, 'Todas as situações')}}
            <a class='button-secondary' href='{{route('product.index', ['variation' => $variation])}}'>
                LIMPAR
            </a>
            <input class='button-secondary' type='submit' value='FILTRAR'>
        </form>
    </div>
    <div class='row  table-header mt-2 mb-2' style="background-color: {{$principalColor}}">
        <div class='col-1'>
            FOTO
        </div>
        <div class='col-6'>
            NOME
        </div>
        <div class='col-1'>
            GRUPO
        </div>
        <div class='col-2'>
            ESTOQUE
        </div>
        <div class='col-1'>
            PREÇO
        </div>
        <div class='col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($products as $product)
    <div class="row table2 position-relative"  style="
         color: {{$principalColor}};
         border-left-color: {{$complementaryColor}}
         ">
        <a class="stretched-link "href="{{route('product.show', ['product' => $product->id, 'variation' => $variation])}}">
        </a>
        <div class='cel col-1'>
            <div class='product-image-small'>
                @if($product->image_id)
                <image src='{{asset($product->image->path)}}' width='100%' heigh='100%'>
                @else
                <image src='{{asset('images/products.png')}}' width='100%' heigh='100%'>
                @endif
            </div>
        </div>
        <div class='cel col-6 justify-content-start'>
            {{$product->name}}
        </div>
        <div class='cel col-1 text-center'>
            {{$product->group}}
        </div>
        <div class='cel col-2 justify-content-center'>
            {{$product->stock}}
        </div>
        @if($product->price < 0)
        <div class='cel col-1 justify-content-end' style="color:red">
            {{formatCurrencyReal($product->price)}}
        </div>
        @else
        <div class='cel col-1 justify-content-end'>
            {{formatCurrencyReal($product->price)}}
        </div>
        @endif
        {{formatTableStatus($product)}}
    </div>
    @endforeach
    <div class='row'>
        <div class='tb-footer'></div>
    </div>

    <div class='row'>
        <p style='text-align: right'>
            <br>
            {{$products->links()}}
        </p>
    </div>

    @endsection

    @section('js-scripts')
    <script>
        $(document).ready(function () {
            //botao de exibir filtro
            $('#filter_button').click(function () {
                $('#filter').slideToggle(600);
            });

        });
    </script>
    @endsection