@extends('layouts/index')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection


@section('buttons')
<a class="circular-button secondary"  href="{{route('planning.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('table')
<div class='row table-header mt-2 mb-4'>
    <div class='col-4'>
        NOME
    </div>
    <div class='col-1'>
        MESES
    </div>
    <div class='col-1'>
        DESPESAS
    </div>
    <div class='col-1'>
        CRESCIMENTO DESPESAS
    </div>
    <div class='col-1'>
        CUSTOS
    </div>
    <div class='col-1'>
        IMPOSTOS
    </div>
    <div class='col-1'>
        RECEITAS
    </div>
    <div class='col-1'>
        CRESCIMENTO RECEITAS
    </div>
    <div class='col-1'>
        LUCRO
    </div>
</div>

@foreach ($plannings as $planning)
<div class="row table2 position-relative"  style="
     color: {{$principalColor}};
     border-left-color: {{$complementaryColor}}
     ">
            <a class='stretched-link' href=" {{route('planning.show', ['planning' => $planning])}}">
            </a>
    <div class='cel col-4 justify-content-start'>
        {{$planning->name}}
    </div>
    <div class='cel col-1'>
        {{$planning->months}}
    </div>
    <div class='cel col-1 justify-content-end'>
        {{formatCurrencyReal($planning->expenses)}}
    </div>
    <div class='cel col-1'>
        {{$planning->increased_expenses}} %
    </div>
    <div class='cel col-1 justify-content-end'>
        {{formatCurrencyReal($planning->cost1 + $planning->cost2 + $planning->cost3)}}
    </div>
    <div class='cel col-1 justify-content-end'>
        {{formatCurrencyReal($planning->price * $planning->tax_rate / 100) }}
    </div>
    <div class='cel col-1 justify-content-end'>
        {{formatCurrencyReal($planning->total_price)}}
    </div>
        <div class='cel col-1'>
        {{$planning->growth_rate}} %
    </div>
    <div class='cel col-1 justify-content-end'>
        {{formatCurrencyReal($planning->price)}}
    </div>
</div>
@endforeach
<p style="text-align: right">
    <br>
    {{$plannings->links()}}
</p>
<br>
@endsection