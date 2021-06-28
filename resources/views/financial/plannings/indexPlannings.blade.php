@extends('layouts/master')

@section('title','PLANEJAMENTO')

@section('image-top')
{{ asset('images/planning.png') }} 
@endsection

@section('description')
@endsection

@section('buttons')
<a class="circular-button secondary"  href="{{route('planning.create')}}">
    <i class="fa fa-plus" aria-hidden="true"></i>
</a>
@endsection

@section('main')
<table class="table-list">
    <tr>
        <td   class="table-list-header" style="width: 40%">
            Nome 
        </td>
        <td   class="table-list-header" style="width: 5%">
            Quantidade 
        </td>
        <td   class="table-list-header" style="width: 5%">
            Horas previstas
        </td>
        <td   class="table-list-header" style="width: 10%">
            Custos
        </td>
        <td   class="table-list-header" style="width: 10%">
            Imposto
        </td>
        <td   class="table-list-header" style="width: 10%">
            Preço
        </td>
        <td   class="table-list-header" style="width: 10%">
            Margem
        </td>
    </tr>

    @foreach ($plannings as $planning)
    <tr style="font-size: 14px">
        <td class="table-list-left">
            <button class="button">
                <a href=" {{route('planning.show', ['planning' => $planning])}}">
                    <i class='fa fa-eye' style="color:white"></i>
                </a>
            </button>
            <button class="button">
                <a href=" {{route('planning.edit', ['planning' => $planning])}}">
                    <i class='fa fa-edit' style="color:white"></i>
                </a>
            </button>
            {{ $planning->name }}
        </td>

        @if ($planning->due_date == 0)
        <td class="table-list-center">
            imediata
        </td>
        @else
        <td class="table-list-center">
            {{ $planning->due_date }} dias
        </td>
        @endif

        <td class="table-list-center">
            {{ number_format($planning->work_hours)}}
        </td>

        <td class="table-list-right">
            R$ {{ number_format($planning->cost1 + $planning->cost2 + $planning->cost3, 2,",",".") }}
        </td>

        <td class="table-list-right">
            R$ {{ number_format($planning->price * $planning->tax_rate / 100, 2,",",".") }}
        </td>

        <td class="table-list-right">
            R$ {{ number_format(-$planning->price * $planning->tax_rate /100 - $planning->cost1 - $planning->cost2 - $planning->cost3 + $planning->price, 2,",",".") }}
        </td>

        <td class="table-list-right">
            R$ {{ number_format($planning->price,2,",",".") }}
        </td>

    </tr>
    @endforeach
</table>
<p style="text-align: right">
    <br>
    {{ $plannings->links() }}
</p>
<br>
@endsection