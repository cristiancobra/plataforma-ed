@extends('layouts/show')

@if($variation == 'receita')
@section('title','PRODUTOS')
@else
@section('title','ITENS DE DESPESA')
@endif

@section('image-top')
{{asset('images/products.png')}} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonTrash($product, 'product')}}
{{createButtonEdit('product', 'product', $product, 'variation', $variation)}}
{{createButtonList('product', 'variation', $variation)}}
@endsection

@section('name', $product->name)

@section('priority')
{{formatShowCategory($product)}}
@endsection


@section('status')
@if($product->status == 'fazer' AND $product->journeys()->exists())
<div class="doing">
    fazendo
</div>
@else
{{formatShowStatus($product)}}
@endif
@endsection


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
    <div class='show-label'>
        ESTOQUE
    </div>
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
    <div class='show-label mt-5'>
        GRUPO
    </div>
</div>
<div class='col-lg-3 col-xs-6' style='text-align: center'>
    <div class='show-field-start'>
        valor de venda
    </div>
    <div class='show-field-start'>
        situação atual
    </div>
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
    <div class='show-field-start mt-5'>
        classificação para gerar relatório
    </div>
</div>
<div class='col-lg-2 col-xs-6' style='text-align: center'>
    <div class='show-field-end text-end'>
        {{formatCurrencyReal($product->price)}}
    </div>
    <div class='show-field-end text-end'>
        11
    </div>
    <div class='show-field-end text-end mt-5'>
        @if($product->work_hours)
        {{$product->work_hours}}
        @else
        não informado
        @endif
    </div>
    @if($product->category == 'serviço')
    <div class='show-field-end text-end'>
        {{$product->points}}
    </div>
    @endif
    <div class='show-field-end text-end'>
        @if($product->due_date)
        {{$product->due_date}}
        @else
        não informado
        @endif
    </div>
    <div class='show-field-end text-end mt-5'>
        {{$product->group}}
    </div>
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

@section('main')
<div class='row'>
    <div class='col-lg-3 col-xs-6' style='text-align: center'>
        <div class='show-label'>
            CUSTO 1
        </div>
        <div class='show-label'>
            CUSTO 2
        </div>
        <div class='show-label'>
            CUSTO 3
        </div>
        <div class='show-label'>
            IMPOSTO
        </div>
        <div class='show-label'>
            MARGEM DE CONTRIBUIÇÃO
        </div>
    </div>

    <div class='col-lg-7 col-xs-6' style='text-align: center'>
        <div class='show-field-start'>
            @if($product->cost1_description)
            {{$product->cost1_description}}
            @else
            não possui
            @endif
        </div>
        <div class='show-field-start'>
            @if($product->cost2_description)
            {{$product->cost2_description}}
            @else
            não possui
            @endif
        </div>
        <div class='show-field-start'>
            @if($product->cost3_description)
            {{$product->cost3_description}}
            @else
            não possui
            @endif
        </div>
        <div class='show-field-start'>
            {{$product->tax_rate}} %
        </div>
        <div class='show-field-start'>
            preço menos custos
        </div>
    </div>


    <div class='col-lg-2 col-xs-6' style='text-align: center'>
        <div class='show-field-end text-end' style='color:red'>
            - {{formatCurrencyReal($product->cost1)}}
        </div>
        <div class='show-field-end text-end' style='color:red'>
            - {{formatCurrencyReal($product->cost2)}}
        </div>
        <div class='show-field-end text-end' style='color:red'>
            - {{formatCurrencyReal($product->cost3)}}
        </div>
        <div class='show-field-end text-end' style='color:red'>
            - {{formatCurrencyReal($product->taxPrice)}}
        </div>
        <div class='show-field-end text-end'>
            {{formatCurrencyReal($product->margin)}}
        </div>
    </div>
</div>
@endsection


@section('createdAt')
<div class='row' style='margin-top: 30px'>
    <div class='col-12'style='padding-top: -10px'>
        Primeiro registro em: {{date('d/m/Y H:i', strtotime($product->created_at))}}
    </div>
</div>
@endsection