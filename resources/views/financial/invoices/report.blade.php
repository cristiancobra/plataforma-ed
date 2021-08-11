@extends('layouts/master')

@section('title','PREVISIONAMENTO')

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
<div class="row mt-5">
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
<br>
@php
$counterArray = 1;
$counterMonth = 1;
@endphp
<div class="row mt-1">
    <div class="tb-header col-1 justify-content-start">
        Receitas
    </div>
    @php
    while ($counterMonth <= 12) {
    echo "<div class='tb col justify-content-end'>";
        echo formatCurrency($monthlyRevenues[$counterArray]);
        echo "</div>";
    $counterMonth++;
    $counterArray++;
    }
    @endphp
    <div class='tb tb-header col justify-content-end'>
        {{formatCurrency($annualRevenues)}}
    </div>
</div>
<div class="row mt-1">
    <div class="tb-header col-1 justify-content-start">
        Despesas
    </div>
    @php
    $counterArray = 1;
    $counterMonth = 1;
    while ($counterMonth <= 12) {
    echo "<div class='tb col justify-content-end'>";
        echo formatCurrency($monthlyExpenses[$counterArray]);
        echo "</div>";
    $counterMonth++;
    $counterArray++;
    }
    @endphp
    <div class='tb col justify-content-end'>
        {{formatCurrency($annualExpenses)}}
    </div>
</div>



<div class='table-list-right' style='color:white;background-color: #49d194'>

</div>
</div>
<br>
<br>
<br>
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