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
{{createButtonBack()}}
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
    <div class="col-7">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
    <div class="col-3 pt-5">
        <br>
        <span class="labels">{{$annualTotal}}</span> horas executadas em {{date('Y')}} .
        <br>
        <span class="labels">{{$monthlyAverage}}</span> horas de média mensal.
        </p>
    </div>
    <div class="col-2 pt-5">
        <a class='text-button secondary' href='{{route('journey.reportUsers')}}'>
            FUNCIONÁRIOS
        </a>
        <br>
        <br>
        <a class='text-button primary' href='{{route('journey.reportDepartments')}}'>
            DEPARTAMENTOS
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="tb-header-start col-2">
        FUNCIONÁRIOS
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

@foreach($users as $key => $user)
<div class="row">
    <div class="tb col-2 justify-content-start">
        {{$user->contact->name}}
    </div>

    @for($i = 1; $i <= 12; $i++)
    <div class="tb col justify-content-end">
        <a href="{{route('journey.index', [
                                                              'user_id' => $user->id,
                                                              'start' => date("$year-$i-01"),
                                                              'end' =>  date("$year-$i-t"),
                                                             ])}}">
            {{number_format($user["$month $i"] / 3600, 1, ',','.')}}
        </a>
    </div>
    @endfor
    <div class="tb col justify-content-end" style='color:white;background-color: #874983;border-color: white'>
        {{number_format($user['year'] / 3600, 1, ',','.')}}
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
    $(document).ready(function () {
        //botao de exibir filtro
        $("#filter_button").click(function () {
            $("#filter").slideToggle(600);
        });
    });
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
        type: 'bar',
        data: {
            labels: {!! json_encode($namesMonths) !!},
            datasets: [


@foreach ($users as $key => $user)
            {
                    label: {{$user->contact->name}},
                    data: [


    @for ($i = 1; $i <= 12; $i++)
    {{number_format($user["$month $i"] / 3600, 0, ',', '')}},
    @endfor
   
                    ],
                    backgroundColor: [
                        '$chartBackgroundColors[{{$key}}]',
                    ],
                    borderColor: [
                        '$chartBorderColors[{{$key}}]',
                    ],
                    borderWidth: 2,
                },
    @endforeach
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
                    text: 'TOTAL DE HORAS POR MÊS'
                }
            },
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true
                }
            }
        },
    });
</script>
@endsection