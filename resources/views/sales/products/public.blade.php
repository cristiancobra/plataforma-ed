@extends('layouts/templates_shop/default')

@section('banner')
{{$shop->headline}}
@endsection


@section('name', $product->name)


@section('image')
<div class='product-image-public'>
    @if($product->image)
    <image src='{{asset($product->image->path)}}' width='80%' heigh='80%'>
    @else
    <image src='{{asset('images/products.png')}}'  width='80%' heigh='80%'>
    @endif
</div>
@endsection


@section('price', formatCurrencyReal($product->price))


@section('stock', $product->stock)


@section('due_date')
@if($product->due_date)
{{$product->due_date}}
@else
não informado
@endif
@endsection



@section('description')
{!!html_entity_decode($product->description)!!}
@endsection

