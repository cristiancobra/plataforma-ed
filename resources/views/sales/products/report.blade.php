@extends('layouts/master')

@section('title','VENDAS POR PRODUTO')

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
    <div class="col">
        <canvas id="chart" width="400" height="150"></canvas>
    </div>
    <div class="col-5 pt-5">
        <form id="filter" action="{{route('product.report')}}" method="post" style="text-align: right">
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



<!--cabeçalho de mais vendidos-->
<div class="row table-header mt-5">
    <div class="col justify-content-center"  style='font-weight: 600'>
        MAIS VENDIDOS
    </div>
</div>


<!--linhas de mais vendidos-->

@php
$counterArray = 1;
$counterMonth = 1;
@endphp

<div class="container m-0 mt-4 p-0" style='
         border-style: solid;
         border-width: 1px;
         border-color: darkblue;
         border-radius: 8px;
             overflow: hidden;
         '>
<div class="row m-0">
    <div class="cel col-1 m-0 pt-1 pb-1 justify-content-start"  style='
         background-color: #4863A0;
         color:white;
         font-weight: 600;
         '>
        ITENS
    </div>

    @while($counterMonth <= 12)
    <div class='cel col justify-content-end' style='
         background-color: lightblue;
         border-style: solid;
         border-width: 1px;
         border-color: darkblue;
         font-weight: 600;
         font-size: 15px
         '>
        <a href='{{route('proposal.index', [
                                                                    
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

@foreach($products as $product)
<div class="row m-0">
    <div class="cel col-1 justify-content-start" style='
         background-color: lightblue;
         font-weight: 600;
         border-style: solid;
         border-width: 1px;
         border-color: gray;
         '>
        {{$product->name}}
    </div>
    @foreach($months as $key => $month)

            @if($product['monthlys'][$month] != null)
            <div class='cel col justify-content-end' style='
         border-style: solid;
         border-width: 1px;
         border-color: blue;
         background-color: lightblue;
         font-weight: 600;
         font-size: 15px
         '>
            @else
        <div class='cel col justify-content-end' style='
         border-style: solid;
         border-width: 1px;
         border-color: lightgray;
         font-weight: 600;
         font-size: 15px
         '>
            @endif
        <a style="font-size: 13px" ref="{{route('proposal.index', [
                                                            'category' => 'despesa',
                                                            'status' => 'aprovada',
                                                            'type' => 'receita',
                                                            'date_start' => date("$year-$key-01"),
                                                            'date_end' =>  date("$year-$key-t"),
                                                             ])}}">

            
            {{formatCurrency(floatval($product['monthlys'][$month]))}}
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
        {{formatCurrency(floatval($product['year']))}}
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

 

</script>
@endsection