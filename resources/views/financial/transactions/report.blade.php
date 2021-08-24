@extends('layouts/master')

@section('title','RELATÓRIO DE FLUXO DE CAIXA')

@section('image-top')
{{ asset('images/journey.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>

{{createButtonBack()}}
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
        <a class='text-button primary' href='{{route('transaction.report')}}'>
            REALIZADO
        </a>
        <br>
        <br>
        <a class='text-button secondary' href='{{route('invoice.report')}}'>
            PREVISIONADO
        </a>
    </div>
</div>


<div class="row mt-4">
    <div class="tb-header col-1">
        TIPO 
    </div>
    @foreach ($months as $month)
    <div   class="tb-header col" style="width: 5%">
        {{$month}}
    </div>
    @endforeach
    <div   class="tb-header col" style="width: 10%">
        TOTAL 
    </div>
</div>

@php
$counterArray = 1;
$counterMonth = 1;
@endphp

<div class="row mt-1">
    <div class="tb-header col-1 justify-content-start"  style='background-color: #4863A0;font-weight: 600'>
        RECEITAS
    </div>

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

    <div class='tb tb-header col justify-content-end'  style='background-color: #4863A0;font-weight: 600'>
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
        <a href="{{route('transaction.index', [
                                                            'category' => $category['name'],
                                                            'type' => 'crédito',
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

<div class="row mt-5">
    <div class="tb-header col-1 justify-content-start" style='background-color: red;color:white;font-weight: 600'>
        DESPESAS
    </div>
    @php
    $counterArray = 1;
    $counterMonth = 1;
    @endphp

    @while ($counterMonth <= 12)
    <div class='tb col justify-content-end' style='background-color: #FDDBDD;font-weight: 600'>
        <a href='{{route('transaction.index', [
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
    <div class='tb col justify-content-end' style='background-color: red;color:white;font-weight: 600'>
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
        <a href="{{route('transaction.index', [
                                                              'group' => $group['name'],
                                                              'type' => 'débito',
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

$monthlyCategory = [];
$counter = 1;
foreach ($categories as $category) {
    $monthlyCategory[] = json_encode(array_values($category['monthlys']));
//    $monthlyCategory[$counter++] = json_encode(array_values($monthlyCategory));
}
//    dd($monthlyCategory[0]);
?>

    new Chart(document.getElementById("chart"), {
        type: 'line',
        data: {
            labels: <?php echo $monthsLabel; ?>,
            datasets: [{
                    data: <?php echo $monthlyRevenues; ?>,
                    label: "Receitas totais",
                    borderColor: "#3e95cd",
                    fill: false
                }, {
                    data: <?php echo $monthlyCategory[0]; ?>,
                    label: "Serviços",
                    borderColor: "#ffff00",
                    fill: false
                }, {
                    data: <?php echo $monthlyCategory[1]; ?>,
                    label: "Produtos",
                    borderColor: "#8e5ea2",
                    fill: false
                }, {
                    data: <?php echo $monthlyCategory[2]; ?>,
                    label: "Produtos digitais",
                    borderColor: "#3cba9f",
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