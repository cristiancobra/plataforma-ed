@extends('layouts/templates_shop/default')

@section('product_name', $product->name)

@section('image')
<div class='product-image-public'>
    @if($product->image)
    <image src='{{asset($product->image->path)}}' width='100%' heigh='100%'>
    @else
    <image src='{{asset('images/products.png')}}'  width='100%' heigh='100%'>
    @endif
</div>
@endsection

@section('fields')
    <div class='show-field-end text-end'>
        {{formatCurrencyReal($product->price)}}
    </div>
    @if($product->initial_stock)
    <div class='show-field-end text-end'>
        11
    </div>
    @endif
    <div class='show-field-end text-end'>
        @if($product->due_date)
        {{$product->due_date}}
        @else
        não informado
        @endif
    </div>
@endsection


@if($product->type == 'produto')
@section('stock')
<div class='row'>
    <div class='show-field-start'>
        Quantidade em estoque
    </div>
    <div class='show-field-end text-end'>
        10
    </div>
</div>
@endsection
@endif

@section('description')
{!!html_entity_decode($product->description)!!}
@endsection


@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($product->created_at))}}
    </div>
</div>
@endsection