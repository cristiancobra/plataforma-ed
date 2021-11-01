@extends('layouts/templates_shop/default')

@section('banner')
<div class="row justify-content-start" style="
     height: 60px;
     width: 100%;
     font-size: 20px;
     align-items: center;
     opacity: 0.8;
     position: absolute;
     overflow: hidden;
     background-color: {{$principalColor}}
">
                @if(count($tasksEmergency) > 0))
            <a class='circular-nav-button delete'  href='{{route('task.index', [
                                                                                                                    'status' => 'fazer',
                                                                                                                    'priority' => 'emergência',
                                                                                                                    'user_id' => auth()->user()->id,
                                                                                                                    ])}}'>
                <i class="fas fa-exclamation-triangle" title='Tarefas emergenciais' style="color:#8B2485"></i>
            <div style="
                 border-radius: 50%;
                 color:white;
                 background-color: red;
                 font-size: 11px;
                 font-weight: 600;
                 text-align: center;
                 width: 17px;
                 height: 17px;
                 margin-top: -28px;
                 margin-left: 15px;
                 padding-bottom: 5px;
                 ">
                {{$tasksEmergencyTotal}}
            </div>
            </a>
            @endif
</div>
@if($shop)
<div class='row pt-5' style='
     height:250px;
     background-image: url({{asset($shop->banner->path)}});
     background-size: cover;
     background-position: center;
     background-repeat: no-repeat;
     '>
    <div class='col text-center'>
        <p class="mt-5 pt-5" style="color: {{$oppositeColor}};text-shadow: 2px 2px 4px #000000;font-size: 38px">
            $shop->headline
        </p>
    </div>
</div>
@else
<div class='row pt-5' style='
     height:250px;
     background-color: {{$principalColor}}
     '>
    <div class='col text-center'>
        <p class="mt-5 pt-5" style="color: {{$oppositeColor}};text-shadow: 2px 2px 4px #000000;font-size: 38px">
            $shop->headline
        </p>
    </div>
</div>
@endif
@endsection


@section('product_name', $product->name)

@section('image')
<div class='product-image-public'>
    @if($product->image)
    <image src='{{asset($product->image->path)}}' width='90%' heigh='90%'>
    @else
    <image src='{{asset('images/products.png')}}'  width='90%' heigh='90%'>
    @endif
</div>
@endsection

@section('fields')
    <div class='show-field-end text-end'>
        {{$product->name}}
    </div>
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

