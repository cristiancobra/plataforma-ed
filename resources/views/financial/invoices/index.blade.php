@extends('layouts/index')

@section('title','FATURAS')

@section('image-top')
{{asset('images/invoice.png')}} 
@endsection

@section('filter')
<form id="filter" action="{{route('invoice.index')}}" method="get" style="text-align: right;display:none">
    <input type="text" name="name" placeholder="nome da oportunidade" value="">
    <input type="date" name="date_start" size="20" value="{{old('date_start')}}"><span class="fields"></span>
    <input type="date" name="date_end" size="20" value="{{old('date_end')}}"><span class="fields"></span>
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
<div class='col-2 offset-4 d-inline-block tasks-my'>
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
<div class='row mt-2'>
    <div class="tb tb-header-start col">
        PREVISÃO
    </div>
    <div   class="tb tb-header col">
        MÊS
    </div>
    <div   class="tb tb-header-end col">
        ANO
    </div>
</div>
<div class='row'>
    <div class="tb col justify-content-start">
        RECEITAS:
    </div>
    <div class="tb col justify-content-end">
        + {{formatCurrencyReal($estimatedRevenueMonthly)}}
    </div>
    <div class="tb col justify-content-end">
        + {{formatCurrencyReal($estimatedRevenueYearly)}}
    </div>
</div>
<div class='row'>
    <div class="tb col justify-content-start">
        DESPESAS:
    </div>
    <div class="tb col justify-content-end">
        - {{formatCurrencyReal($estimatedExpenseMonthly)}}
    </div>
    <div class="tb col justify-content-end">
        - {{formatCurrencyReal($estimatedExpenseYearly)}}
    </div>
</div>
<div class='row'>
    <div class="tb col justify-content-start">
        SALDO:
    </div>
    <div class="tb col justify-content-end">
        {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
    </div>
    <div class="tb col justify-content-end">
        {{formatCurrencyReal($estimatedRevenueYearly - $estimatedExpenseYearly)}}
    </div>
</div>
</div>
@endsection


@section('table')
<div>
    <div class='row mt-2'>
        <div   class="tb tb-header-start col-1">
            ID
        </div>
        <div   class="tb tb-header col-3">
            PROPOSTA
        </div>
        <div   class="tb tb-header col-2">
            CONTATO
        </div>
        <div   class="tb tb-header col-2">
            EMPRESA 
        </div>
        <div   class="tb tb-header col-1">
            VENCIMENTO
        </div>
        <div   class="tb tb-header col-1">
            TOTAL
        </div>
        <div   class="tb tb-header col-1">
            SALDO
        </div>
        <div   class="tb tb-header-end col-1">
            SITUAÇÃO
        </div>
    </div>

    @foreach ($invoices as $invoice)
    <div class='row'>
        <div class="tb col-1 justify-content-start">
            <button class="button-round">
                <a href=" {{route('invoice.show', ['invoice' => $invoice])}}">
                    <i class='fa fa-eye' style="color:white"></i>
                </a>
            </button>
            {{$invoice->identifier}}
        </div>
        <div class="tb col-3">
            @if(isset($invoice->proposal->name))
            {{$invoice->proposal->name}}
            @else
            não possui
            @endif
        </div>
        <div class="tb col-2">
            @if($invoice->contact)
            {{$invoice->contact->name}}
            @else
            não possui
            @endif
        </div>
        <div class="tb col-2">
            @if(isset($invoice->proposal->company))
            {{$invoice->proposal->company->name}}
            @else
            não possui
            @endif
        </div>
        @if($invoice->status == 'aprovada' AND $invoice->pay_day < date('Y-m-d'))
        <div class="tb col-1" style="color: red">
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </div>
        @else
        <div class="tb col-1">
            {{date('d/m/Y', strtotime($invoice->pay_day))}}
        </div>
        @endif
        
        @if($invoice->totalPrice >= 0)
        <div class="tb col-1 justify-content-end" style="text-align: right">
            {{formatCurrencyReal($invoice->totalPrice)}}
        </div>
        @else
        <div class="tb col-1 justify-content-end" style="color: red;text-align: right">
            {{formatCurrencyReal($invoice->totalPrice)}}
        </div>
        @endif
        
        @if($invoice->totalPrice >= 0)
        <div class="tb col-1 justify-content-end" style="text-align: right">
            {{formatCurrencyReal($invoice->balance)}}
        </div>
        @else
        <div class="tb col-1 justify-content-end" style="color: red;text-align: right">
            {{formatCurrencyReal($invoice->balance)}}
        </div>
        @endif

        <div class="tb col-1" style="color: red;text-align: right">
            <a href=' {{route('invoice.show', ['invoice' => $invoice])}}'>
                {{faiconInvoiceStatus($invoice->status)}}
            </a>
        </div>
    </div>
    @endforeach
</div>
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