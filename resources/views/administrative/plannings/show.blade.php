@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection

@section('buttons')
{{createButtonBack()}}
{{createButtonList('planning')}}
@endsection


@section('main')
<h1 class='name'>
    {{$planning->name}}
</h1>

<div class='row mt-4 mb-5'>
    <div class="col-11">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
</div>

<label class='labels' for='' >META DE VENDAS INICIAL</label>
<br>
<div class='row mt-3'>
    <div   class='tb-header-start col-1'>
        QTDE 
    </div>
    <div   class='tb-header col-1'>
        FOTO 
    </div>
    <div   class='tb-header col-5'>
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
    <div   class='tb-header col-1'>
        PREÇO UNITÁRIO
    </div>
    <div   class='tb-header-end col-1'>
        PREÇO TOTAL
    </div>
</div>

@php
$counter = 0;
@endphp
@foreach ($productsPlannings as $productPlanning)
<div class='row'>
    <div class='tb col-1'>
        {{$productPlanning->subtotal_amount}}
    </div>
    <div class='tb col-1'>
        <image src='{{$productPlanning->product->image}}' style='width:50px;height:50px; margin: 5px'></a>
    </div>
    <div class='tb col-5 justify-content-start'>
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
    <div class='tb col-1 justify-content-end' style='color:white;background-color: #c28dbf;text-align: right'>
        {{formatCurrency($productPlanning->subtotal_price)}}
    </div>
</div>
@php
$counter++;
@endphp
@endforeach

<div class='row'>
    <div   class='tb tb-header col-11 justify-content-end'>
        TOTAL: 
    </div>
    <div   class='tb tb-header col-1 justify-content-end'>
        {{formatCurrencyReal($planning->total_price)}}
    </div>

    <div class='row mt-5'>
        <label class='labels' for='' >PROJEÇÃO MENSAL</label>
    </div>
    <div class='row mt-2'>
        <div   class='tb-header-start col-1' style="font-size: 12px">
            MÊS 
        </div>
        <div class='tb-header col-1' style="font-size: 12px">
            QTDE
        </div>
        <div   class='tb-header col-1' style="font-size: 12px">
            DESPESAS
        </div>
        <div class='tb tb-header col-1' style="font-size: 12px">
            CRESCIMENTO DESPESAS
        </div>
        <div   class='tb-header col-1' style="font-size: 12px">
            CUSTOS
        </div>
        <div   class='tb-header col-1' style="font-size: 12px">
            IMPOSTO
        </div>
        <div   class='tb-header col-1' style="font-size: 12px">
            MARGEM
        </div>
        <div   class='tb-header col-1' style="font-size: 12px">
            FATURAMENTO
        </div>
        <div class='tb tb-header col-1' style="font-size: 12px">
            CRESCIMENTO RECEITAS
        </div>
        <div   class='tb-header col-1' style="font-size: 12px">
            LUCRO MENSAL
        </div>
        <div   class='tb-header-end col-2' style="font-size: 12px">
            LUCRO ACUMULADO
        </div>
    </div>
    @php
    $counter = 1;
    $revenues = $planning->total_price;
    $income = $planning->total_margin - $planning->expenses;
    @endphp
    @while($counter <= $planning->months)
    <div class='row'>
        <div class='tb col-1' style="font-size: 12px">
            {{$months[$counter]['month']}}
        </div>
        <div class='tb col-1' style="font-size: 12px">
            {{number_format($months[$counter]['sumAmount'])}}
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: #FDDBDD;">
            {{formatCurrencyReal($months[$counter]['sumExpenses'])}}
        </div>
        <div class='tb col-1' style="font-size: 12px;background-color: #FDDBDD;">
            {{$planning->increased_expenses}} %
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: #FDDBDD;">
            {{formatCurrencyReal($planning->total_cost)}}
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: #FDDBDD;">
            {{formatCurrencyReal($planning->total_tax_rate)}}
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: lightblue">
            {{formatCurrencyReal($planning->total_margin)}}
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: lightblue">
            {{formatCurrencyReal($months[$counter]['sumRevenues'])}}
        </div>
        <div class='tb col-1' style="font-size: 12px;background-color: lightblue">
            {{$planning->growth_rate}} %

        </div>
        @if($months[$counter]['sumIncome'] >= 0)
        <div class='tb col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months[$counter]['sumIncome'])}}
        </div>
        @else
        <div class='tb col-1 justify-content-end' style="font-size: 12px; color: red">
            - {{formatCurrencyReal($months[$counter]['sumIncome'])}}
        </div>
        @endif

        @if($months[$counter]['sumIncome'] >= 0)
        <div class='tb col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months[$counter]['accumulatedIncome'])}}
        </div>
        @else
        <div class='tb col-2 justify-content-end' style="font-size: 12px; color: red">
            - {{formatCurrencyReal($months[$counter]['accumulatedIncome'])}}
        </div>
        @endif
    </div>
    @php
    $counter++;
    $revenues += ($revenues * $planning->growth_rate / 100);
    $income += $planning->total_price - $planning->expenses;
    @endphp
    @endwhile
    <div class='row mb-5'>
        <div   class='tb-header col-1' style="font-size: 12px">
            TOTAIS
        </div>
        <div class='tb-header col-1' style="font-size: 12px">
            {{number_format($months['totalAmount'], 0)}}
        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalExpenses'])}}
        </div>
        <div class='tb tb-header col-1'>

        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($planning->total_cost)}}
        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($planning->total_tax_rate)}}
        </div>
        <div   class='tb-header col-1'>

        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalRevenues'])}}
        </div>
        <div class='tb tb-header col-1'>

        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalIncome'])}}
        </div>
        <div   class='tb-header col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalAccumulatedIncome'])}}
        </div>
    </div>
    <label class='labels' for=''>SITUAÇÃO:</label>
    <span class='fields'>{{$planning->status }}</span>
    <br>
    <br>
    <p class='labels'>  Criado em:   {{date('d/m/Y H:i', strtotime($planning->created_at))}}</p>

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

    @section('js-scripts')
    <script>
        //  gráfico de linhas
        var ctx = document.getElementById('chart');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
<?php
$counter = 1;
// dd($months[$counter]['month']);
while ($counter <= $planning->months) {
    echo json_encode($months[$counter]['month']);
    echo ",";
    $counter++;
}
?>
                ],
                datasets: [
                    {
                        label: 'Faturamento',
                        data: [
<?php
$counter = 1;
// dd($months[$counter]['month']);
while ($counter <= $planning->months) {
    echo json_encode($months[$counter]['sumRevenues']);
    echo ",";
    $counter++;
}
?>
                        ],
                        backgroundColor: '#6666ff',
                        borderColor: 'blue',
                    },
                    {
                        label: 'Despesas',
                        data: [
<?php
$counter = 1;
// dd($months[$counter]['month']);
while ($counter <= $planning->months) {
    echo json_encode($months[$counter]['sumExpenses']);
    echo ",";
    $counter++;
}
?>
                        ],
                        backgroundColor: '#ff6666',
                        borderColor: 'red',
                    },
                    {
                        label: 'Lucro acumulado',
                        data: [
<?php
$counter = 1;
// dd($months[$counter]['month']);
while ($counter <= $planning->months) {
    echo json_encode($months[$counter]['accumulatedIncome']);
    echo ",";
    $counter++;
}
?>
                        ],
                        backgroundColor: '#7fff7f',
                        borderColor: 'green',
                    },
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'TOTAL DE HORAS POR MÊS'
                    }
                }
            },
        });
    </script>
    @endsection