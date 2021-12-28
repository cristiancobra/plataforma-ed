@extends('layouts/index')

@section('title','FATURAS')

@section('image-top')
{{asset('images/invoice.png')}} 
@endsection

@section('filter')
<form id="filter" action="{{route('invoice.index')}}" method="get" style="text-align: right;display:none">
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    <input type="date" name="date_start" size="20" value="{{old('date_start')}}">
    <input type="date" name="date_end" size="20" value="{{old('date_end')}}">
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('contact_id', 'select', $contacts, 'Todas os contatos')}}
    {{createFilterSelect('status', 'select', returnInvoiceStatusToFilter(), 'Todas as situações')}}
    {{returnType('type', 'select', 'invoice')}}
    <br>
    <a class="text-button secondary" href='{{route('invoice.index')}}'>
        LIMPAR
    </a>
    <input class="text-button primary" type="submit" value="FILTRAR">
</form>
@endsection

@section('buttons')
<a class='circular-button secondary'  href="{{route('invoice.index', ['trash' => 1])}}">
    <i class="fa fa-trash-restore" aria-hidden="true"></i>
</a>
<a id='filter_button' class='circular-button secondary'>
    <i class="fa fa-filter" aria-hidden="true"></i>
</a>
<a class="circular-button secondary" style="background-color: lightblue" href="{{route('proposal.create', ['type' => 'despesa'])}}">
    <i class="fas fa-minus"></i>
</a>
<a class="circular-button primary"  style="background-color: lightblue" href="{{route('proposal.create', ['type' => 'receita'])}}">
    <i class="fas fa-plus"></i>
</a>

{{createButtonList('invoice')}}
@endsection

@section('shortcuts')
<div class='col-2 offset-4 d-inline-block tasks-my mt-3 mb-5 me-5'>
    <a style='text-decoration:none' href='{{route('invoice.index', [
				'date_start' => $monthStart,
				'date_end' => $monthEnd,
				])}}'>
        <p class='panel-text' style="font-size: 20px">
            MÊS
            <br>
            ATUAL
        </p>
    </a>
</div>
<div class='col-6'>
    <div class='row  table-header mb-2' style="background-color: {{$principalColor}}">
    <div class='col-1'>
            PREVISÃO
        </div>
        <div   class="cel col">
            MÊS
        </div>
        <div   class="cel col">
            ANO
        </div>
    </div>
    <div class='row'>
        <div class="cel col justify-content-start">
            RECEITAS:
        </div>
        <div class="cel col justify-content-end">
            + {{formatCurrencyReal($estimatedRevenueMonthly)}}
        </div>
        <div class="cel col justify-content-end">
            + {{formatCurrencyReal($estimatedRevenueYearly)}}
        </div>
    </div>
    <div class='row'>
        <div class="cel col justify-content-start">
            DESPESAS:
        </div>
        <div class="cel col justify-content-end">
            - {{formatCurrencyReal($estimatedExpenseMonthly)}}
        </div>
        <div class="cel col justify-content-end">
            - {{formatCurrencyReal($estimatedExpenseYearly)}}
        </div>
    </div>
    <div class='row'>
        <div class="cel col justify-content-start">
            SALDO:
        </div>
        <div class="cel col justify-content-end">
            {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
        </div>
        <div class="cel col justify-content-end">
            {{formatCurrencyReal($estimatedRevenueYearly - $estimatedExpenseYearly)}}
        </div>
    </div>
</div>
@endsection


@section('table')
<div class='row  table-header mt-5 mb-2' style="background-color: {{$principalColor}}">
    <div class='col-1'>
        ID
    </div>
    <div   class="col-3">
        PROPOSTA
    </div>
    <div   class="col-2">
        CONTATO
    </div>
    <div   class="col-2">
        EMPRESA 
    </div>
    <div   class="col-1">
        VENCIMENTO
    </div>
    <div   class="col-1">
        TOTAL
    </div>
    <div   class="col-1">
        SALDO
    </div>
    <div   class="col-1">
        SITUAÇÃO
    </div>
</div>

@foreach ($invoices as $invoice)
<div class="row table2 position-relative"  style="
     color: {{$principalColor}};
     border-left-color: {{$complementaryColor}}
     ">
    <a class="stretched-link "href=" {{route('invoice.show', ['invoice' => $invoice])}}">
    </a>
    <div class='cel col-1'>
        {{$invoice->identifier}}
    </div>
    <div class="cel col-3">
        @if(isset($invoice->proposal->name))
        {{$invoice->proposal->name}}
        @else
        não possui
        @endif
    </div>
    <div class="cel col-2">
        @if($invoice->contact)
        {{$invoice->contact->name}}
        @else
        não possui
        @endif
    </div>
    <div class="cel col-2">
        @if(isset($invoice->proposal->company))
        {{$invoice->proposal->company->name}}
        @else
        não possui
        @endif
    </div>
    @if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
    <div class="cel col-1" style="color: red">
        {{date('d/m/Y', strtotime($invoice->pay_day))}}
    </div>
    @else
    <div class="cel col-1">
        {{date('d/m/Y', strtotime($invoice->pay_day))}}
    </div>
    @endif

    @if($invoice->totalPrice >= 0)
    <div class="cel col-1 justify-content-end" style="text-align: right">
        {{formatCurrencyReal($invoice->totalPrice)}}
    </div>
    @else
    <div class="cel col-1 justify-content-end" style="color: red;text-align: right">
        {{formatCurrencyReal($invoice->totalPrice)}}
    </div>
    @endif

    @if($invoice->totalPrice >= 0)
    <div class="cel col-1 justify-content-end" style="text-align: right">
        {{formatCurrencyReal($invoice->balance)}}
    </div>
    @else
    <div class="cel col-1 justify-content-end" style="color: red;text-align: right">
        {{formatCurrencyReal($invoice->balance)}}
    </div>
    @endif

    <div class="cel col-1" style="color: red;text-align: right">
        <a href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
            {{faiconInvoiceStatus($invoice->status)}}
        </a>
    </div>
</div>
@endforeach
<p style="text-align: right">
    <br>
    {{$invoices->links()}}
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