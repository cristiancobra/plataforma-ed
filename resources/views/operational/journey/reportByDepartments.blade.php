@extends('layouts/master')

@section('title','PRODUTIVIDADE')

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
    <form id="filter" action="{{route('journey.reportUsers')}}" method="get" style="text-align: right;display:none">
        @csrf
        <select class="select"name="year">
            <option  class="fields" value="2021">
                2021
            </option>
            <option  class="fields" value="2020">
                2020
            </option>
        </select>
        <a class="text-button secondary" href='{{route('journey.reportUsers')}}'>
            LIMPAR
        </a>
        <input class="text-button secondary" type="submit" value="FILTRAR">
    </form>
</div>

<div class='row mt-4'>
    <div class="col-3">
        <canvas id="chart" width="400" height="250"></canvas>
    </div>
    <div class="col-3 pt-5 offset-4">
        <br>
        <span class="labels">{{$annualTotal}}</span> horas executadas em {{date('Y')}} .
        <br>
        <span class="labels">{{$monthlyAverage}}</span> horas de média mensal.
        </p>
    </div>
    <div class="col-2 pt-5">
        <a class='text-button primary' href='{{route('journey.reportUsers')}}'>
            FUNCIONÁRIOS
        </a>
        <br>
        <br>
        <a class='text-button secondary' href='{{route('journey.reportDepartments')}}'>
            DEPARTAMENTOS
        </a>
    </div>
</div>


<div class="row mt-1">
    <div class="tb-header-start col-2">
        DEPARTAMENTOS
    </div>
    @foreach ($months as $month)
    <div class="tb-header col justify-content-center" style="width: 5%">
        {{$month}}
    </div>
    @endforeach
    <div class="tb-header-end col">
        TOTAL 
    </div>
</div>

@foreach($departments as $department)
<div class="row">
    <div class="tb col-2 justify-content-start">
        {{$department['name']}}
    </div>
    @foreach($months as $key => $month)
    <div class="tb col justify-content-end">
        <a href="{{route('journey.index', [
                                                              'department' => $department,
                                                              'start' => date("$year-$key-01"),
                                                              'end' =>  date("$year-$key-t"),
                                                             ])}}">
        {{number_format($department['monthlys'][$month] / 3600, 1, ',','.')}}
        </a>
    </div>
    @endforeach
    <div class="tb col justify-content-end" style='color:white;background-color: #874983;border-color: white'>
        {{number_format($department['year'] / 3600, 1, ',','.')}}
    </div>
</div>
@endforeach

<div class="row">
    <div class="tb-header col-2">
        TOTAL 
    </div>
    @foreach($monthlyTotals as $monthlyTotal)
    <div class="tb-header col justify-content-end" style="width: 5%;border-color: white">
        {{number_format($monthlyTotal / 3600, 1, ',','.')}}
    </div>
    @endforeach
    <div class="tb col justify-content-end" style='color:white;background-color: #49d194;border-color: white'>
        {{$annualTotal}}
    </div>
</div>

@endsection

@section('js-scripts')
<script>
    // esconde/exibe o filtro
    $(document).ready(function () {
    //botao de exibir filtro
    $("#filter_button").click(function () {
    $("#filter").slideToggle(600);
    });
    });
    //gráfico pizza

    var ctx = document.getElementById('chart');
    var chart = new Chart(ctx, {
    type: 'pie',
            data: {
            labels: {!! json_encode($departmentsNames) !!},
                    datasets: [{
                    label: 'Dataset 1',
                            data: [
<?php
foreach ($departments as $department) {
    $result = number_format($department['year'] / 3600, 0, ',', '');
    //    dd($result);
    echo json_encode($result);
    echo ",";
}
?>
                            ],
                            backgroundColor: [
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(255, 99, 132, 1)',
                            ],
                            borderWidth: 2,
                    }
                    ]
            },
            options: {
            responsive: true,
                    plugins: {
                    legend: {
                    position: 'left',
                    },
                            title: {
                            display: true,
                                    text: 'HORAS POR DEPARTAMENTO'
                            }
                    }
            },
    });
</script>
@endsection