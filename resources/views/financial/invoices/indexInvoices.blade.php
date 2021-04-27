@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{asset('imagens/invoice.png')}} 
@endsection

@section('description')
Total: <span class="labels">{{$total}}</span>
@endsection

@section('buttons')
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button secondary"  href="{{route('invoice.create', ['typeInvoices' => 'despesa'])}}">
    <i class="fas fa-minus"></i>
</a>
<a class="circular-button primary"  href="{{route('invoice.create', ['typeInvoices' => 'receita'])}}">
    <i class="fas fa-plus"></i>
</a>
@endsection

@section('main')
<div>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width:70%">
                PREVISÃO
            </td>
            <td   class="table-list-header" style="width:15%">
                MÊS
            </td>
            <td   class="table-list-header" style="width:15%">
                ANO
            </td>
        </tr>
        <tr>
            <td class="table-list-left">
                RECEITAS:
            </td>
            <td class="table-list-right">
                + {{formatCurrencyReal($estimatedRevenueMonthly)}}
            </td>
            <td class="table-list-right">
                + {{formatCurrencyReal($estimatedRevenueYearly)}}
            </td>
        </tr>
        <tr>
            <td class="table-list-left">
                DESPESAS:
            </td>
            <td class="table-list-right">
                - {{formatCurrencyReal($estimatedExpenseMonthly)}}
            </td>
            <td class="table-list-right">
                - {{formatCurrencyReal($estimatedExpenseYearly)}}
            </td>
        </tr>
        <tr>
            <td class="table-list-left">
                SALDO:
            </td>
            <td class="table-list-right">
                {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
            </td>
            <td class="table-list-right">
                {{formatCurrencyReal($estimatedRevenueYearly - $estimatedExpenseYearly)}}
            </td>
        </tr>
    </table>
</div>
<br>
<br>
<form id="filter" action="{{route('invoice.filter')}}" method="post" style="text-align: right;color: #874983">
    @csrf
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    <input type="date" name="date_start" size="20" value="{{old('date_start')}}"><span class="fields"></span>
    <input type="date" name="date_end" size="20" value="{{old('date_end')}}"><span class="fields"></span>
    {{createFilterSelectModels('account_id', 'select', $accounts, 'Minhas empresas')}}
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelect('status', 'select', returnInvoiceStatus(), 'Todas as situações')}}
    {{returnType('type', 'select', 'invoice')}}
    <br>
    <a class="text-button secondary" href='{{route('invoice.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
<div>
    <br>
    <table class="table-list">
        <tr>
            <td   class="table-list-header" style="width:10%">
                ID
            </td>
            <td   class="table-list-header" style="width:15%">
                OPORTUNIDADE
            </td>
            <td   class="table-list-header" style="width:15%">
                CONTATO
            </td>
            <td   class="table-list-header" style="width:15%">
                CONTRATANTE 
            </td>
            <td   class="table-list-header" style="width:15%">
                EMPRESA
            </td>
            <td   class="table-list-header" style="width:10%">
                VENCIMENTO
            </td>
            <td   class="table-list-header" style="width:10%">
                VALOR
            </td>
            <td   class="table-list-header" style="width:10%">
                SITUAÇÃO
            </td>
        </tr>

        @foreach ($invoices as $invoice)
        <tr style="font-size: 14px">
            <td class="table-list-left">
                <button class="button-round">
                    <a href=" {{route('invoice.show', ['invoice' => $invoice])}}">
                        <i class='fa fa-eye' style="color:white"></i>
                    </a>
                </button>
                {{$invoice->identifier}}
            </td>
            @if($invoice->opportunity)
            <td class="table-list-center">
                {{$invoice->opportunity->name}}
            </td>
            @else
            <td class="table-list-center">
                não possui
            </td>
            @endif
            @if($invoice->contact)
            <td class="table-list-center">
                {{$invoice->contact->name}}
            </td>
            @else
            <td class="table-list-center">
                não possui
            </td>
            @endif
            @if(isset($invoice->company))
            <td class="table-list-center">
                {{$invoice->company->name}}
            </td>
            @else
            <td class="table-list-center">
                não possui
            </td>
            @endif
            <td class="table-list-center">
                {{$invoice->account->name}}
            </td>
            @if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
            <td class="table-list-center" style="color: red">
                {{date('d/m/Y', strtotime($invoice->pay_day))}}
            </td>
            @else
            <td class="table-list-center">
                {{date('d/m/Y', strtotime($invoice->pay_day))}}
            </td>
            @endif
            @if($invoice->type == 'receita')
            <td class="table-list-right">
                {{formatCurrencyReal($invoice->installment_value)}}
            </td>
            @else
            <td class="table-list-right" style="color: red">
                - {{formatCurrencyReal($invoice->installment_value)}}
            </td>
            @endif
            @if($invoice->paid >= $invoice->installment_value)
            <td class="td-paid">
                paga
            </td>
            @elseif($invoice->paid > 0 AND $invoice->paid <= $invoice->installment_value)
            <td class="td-paid-partial">
                parcial
            </td>
            @else
            {{formatInvoiceStatus($invoice)}}
            @endif
        </tr>
        @endforeach
    </table>
    <p style="text-align: right">
        <br>
        {{ $invoices->links() }}
    </p>
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