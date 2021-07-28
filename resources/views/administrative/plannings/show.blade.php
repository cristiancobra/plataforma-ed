@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href='{{route('planning.index')}}'>VER PLANEJAMENTOS</a>
@endsection

@section('main')
<h1 class='name'>
    {{$planning->name}}
</h1>
<br>
<label class='labels' for='' >META DE VENDAS MENSAL</label>
<br>
<p class='fields' for='' >Estabeleça uma META de vendas de cada produto que consiga pagar suas despensas  e gerar lucro. </p>
<div class='row mt-3'>
    <div   class='tb-header-start col-1'>
        QTDE 
    </div>
    <div   class='tb-header col-1'>
        FOTO 
    </div>
    <div   class='tb-header col-6'>
        NOME 
    </div>
    <div   class='tb-header col-1'>
        CUSTOS
    </div>
    <div   class='tb-header col-1'>
        IMPOSTO
    </div>
    <div   class='tb-header col-1'>
        MARGEM
    </div>
    <div   class='tb-header-end col-1'>
        PREÇO
    </div>
</div>

@php
$counter = 0;
@endphp
@foreach ($productsPlannings as $productPlanning)
<div class='row'>
    <div class='tb col-1'>
        {{$productPlanning->amount}}
    </div>
    <div class='tb col-1'>
        <image src='{{$productPlanning->product->image}}' style='width:50px;height:50px; margin: 5px'></a>
    </div>
    <div class='tb col-6 justify-content-start'>
        <button class='button-round'>
            <a href=' {{route('product.show', ['product' => $productPlanning->product->id])}}'>
                <i class='fa fa-eye' style='color:white'></i>
            </a>
        </button>
        <button class='button-round'>
            <a href=' {{route('product.edit', ['product' => $productPlanning->product->id])}}'>
                <i class='fa fa-edit' style='color:white'></i>
            </a>
        </button>
        {{$productPlanning->product->name}}
    </div>
    <div class='tb col-1'>
        {{formatCurrencyReal($productPlanning->product->cost1 + $productPlanning->product->cost2 + $productPlanning->product->cost3)}}
    </div>
    <div class='tb col-1 justify-content-end'>
        {{formatCurrencyReal($productPlanning->product->price * $productPlanning->product->tax_rate / 100)}}
    </div>
    <div class='tb col-1 justify-content-end'>
        {{formatCurrencyReal(-$productPlanning->product->price * $productPlanning->product->tax_rate / 100 - $productPlanning->product->cost1 - $productPlanning->product->cost2 - $productPlanning->product->cost3 + $productPlanning->product->price)}}
    </div>
    <div class='tb col-1 justify-content-end' style='color:white;background-color: #c28dbf;text-align: right'>
        {{formatCurrency($productPlanning->product->price)}}
    </div>
</div>
@php
$counter++;
@endphp
@endforeach
<br>
<p style='text-align: right'>
    <label class='labels' for=''>DESPESAS MENSAIS:</label>
    <span class='fields'>R$ {{number_format($planning->expenses, 2,',','.') }}</span>
</p>
<p style='text-align: right'>
    <label class='labels' for=''>SALDO:</label>
    <span class='fields'>R$ {{number_format($planning->totalBalance, 2,',','.') }}</span>
</p>
<div class='row mt-3'>
    <div   class='tb-header-start col-1'>
        MÊS 
    </div>
    <div class='tb-header col-1'>
         QTDE
    </div>
    <div   class='tb-header col-1'>
        DESPESAS
    </div>
    <div   class='tb-header col-1'>
        CUSTOS
    </div>
    <div   class='tb-header col-1'>
        IMPOSTO
    </div>
    <div   class='tb-header col-1'>
        MARGEM
    </div>
    <div   class='tb-header col-1'>
        FATURAMENTO
    </div>
    <div   class='tb-header-end col-2'>
        LUCRO
    </div>
</div>
@php
$counter = 0;
$income = $planning->total_price - $planning->;
@endphp
@while($counter < $planning->months)
<div class='row'>
    <div class='tb col-1' style="font-size: 12px">
        {{$counter}}
    </div>
    <div class='tb col-1' style="font-size: 12px">
        {{$counter}}
    </div>
    <div class='tb col-1 justify-content-end' style="font-size: 12px">
        {{formatCurrencyReal($planning->expenses)}}
    </div>
    <div class='tb col-1 justify-content-end' style="font-size: 12px">
        {{formatCurrencyReal($planning->total_cost)}}
    </div>
    <div class='tb col-1 justify-content-end' style="font-size: 12px">
        {{formatCurrencyReal($planning->total_tax_rate)}}
    </div>
    <div class='tb col-1 justify-content-end' style="font-size: 12px">
        {{formatCurrencyReal($planning->total_margin)}}
    </div>
    <div class='tb col-1 justify-content-end' style="font-size: 12px">
        {{formatCurrencyReal($planning->total_price)}}
    </div>
    <div class='tb col-2 justify-content-end' style="font-size: 12px">
        {{formatCurrencyReal($income)}}
    </div>
</div>
@php
$counter++;
$income += $planning->total_price;
@endphp
@endwhile
<label class='labels' for=''>SITUAÇÃO:</label>
<span class='fields'>{{$planning->status }}</span>
<br>
<br>
<p class='labels'>  Criado em:   {{ date('d/m/Y H:i', strtotime($planning->created_at)) }} </p>

<div style='text-align:right;padding: 2%'>
    <form   style='text-decoration: none;display: inline-block' action='{{ route('planning.destroy', ['planning' => $planning->id]) }}' method='post'>
        @csrf
        @method('delete')
        <input class='btn btn-danger' type='submit' value='APAGAR'>
    </form>
    <a class='btn btn-secondary' href=' {{ route('planning.edit', ['planning' => $planning->id]) }} '  style='text-decoration: none;color: white;display: inline-block'>
        <i class='fa fa-edit'></i>EDITAR</a>
    <a class='btn btn-secondary' href='{{route('planning.index')}}'><i class='fas fa-arrow-left'></i></a>
</div>
<br>

@endsection