@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('imagens/planning.png') }} 
@endsection

@section('description')
<a class='btn btn-primary' href='{{route('planning.index')}}'>VER PLANEJAMENTOS</a>
@endsection

@section('main')
<h1 class='name'>
    {{$planning->name}}
</h1>
<br>
<label class='labels' for='' >PREVISÃO EM MESES:</label>
<input type='integer' name='months' size='5' value='{{$planning->months}}'><span class='fields'></span>
<br>
<p class='fields' for='' >Escolha a extensão do seu planejamento pela quantidade de meses (1 ano = 12, trimestre = 3, etc))</p>
<br>
<label class='labels' for='' >META DE VENDAS MENSAL</label>
<br>
<p class='fields' for='' >Estabeleça uma META de vendas de cada produto que consiga pagar suas despensas  e gerar lucro. </p>
<br>
<table class='table-list'>
    <tr>
        <td   class='table-list-header' style='width: 40%'>
            Nome 
        </td>
        <td   class='table-list-header' style='width: 5%'>
            Quantidade 
        </td>
        <td   class='table-list-header' style='width: 5%'>
            Horas previstas
        </td>
        <td   class='table-list-header' style='width: 10%'>
            Custos
        </td>
        <td   class='table-list-header' style='width: 10%'>
            Imposto
        </td>
        <td   class='table-list-header' style='width: 10%'>
            Preço
        </td>
        <td   class='table-list-header' style='width: 10%'>
            Margem
        </td>
    </tr>

    @while ($planning->$name != null)
    <tr style='font-size: 14px'>
        <td class='table-list-left'>
            {{ $planning->$name }}
        </td>

        <td class='table-list-center'>
            {{ $planning->$amount }}
        </td>

        <td class='table-list-center'>
            {{ number_format($planning->$hours)}}
        </td>

        <td class='table-list-right'>
            {{ number_format($planning->$cost, 2,',','.') }}
        </td>

        <td class='table-list-right'>
            {{ number_format($planning->$tax_rate, 2,',','.') }}
        </td>

        <td class='table-list-right'>
            {{ number_format($planning->$price,2,',','.') }}
        </td>

        <td class='table-list-right'>
            {{ number_format($planning->$price - $planning->$tax_rate - $planning->$cost, 2,',','.') }}
        </td>

        @php
        $name++;
        $amount++;
        $hours++;
        $cost++;
        $tax_rate++;
        $price++;
        @endphp
        @endwhile
    </tr>
    <tr>
        <td   class='table-list-header'>

        </td>
        <td   class='table-list-header'>
            {{$planning->totalAmount}}
        </td>
        <td   class='table-list-header'>
            {{number_format($planning->totalHours) }}
        </td>
        <td   class='table-list-header-right'>
            R$ {{number_format($planning->totalCost, 2,',','.') }}
        </td>
        <td   class='table-list-header-right'>
            R$ {{number_format($planning->totalTax_rate, 2,',','.') }}
        </td>
        <td   class='table-list-header-right'>
            R$ {{number_format($planning->totalPrice, 2,',','.') }}
        </td>
        <td   class='table-list-header-right'>
            R$ {{number_format($planning->totalMargin, 2,',','.') }}
        </td>
    </tr>
</table>
<br>
<p style='text-align: right'>
    <label class='labels' for=''>DESPESAS MENSAIS:</label>
    <span class='fields'>R$ {{number_format($planning->expenses, 2,',','.') }}</span>
</p>
<p style='text-align: right'>
    <label class='labels' for=''>SALDO:</label>
    <span class='fields'>R$ {{number_format($planning->totalBalance, 2,',','.') }}</span>
</p>
<label class='labels' for=''>SITUAÇÃO:</label>
<span class='fields'>{{$planning->status }}</span>
<br>
<br>
<p class='labels'>  Criado em:   {{ date('d/m/Y H:i', strtotime($planning->created_at)) }} </p>

<div style='text-align:right;padding: 2%'>
    <form   style='text-decoration: none;display: inline-block' action='{{ route('planning.destroy', ['planning' => $planning->id]) }}' method='post'>
        @csrf
        @method('delete')
        <input class='btn btn-danger' type='submit' value='APAGAR'>
    </form>
    <a class='btn btn-secondary' href=' {{ route('planning.edit', ['planning' => $planning->id]) }} '  style='text-decoration: none;color: white;display: inline-block'>
        <i class='fa fa-edit'></i>EDITAR</a>
    <a class='btn btn-secondary' href='{{route('planning.index')}}'><i class='fas fa-arrow-left'></i></a>
</div>
<br>

@endsection