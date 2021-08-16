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
@if(request('trash') == null)
<a class='circular-button delete'  href="{{route('product.filter', ['variation' => $variation, 'trash' => 1])}}">
    <i class="fa fa-trash" aria-hidden="true"></i>
</a>
@endif
<a id='filter_button' class='circular-button secondary'>
    <i class='fa fa-filter' aria-hidden='true'></i>
</a>
@if(request('trash') == 1)
<a class='circular-button secondary'  href='{{route('product.create', ['variation' => $variation])}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
{{createButtonList('product', 'variation', $variation)}}
@else
<a class='circular-button primary'  href='{{route('product.create', ['variation' => $variation])}}'>
    <i class='fa fa-plus' aria-hidden='true'></i>
</a>
@endif
@endsection

@section('main')
<form id='filter' action='{{route('product.filter', ['variation' => $variation])}}' method='post' style='text-align: right;display:none'>
    @csrf
    <input type='text' name='name' placeholder='nome do produto' value=''>
    {{createFilterSelect('category', 'select', $categories)}}
    {{createFilterSelect('group', 'select', $groups)}}
    {{createFilterSelect('status', 'select', returnProductStatus(), 'Todas as situações')}}
    <a class='button-secondary' href='{{route('product.index', ['variation' => $variation])}}'>
        LIMPAR
    </a>
    <input class='button-secondary' type='submit' value='FILTRAR'>
</form>
<br>
<div>
    <div class='row'>
        <div class='tb tb-header-start col-2'>
            FOTO
        </div>
        <div class='tb tb-header col-4'>
            NOME
        </div>
        <div class='tb tb-header col-2'>
            CATEGORIA
        </div>
        <div class='tb tb-header col-1'>
            ENTREGA
        </div>
        <div class='tb tb-header col-2'>
            PREÇO
        </div>
        <div class='tb tb-header-end col-1'>
            SITUAÇÃO
        </div>
    </div>
    @foreach ($products as $product)
    <div class='row'>
        <div class='tb col-2'>
            <div class='product-image-small'>
                <a href=' {{route('product.show', ['product' => $product->id, 'variation' => $variation])}}'>
                    @if($product->image_id)
                    <image src='{{asset($product->image->path)}}' width='100%' heigh='100%'>
                    @else
                    <image src='{{asset('images/products.png')}}' width='100%' heigh='100%'>
                    @endif
                </a>
            </div>
        </div>
        <div class='tb col-4'>
            {{$product->name}}
        </div>
        <div class='tb col-2 text-center'>
            {{$product->category}}
        </div>
        <div class='tb col-1 text-center'>
            @if ($product->due_date == 0)
            imediata
            @else
            {{$product->due_date}} dias
            @endif
        </div>
        <div class='tb col-2 text-right' style="text-align: right">
            {{formatCurrencyReal($product->price)}}
        </div>
        {{formatTableStatus($product)}}
    </div>
    @endforeach
    <div class='row'>
        <div class='tb-footer'></div>
    </div>
</div>
<br>
<br>
<br>
<p style='text-align: right'>
    <br>
    {{$products->links()}}
</p>
</div>
<br>
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