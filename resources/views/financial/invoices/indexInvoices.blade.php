@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{ asset('imagens/invoice.png') }} 
@endsection

@section('description')
Total: <span class="labels">{{$totalInvoices}}</span>
@endsection

@section('buttons')
<a class="circular-button primary"  href="{{route('invoice.create', ['typeInvoices' => 'receita'])}}">
    CRIAR RECEITA
</a>
<a class="circular-button primary"  href="{{route('invoice.create', ['typeInvoices' => 'despesa'])}}">
    CRIAR DESPESA
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
<form action="{{route('invoice.index')}}" method="post" style="text-align: right;color: #874983">
    @csrf
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    <input type="date" name="date_start" size="20" value="{{old('date_start')}}"><span class="fields"></span>
    <input type="date" name="date_end" size="20" value="{{old('date_end')}}"><span class="fields"></span>
    <select class="select" name="account_id">
        <option  class="select" value="">
            Minhas empresas
        </option>
        @foreach ($accounts as $account)
        <option  class="select" value="{{$account->id}}">
            {{$account->name}}
        </option>
        @endforeach
        <option  class="select" value="">
            todas
        </option>
    </select>
    <select class="select" name="company_id">
        <option  class="select" value="">
            Qualquer empresa
        </option>
        @foreach ($companies as $company)
        <option  class="select" value="{{$company->id}}">
            {{$company->name}}
        </option>
        @endforeach
        <option  class="fields" value="">
            todas
        </option>
    </select>
    {{createFilterSelect('status', 'select', returnInvoiceStatus())}}
    {{returnType('type', 'select', 'invoice')}}
    <br>
    <input class="btn btn-secondary" type="submit" value="FILTRAR">
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
            <td class="table-list-center">
                {{date('d/m/Y', strtotime($invoice->pay_day))}}
            </td>
            @if($invoice->type == 'receita')
            <td class="table-list-right">
                {{formatCurrencyReal($invoice->installment_value)}}
            </td>
            @else
            <td class="table-list-right" style="color: red">
                - {{formatCurrencyReal($invoice->installment_value)}}
            </td>
            @endif
            @if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
            <td class="td-late">
                atrasada
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