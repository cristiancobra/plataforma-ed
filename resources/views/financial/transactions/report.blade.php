@extends('layouts/master')

@section('title','FLUXO DE CAIXA')

@section('image-top')
{{ asset('images/journey.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>


{{createButtonList('journey')}}
@endsection

@section('main')
<div class='row'>
    <form id="filter" action="{{route('transaction.report')}}" method="post" style="text-align: right">
        @csrf
        <select class="select"name="year">
            <option  class="fields" value="2021">
                2021
            </option>
            <option  class="fields" value="2022">
                2022
            </option>
            <option  class="fields" value="2020">
                2020
            </option>
        </select>
        <a class="text-button secondary" href='{{route('invoice.report')}}'>
            LIMPAR
        </a>
        <input class="text-button secondary" type="submit" value="FILTRAR">
    </form>
</div>


<div class='row mt-4'>
    <div class="col-7">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
    <div class="col-3 pt-5">
        <br>
        <span class="labels">xxxxxx</span> horas executadas em {{date('Y')}} .
        <br>
        <span class="labels">xxxx</span> horas de média mensal.
        </p>
    </div>
    <div class="col-2 pt-5">
        <a class='text-button secondary' href='{{route('invoice.report')}}'>
            CAIXA PREVISTO
            (faturas)
        </a>
    </div>
</div>


<div class="row mt-5 table-header ">
    <div class="col-1">

    </div>
    @foreach ($months as $month)
    <div   class="col" style="width: 5%">
        {{$month}}
    </div>
    @endforeach
    <div   class="col" style="width: 10%">
        TOTAL 
    </div>
</div>

@php
$counterArray = 1;
$counterMonth = 1;
@endphp

<div class="row mt-4">
    <div class="tb-header col-1 justify-content-start"  style='
         background-color: #4863A0;
         font-weight: 600;
         border-radius: 8px 0px 0px 8px;
         '>
        RECEITAS
    </div>

    <!--soma mensal--> 
    @while($counterMonth <= 12)
    <div class='tb col justify-content-end' style='background-color: lightblue;font-weight: 600'>
        <a href='{{route('transaction.index', [
                                                                      'type' => 'crédito',
                                                                      'date_start' => date("$year-$counterMonth-01"),
                                                                      'date_end' =>  date("$year-$counterMonth-t"),
                                                                     ])}}'>

            {{formatCurrency($monthlyRevenues[$counterArray])}}
        </a>
    </div>
    @php
    $counterMonth++;
    $counterArray++;    
    @endphp
    @endwhile

    <div class='tb tb-header col justify-content-end'  style='
         background-color: #4863A0;
         font-weight: 600;
         border-radius: 0px 8px 8px 0px;
         '>
        {{formatCurrency($annualRevenues)}}
    </div>
</div>


<div class="row mt-3">
    <div class="tb-header col-1 justify-content-start" style='
         background-color: red;
         color:white;
         font-weight: 600;
         border-radius: 8px 0px 0px 8px;
         '>
        DESPESAS
    </div>

    <!--soma mensal--> 
    @php
    $counterArray = 1;
    $counterMonth = 1;
    @endphp

    @while ($counterMonth <= 12)
    <div class='tb col justify-content-end' style='background-color: #FDDBDD;font-weight: 600'>
        <a  style="color:red"  href='{{route('transaction.index', [
                                                                      'type' => 'débito',
                                                                      'date_start' => date("$year-$counterMonth-01"),
                                                                      'date_end' =>  date("$year-$counterMonth-t"),
                                                                     ])}}'>
            {{formatCurrency($monthlyExpenses[$counterArray])}}
        </a>
    </div>
    @php
    $counterMonth++;
    $counterArray++;
    @endphp
    @endwhile
    <div class='tb col justify-content-end' style='
         background-color: red;
         color:white;
         font-weight: 600;
         border-radius: 0px 8px 8px 0px;
         '>
        {{formatCurrency($annualExpenses)}}
    </div>
</div>


<div class="row mt-3 mb-5">
    <div class="tb-header col-1 justify-content-start" style='
         background-color: {{$principalColor}};
         color:white;
         font-weight: 600;
         border-radius: 8px 0px 0px 8px;
         '>
        SALDO
    </div>

    <!--soma saldo mensal--> 
    @php
    $counterArray = 1;
    $counterMonth = 1;
    @endphp

    @while ($counterMonth <= 12)
    <div class='tb col justify-content-end' style='background-color: lightgray;font-weight: 600'>
        <a href='{{route('transaction.index', [
                                                                      'date_start' => date("$year-$counterMonth-01"),
                                                                      'date_end' =>  date("$year-$counterMonth-t"),
                                                                     ])}}'>
            {{formatCurrency($monthlysTotals[$counterArray])}}
        </a>
    </div>
    @php
    $counterMonth++;
    $counterArray++;
    @endphp
    @endwhile
    <div class='tb col justify-content-end' style='
         background-color: {{$principalColor}};
         color:white;
         font-weight: 600;
         border-radius: 0px 8px 8px 0px;
         '>
        {{formatCurrency($annualExpenses)}}
    </div>
</div>


@endsection

@section('js-scripts')
<script>
    $(document).ready(function () {
        //botao de exibir filtro
        $("#filter_button").click(function () {
            $("#filter").slideToggle(600);
        });
    });

    //gráfico de linhas

<?php
$monthsLabel = json_encode(array_values($months));
$monthlyRevenues = json_encode(array_values($monthlyRevenues));

foreach($monthlyExpenses as $key => $value) {
    $monthlyExpensesPositive[$key] = $value * -1;
}

$monthlyExpenses = json_encode(array_values($monthlyExpensesPositive));
$monthlysTotals = json_encode(array_values($monthlysTotals));
//dd($monthlyRevenues[0]);
//$monthlyCategory = [];
//$counter = 1;
//foreach ($categories as $category) {
//    $monthlyCategory[] = json_encode(array_values($category['monthlys']));
//    $monthlyCategory[$counter++] = json_encode(array_values($monthlyCategory));
//}
//    dd($monthlyCategory[0]);
?>

    new Chart(document.getElementById("chart"), {
        type: 'line',
        data: {
            labels: <?php echo $monthsLabel; ?>,
            datasets: [{
                    data: {{$monthlyRevenues}},
                    label: "Receitas",
                    borderColor: "#3e95cd",
                    fill: false
                }, {
                    data: {{$monthlyExpenses}},
                    label: "Despesas",
                    borderColor: "red",
                    fill: false
                }, {
                    data: {{$monthlysTotals}},
                    label: "Saldo",
                    borderColor: "#8e5ea2",
                    fill: false
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'World population per region (in millions)'
            }
        }
    });


</script>
@endsection