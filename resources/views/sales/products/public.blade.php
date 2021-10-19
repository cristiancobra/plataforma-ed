@extends('layouts/templates_shop/default')



@section('fieldsId')
<div class='col-lg-4 col-xs-6' style='text-align: center'>
    <div class='product-image'>
        @if($product->image)
        <image src='{{asset($product->image->path)}}' width='100%' heigh='100%'>
        @else
        <image src='{{asset('images/products.png')}}'  width='100%' heigh='100%'>
        @endif
    </div>
    @if($product->cnae)
    <br>
    <div class='show-label text-center col-12'>
        CNAE:  {{$product->cnae}}
    </div>
    @endif
</div>
<div class='col-lg-3 col-xs-6' style='text-align: center'>
    <div class='show-label'>
        PREÇO
    </div>
    @if($product->initial_stock)
    <div class='show-label'>
        ESTOQUE
    </div>
    @endif
    <div class='show-label mt-5'>
        PRODUÇÃO
    </div>
    @if($product->category == 'serviço')
    <div class='show-label'>
        PONTOS FUNCIONAIS
    </div>
    @endif
    <div class='show-label'>
        PRAZO DE ENTREGA
    </div>
    @if($variation == 'despesa')
    <div class='show-label mt-5'>
        GRUPO
    </div>
    @endif
</div>
<div class='col-lg-3 col-xs-6' style='text-align: center'>
    <div class='show-field-start'>
        @if($variation == 'despesa')
        valor de compra
        @else
        valor de venda
        @endif
    </div>
    @if($product->initial_stock)
    <div class='show-field-start'>
        situação atual
    </div>
    @endif
    <div class='show-field-start mt-5'>
        em horas
    </div>
    @if($product->category == 'serviço')
    <div class='show-field-start'>
        pontos para cada função de projeto
    </div>
    @endif
    <div class='show-field-start'>
        estimativa
    </div>
    @if($variation == 'despesa')
    <div class='show-field-start mt-5'>
        classificação para gerar relatório
    </div>
    @endif
</div>
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    @if($variation == 'despesa')
    <div class='show-field-end text-end' style='color:red'>
        {{formatCurrencyReal($product->price)}}
    </div>
    @else
    <div class='show-field-end text-end'>
        {{formatCurrencyReal($product->price)}}
    </div>
    @endif
    @if($product->initial_stock)
    <div class='show-field-end text-end'>
        11
    </div>
    @endif
    <div class='show-field-end text-end mt-5'>
        @if($product->work_hours)
        {{$product->work_hours}}
        @else
        não informado
        @endif
    </div>
    @if($product->category == 'serviço')
    <div class='show-field-end text-end'>
                @if($product->points)
        {{$product->points}}
        @else
        0
        @endif
    </div>
    @endif
    <div class='show-field-end text-end'>
        @if($product->due_date)
        {{$product->due_date}}
        @else
        não informado
        @endif
    </div>
    @if($variation == 'despesa')
    <div class='show-field-end text-end mt-5'>
        {{$product->group}}
    </div>
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