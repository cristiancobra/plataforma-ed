@extends('layouts/master')

@section('title','VENDAS')

@section('image-top')
{{ asset('images/proposal.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
{{createButtonPdfReport('proposal')}}

{{createButtonList('proposal')}}
@endsection

@section('main')
<div class='row mt-4'>
    <div class="col-7">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
    <div class="col-5 pt-5">
        <form id="filter" action="{{route('proposal.report')}}" method="post" style="text-align: right">
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
                <option  class="fields" value="2019">
                    2019
                </option>
            </select>
            <input class="text-button secondary" type="submit" value="FILTRAR">
            <a class="text-button secondary" href='{{route('proposal.report')}}'>
                LIMPAR
            </a>
        </form>
    </div>
</div>

<div class="container m-0 mt-4 p-0">
<div class="row table-header mt-5">
    <div class="col-1">
        TIPO 
    </div>
    @foreach($months as $month)
    <div   class="col" style="width: 5%">
        {{$month}}
    </div>
    @endforeach
    <div   class="col" style="width: 10%">
        TOTAL 
    </div>
</div>
</div>


<!--CONTAINER DE VENDAS-->
@php
$counterArray = 1;
$counterMonth = 1;
@endphp

<div class="container m-0 mt-4 mb-5 p-0" style='
         border-style: solid;
         border-width: 1px;
         border-color: darkblue;
         border-radius: 8px;
             overflow: hidden;
         '>
<div class="row m-0">
    <div class="cel col m-0 pt-1 pb-1 justify-content-start"  style='
         background-color: #4863A0;
         color:white;
         font-weight: 600;
         '>
        VENDAS
    </div>

    @while($counterMonth <= 12)
    <div class='cel col justify-content-end' style='
         background-color: lightblue;
         border-style: solid;
         border-width: 1px;
         border-color: darkblue;
         color: darkblue;
         font-weight: 600;
         font-size: 15px
         '>
                <a style='color: darkblue'  href='{{route('proposal.index', [
                                                                    
                                                                      'status' => 'aprovada',
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

    <div class="cel col pt-1 pb-1 justify-content-end"  style='
         background-color: #4863A0;
         color:white;
         font-size: 15px;
         font-weight: 600;
         '>
        {{formatCurrency($annualRevenues)}}
    </div>
</div>

    
@php
$counterArray = 1;
$counterMonth = 1;
@endphp

@foreach($categories as $category)
<div class="row m-0">
    <div class="cel col justify-content-start" style='
         background-color: lightblue;
         font-weight: 600;
         border-style: solid;
         border-width: 1px;
         border-color: gray;
         '>
        {{$category['name']}}
    </div>
    @foreach($months as $key => $month)
        <div class='cel col justify-content-end' style='
         border-style: solid;
         border-width: 1px;
         border-color: lightgray;
         font-size: 15px
         '>
        <a style="font-size: 13px" ref="{{route('proposal.index', [
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
    <div class="cel col justify-content-end" style='
                  border-style: solid;
         border-width: 1px;
         border-color: gray;
         background-color: lightblue;
         font-weight: 600
         '>
        {{formatCurrency(floatval($category['year']))}}
    </div>
</div>
@endforeach
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