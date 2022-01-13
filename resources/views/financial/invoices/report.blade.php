@extends('layouts/master')

@section('title','CAIXA PREVISTO')

@section('image-top')
{{ asset('images/invoice.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonPdfReport('invoice')}}

{{createButtonList('invoice')}}
@endsection

@section('main')
<div class='row mt-4'>
    <div class="col-7">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
    <div class="col-5 pt-5">
        <form id="filter" action="{{route('invoice.report')}}" method="post" style="text-align: right">
            @csrf
            <select class="select"name="year">
                <option  class="fields" value="2022">
                    2022
                </option>
                <option  class="fields" value="2021">
                    2021
                </option>
                <option  class="fields" value="2020">
                    2020
                </option>
            </select>
            <input class="text-button secondary" type="submit" value="FILTRAR">
            <a class="text-button secondary" href='{{route('invoice.report')}}'>
                LIMPAR
            </a>
        </form>
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
         border-radius: 8px 0px 0px 0px;
         '>
        RECEITAS
    </div>

    <!--soma mensal--> 
    @while($counterMonth <= 12)
    <div class='tb col justify-content-end' style='background-color: lightblue;font-weight: 600'>
        <a href='{{route('invoice.index', [
                                                                      'type' => 'receita',
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
         border-radius: 0px 8px 0px 0px;
         '>
        {{formatCurrency($annualRevenues)}}
    </div>
</div>


@php
$counterArray = 1;
$counterMonth = 1;
@endphp

@foreach($categories as $category)
<div class="row">
    <div class="tb col-1 justify-content-start" style='background-color: lightblue;font-weight: 600'>
        {{$category['name']}}
    </div>
    @foreach($months as $key => $month)
    <div class="tb col justify-content-end">
        <a href="{{route('invoice.index', [
                                                            'category' => $category['name'],
                                                            'status' => 'aprovada',
                                                            'type' => 'receita',
                                                            'date_start' => date("$year-$key-01"),
                                                            'date_end' =>  date("$year-$key-t"),
                                                             ])}}">

            {{formatCurrency(floatval($category['monthlys'][$month]))}}
        </a>
    </div>
    @endforeach
    <div class="tb col justify-content-end" style='background-color: lightblue;font-weight: 600'>
        {{formatCurrency(floatval($category['year']))}}
    </div>
</div>
@endforeach



<div class="row mt-3">
    <div class="tb-header col-1 justify-content-start" style='
         background-color: red;
         color:white;
         font-weight: 600;
         border-radius: 8px 0px 0px 0px;
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
        <a  style="color:red"  href='{{route('invoice.index', [
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
         border-radius: 0px 8px 0px 0px;
         '>
        {{formatCurrency($annualExpenses)}}
    </div>
</div>


@php
$counterArray = 1;
$counterMonth = 1;
@endphp

@foreach($groups as $group)
<div class="row">
    <div class="tb col-1 justify-content-start" style='background-color: #FDDBDD;font-weight: 600'>
        {{$group['name']}}
    </div>
    @foreach($months as $key => $month)
    <div class="tb col justify-content-end">
        <a href="{{route('invoice.index', [
                                                              'group' => $group['name'],
                                                              'type' => 'despesa',
                                                              'status' => 'aprovada',
                                                              'date_start' => date("$year-$key-01"),
                                                              'date_end' =>  date("$year-$key-t"),
                                                             ])}}">

            {{formatCurrency(floatval($group['monthlys'][$month]))}}
        </a>
    </div>
    @endforeach
    <div class="tb col justify-content-end"  style='background-color: #FDDBDD;font-weight: 600'>
        {{formatCurrency(floatval($group['year']))}}
    </div>
</div>
@endforeach


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
        <a href='{{route('invoice.index', [
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
        {{formatCurrency($annualTotal)}}
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

foreach ($monthlyExpenses as $key => $value) {
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