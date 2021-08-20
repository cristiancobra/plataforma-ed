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
{{createButtonBack()}}
{{createButtonList('journey')}}
@endsection

@section('main')
<div class='row'>
    <form id="filter" action="{{route('invoice.report')}}" method="post" style="text-align: right">
        @csrf
        <select class="select"name="year">
            <option  class="fields" value="2021">
                2021
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
            REALIZADO
        </a>
        <br>
        <br>
        <a class='text-button primary' href='{{route('journey.reportDepartments')}}'>
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
        <a href='{{route('invoice.index', [
                                                                    
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
        <a href='{{route('invoice.index', [
                                                                    
                                                                      'status' => 'aprovada',
                                                                      'type' => 'despesa',
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

@endsection

@section('js-scripts')
<script>
    $(document).ready(function () {
        //botao de exibir filtro
        $("#filter_button").click(function () {
            $("#filter").slideToggle(600);
        });

    });
</script>
@endsection