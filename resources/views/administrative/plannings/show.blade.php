@extends('layouts/show')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection

@section('buttons')
{{createButtonTrash($planning, 'planning')}}
{{createButtonEdit('planning', 'planning', $planning)}}
{{createButtonList('planning')}}
@endsection

@section('name', $planning->name)


@section('priority', $priority)


@section('status', $status)


@section('fieldsId')
<div class='col-3 pe-0' style='text-align: center'>
    <div class='show-label'>
        PERÍODO
    </div>
    <div class='show-label' style='text-align: left'>
        CRESCIMENTO DAS VENDAS
    </div>
    <div class='show-label' style='text-align: left'>
        CRESCIMENTO DAS DESPESAS
    </div>
</div>
<div class='col-3 ps-0' style='text-align: center'>
    <div class='show-field-end'>
        {{$planning->months}} meses
    </div>
    <div class='show-field-end'>
        {{$planning->growth_rate}} %
    </div>    
    <div class='show-field-end'>
        {{$planning->increased_expenses}} %
    </div>    
</div>

<div class='col-3 pe-0' style='text-align: center'>
    <div class='show-label'>
        QTDE INICIAL DE VENDAS
    </div>
    <div class='show-label' style='text-align: left'>
        VALOR INICIAL DAS VENDAS
    </div>
    <div class='show-label' style='text-align: left'>
        VALOR INICIAL DAS DESPESAS
    </div>
</div>
<div class='col-3 ps-0' style='text-align: center'>
    <div class='show-field-end'>
        {{$planning->total_amount}}
    </div>
    <div class='show-field-end'>
        {{formatCurrencyReal($planning->total_price)}}
    </div>    
    <div class='show-field-end'>
        {{$planning->increased_expenses}} %
    </div>    
</div>
@endsection


@section('description')
{!!html_entity_decode($planning->observations)!!}
@endsection


@section('main')

<div class='row mt-4 mb-5'>
    <div class="col-11">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
</div>

<div class='row mt-5 mb-0'>
    <div class="cel col justify-content-start"  style='
         color:white;
         background-color: darkred;
         font-weight: 600;
         border-radius: 8px;
         '>
        <label class="labels" for="" style='
               color:white;
               '>                    
            DESPESAS MENSAIS
        </label>
    </div>        
</div>
<div class='row mt-4'>
    <div class='col-2 labels'>
        PROLABORE
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_prolabore)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        SALÁRIO
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_salary)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        MARKETING
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_marketing)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        PRODUÇÃO
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_production)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        CONTABILIDADE
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_accounting)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        JURÍDICO
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_legal)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        INFRAESTRUTURA
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_infrastructure)}}
    </div>
</div>
<div class='row mt-1'>
    <div class='col-2 labels'>
        CAPITAL DE GIRO
    </div>
    <div class='col-2 d-flex justify-content-end'>
        {{formatCurrencyReal($planning->expenses_working_capital)}}
    </div>
</div>


<div class='row mt-5 mb-0'>
    <div class="cel col justify-content-start"  style='
         color:white;
         background-color: #4863A0;
         font-weight: 600;
         border-radius: 8px;
         '>
        <label class="labels" for="" style='
               color:white;
               '>                    
            META DE VENDAS INICIAL
        </label>
    </div>        
</div>



<div class='row table-header mt-3 mb-4'>
    <div   class='col-1'>
        QTDE 
    </div>
    <div   class='col-1'>
        FOTO 
    </div>
    <div   class='col-5'>
        NOME 
    </div>
    <div   class='col-1'>
        CUSTOS
    </div>
    <div   class='col-1'>
        IMPOSTO
    </div>
    <div   class='col-1'>
        MARGEM
    </div>
    <div   class='col-1'>
        UNITÁRIO
    </div>
    <div   class='col-1'>
        TOTAL
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
        @if($productPlanning->product->image)
        <image src='{{asset($productPlanning->product->image->path)}}' style='width:50px;height:50px; margin: 5px'></a>
        @else
        <image src='{{asset('images/products.png')}}' style='width:50px;height:50px; margin: 5px'></a>
        @endif
    </div>
    <div class='tb col-5 justify-content-start'>
        <button class='button-round'>
            <a href=' {{route('product.show', ['product' => $productPlanning->product->id])}}'>
                <i class='fa fa-eye' style='color:white'></i>
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
        <label class='labels' for='' >
            PROJEÇÃO MENSAL
        </label>
    </div>
    <div class='row table-header mt-3 mb-3'>
        <div   class='col-1' style="font-size: 12px">
            MÊS 
        </div>
        <div class='col-1' style="font-size: 12px">
            QTDE
        </div>
        <div   class='col-2' style="font-size: 12px">
            DESPESAS
        </div>
        <div   class='col-1' style="font-size: 12px">
            CUSTOS
        </div>
        <div   class='col-1' style="font-size: 12px">
            IMPOSTO
        </div>
        <div   class='col-2' style="font-size: 12px">
            FATURAMENTO
        </div>
        <div   class='col-2' style="font-size: 12px">
            LUCRO MENSAL
        </div>
        <div   class='col-2' style="font-size: 12px">
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
        <div class='tb col-2 justify-content-end' style="font-size: 12px;background-color: #FDDBDD;">
            {{formatCurrencyReal($months[$counter]['sumExpenses'])}}
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: #FDDBDD;">
            {{formatCurrencyReal($planning->total_cost)}}
        </div>
        <div class='tb col-1 justify-content-end' style="font-size: 12px;background-color: #FDDBDD;">
            {{formatCurrencyReal($planning->total_tax_rate)}}
        </div>
        <div class='tb col-2 justify-content-end' style="font-size: 12px;background-color: lightblue">
            {{formatCurrencyReal($months[$counter]['sumRevenues'])}}
        </div>
        @if($months[$counter]['sumIncome'] >= 0)
        <div class='tb col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months[$counter]['sumIncome'])}}
        </div>
        @else
        <div class='tb col-2 justify-content-end' style="font-size: 12px; color: red">
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
    <div class='row mb-0'>
        <div   class='tb-header col-1' style="font-size: 12px">
            TOTAIS
        </div>
        <div class='tb-header col-1' style="font-size: 12px">
            {{number_format($months['totalAmount'], 0)}}
        </div>
        <div   class='tb-header col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalExpenses'])}}
        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($planning->total_cost)}}
        </div>
        <div   class='tb-header col-1 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($planning->total_tax_rate)}}
        </div>
        <div   class='tb-header col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalRevenues'])}}
        </div>
        <div   class='tb-header col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalIncome'])}}
        </div>
        <div   class='tb-header col-2 justify-content-end' style="font-size: 12px">
            {{formatCurrencyReal($months['totalAccumulatedIncome'])}}
        </div>
    </div>

    <div class='container mt-5 mb-5 pb-4'  style='
         border-style: solid;
         border-width: 1px;
         border-color: #4863A0;
         border-radius: 8px;
         '>
        <div class='row mt-0 pt-3 pb-3'>
            <div class="col">
                <label class="labels" for="">
                VALUATION
                </label>
                <p class="fields" for="">
            Calculamos o valuation (valor de venda) de sua empresa utilizando o método de fluxo de caixa descontado (receitas - despesas - taxa de desconto).
            A taxa de desconto varia de acordo com o risco do seu negócio, por isso apresentamos 3 possibilidades:
        </p>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <span style='font-weight: 600; color: #4863A0'>
                    AGRESSIVO 
                </span>
                    (taxa de desconto de 30%):
            </div>
            <div class="col-3" style="font-weight: 600; color: #4863A0">
                {{formatCurrencyReal($valuation30)}}
            </div>
            </div>
            <div class="row">
            <div class="col-5">
                <span style="font-weight: 600">
                 MODERADO 
                </span>
                 (taxa de desconto de 40%):
            </div>
            <div class="col-3" style="font-weight: 600">
                {{formatCurrencyReal($valuation40)}}
            </div>
            </div>
                <div class="row">
            <div class="col-5">
                <span style='font-weight: 600; color: red'>
                CONSERVADOR 
                </span>
                (taxa de desconto de 50%):
            </div>
            <div class="col-3" style="font-weight: 600; color: red">
                {{formatCurrencyReal($valuation50)}}
            </div>
            </div>
        </div>
    </div>

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