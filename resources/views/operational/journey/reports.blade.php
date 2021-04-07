@extends('layouts/master')

@section('title','PRODUTIVIDADE')

@section('image-top')
{{ asset('imagens/journey.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="button-primary"  href="{{route('journey.index')}}">
    VOLTAR
</a>
@endsection

@section('main')
<form action=" {{route('journey.reports')}} " method="post" style="text-align: right;color: #874983">
    @csrf
    <select class="select"name="year">
        <option  class="fields" value="2021">
            2021
        </option>
        <option  class="fields" value="2020">
            2020
        </option>
    </select>
    <input class="btn btn-secondary" type="submit" value="FILTRAR">
</form>
<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 30%">
            <b>FUNCIONÁRIO </b>
        </td>
        @foreach ($months as $month)
        <td   class="table-list-header" style="width: 5%">
            {{$month}}
        </td>
        @endforeach
        <td   class="table-list-header" style="width: 10%">
            <b>TOTAL </b>
        </td>
    </tr>
    <br>
    @php
    $counterArray = 1;

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
            echo number_format($annualUser / 3600, 1, ',','.');
            echo "</td>
    </tr>";
    }

    $counterArray = 1;
    echo "<tr style='font-size: 14px'>
        <td class='table-list-header' >";
            echo 'TOTAL';
            echo "</td>";
        while ($counterArray <= 12) {
        echo "<td class='table-list-right' style='color:white;background-color: #c28dbf'>";
            echo number_format($monthlyTotal[$counterArray] / 3600, 1, ',','.');
            echo "</td>";
        $counterArray++;
        }
        echo "<td class='table-list-right' style='color:white;background-color: #874983'>";
            echo number_format($totalUser / 3600, 1, ',','.');
            echo "</td>
    </tr>";
    @endphp
</table>
<br>

<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 30%">
            <b>DEPARTAMENTOS </b>
        </td>
        @foreach ($months as $month)
        <td   class="table-list-header" style="width: 5%">
            {{$month}}
        </td>
        @endforeach
        <td   class="table-list-header" style="width: 10%">
            <b>TOTAL </b>
        </td>
    </tr>
    @php
    $counterArray = 1;

    foreach ($departments as $department) {
    $counterMonth = 1;
    $totalCategory = 0;

    echo "<tr style='font-size: 14px'>
        <td class='table-list-left'>
            $department
        </td>
        ";
        while ($counterMonth <= 12) {
        echo "<td class='table-list-center'>";
            echo number_format($resultCategories[$counterArray] / 3600, 1, ',','.');
            echo "</td>";
        $totalCategory = $totalCategory + $resultCategories[$counterArray];
        $counterMonth++;
        $counterArray++;
        }
        echo "<td class='table-list-center' style='color:white;background-color: #874983'>";
            echo number_format($totalCategory / 3600, 1, ',','.');
            echo "</td>
    </tr>";
    }
    @endphp
</table>
<br>
<br>
@endsection