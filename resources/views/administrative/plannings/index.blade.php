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
<div class='row mt-2'>
    <div class='tb tb-header-start col-6'>
        NOME
    </div>
    <div class='tb tb-header col-1'>
        MESES
    </div>
    <div class='tb tb-header col-1'>
        DESPESAS
    </div>
    <div class='tb tb-header col-1'>
        CUSTOS
    </div>
    <div class='tb tb-header col-1'>
        RECEITAS
    </div>
    <div class='tb tb-header col-1'>
        LUCRO
    </div>
    <div class='tb tb-header-end col-1'>
        SITUAÇÃO
    </div>
</div>

@foreach ($plannings as $planning)
<div class='row'>
    <div class='tb col-6 justify-content-start'>
        <button class="button">
            <a href=" {{route('planning.show', ['planning' => $planning])}}">
                <i class='fa fa-eye' style="color:white"></i>
            </a>
        </button>
        <button class="button">
            <a href=" {{route('planning.edit', ['planning' => $planning])}}">
                <i class='fa fa-edit' style="color:white"></i>
            </a>
        </button>
        {{$planning->name}}
    </div>
    <div class='tb col-1'>
        {{$planning->months}}
    </div>
    <div class='tb col-1 justify-content-end'>
        {{formatCurrencyReal($planning->expenses)}}
    </div>
    <div class='tb col-1 justify-content-end'>
        R$ {{ number_format($planning->cost1 + $planning->cost2 + $planning->cost3, 2,",",".") }}
    </div>
    <div class='tb col-1 justify-content-end'>
        R$ {{ number_format($planning->price * $planning->tax_rate / 100, 2,",",".") }}
    </div>
    <div class='tb col-1 justify-content-end'>
        R$ {{ number_format(-$planning->price * $planning->tax_rate /100 - $planning->cost1 - $planning->cost2 - $planning->cost3 + $planning->price, 2,",",".") }}
    </div>
    <div class='tb col-1 justify-content-end'>
        R$ {{ number_format($planning->price,2,",",".") }}
    </div>
</div>
@endforeach
<p style="text-align: right">
    <br>
    {{ $plannings->links() }}
</p>
<br>
@endsection