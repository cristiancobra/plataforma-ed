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
<form id="filter" action="{{route('journey.reports')}}" method="post" style="text-align: right">
    @csrf
    <select class="select"name="year">
        <option  class="fields" value="2021">
            2021
        </option>
        <option  class="fields" value="2020">
            2020
        </option>
    </select>
    <a class="text-button secondary" href='{{route('journey.reports')}}'>
        LIMPAR
    </a>
    <input class="text-button secondary" type="submit" value="FILTRAR">
</form>
<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 30%">
            FUNCIONÁRIO 
        </td>
        @foreach ($months as $month)
        <td   class="table-list-header" style="width: 5%">
            {{$month}}
        </td>
        @endforeach
        <td   class="table-list-header" style="width: 10%">
            TOTAL 
        </td>
    </tr>
    <br>
    @php
    $counterArray = 1;
    $counterAnnual = 1;

    foreach ($users as $user) {
    $counterMonth = 1;
    $totalUser = 0;

    echo "<tr style='font-size: 14px'>
        <td class='table-list-left'>";
            echo $user->name;
            echo "</td>";
        while ($counterMonth <= 12) {
        echo "<td class='table-list-right'>";
            echo number_format($monthlyUser[$counterArray] / 3600, 1, ',','.');
            echo "</td>";
        $counterMonth++;
        $counterArray++;
        }
        echo "<td class='table-list-right' style='color:white;background-color: #874983'>";
            echo number_format($annualUser[$counterAnnual] / 3600, 1, ',','.');
            echo "</td></tr>";
    $counterAnnual++;
    }

    $counterArray = 1;
    echo "<tr style='font-size: 14px'>
        <td class='table-list-header' >";
            echo 'TOTAL';
            echo "</td>";
        while ($counterArray <= 12) {
        echo "<td class='table-list-right' style='color:white;background-color: #c28dbf'>";
            echo number_format($monthlyAllUsers[$counterArray] / 3600, 1, ',','.');
            echo "</td>";
        $counterArray++;
        }
        @endphp

        <td class='table-list-right' style='color:white;background-color: #49d194'>
            {{number_format($annualHours / 3600, 1, ',','.')}}
        </td>
    </tr>
</table>
<br>

<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 30%">
            DEPARTAMENTOS 
        </td>
        @foreach ($months as $month)
        <td   class="table-list-header" style="width: 5%">
            {{$month}}
        </td>
        @endforeach
        <td   class="table-list-header" style="width: 10%">
            TOTAL 
        </td>
    </tr>
    @php
    $counterArray = 1;
    $counterAnnual = 1;

    foreach ($departments as $department) {
    $counterMonth = 1;
    $totalCategory = 0;

    echo "<tr style='font-size: 14px'>
        <td class='table-list-left'>
            $department
        </td>
        ";
        while ($counterMonth <= 12) {
        echo "<td class='table-list-right'>";
            echo number_format($monthlyDepartment[$counterArray] / 3600, 1, ',','.');
            echo "</td>";
        $counterMonth++;
        $counterArray++;
        }
        echo "<td class='table-list-right' style='color:white;background-color: #874983'>";
            echo number_format($annualDepartment[$counterAnnual] / 3600, 1, ',','.');
            echo "</td></tr>";
    $counterAnnual++;
    }

    $counterArray = 1;
    echo "<tr style='font-size: 14px'>
        <td class='table-list-header' >";
            echo 'TOTAL';
            echo "</td>";
        while ($counterArray <= 12) {
        echo "<td class='table-list-right' style='color:white;background-color: #c28dbf'>";
            echo number_format($monthlyAllDepartments[$counterArray] / 3600, 1, ',','.');
            echo "</td>";
        $counterArray++;
        }
        @endphp

        <td class='table-list-right' style='color:white;background-color: #49d194'>
            {{number_format($annualHours / 3600, 1, ',','.')}}
        </td>
</table>
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