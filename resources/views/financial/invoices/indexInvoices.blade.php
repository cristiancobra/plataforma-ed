@extends('layouts/master')

@section('title','FATURAS')

@section('image-top')
{{asset('images/invoice.png')}} 
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
<div class='row'>
    <div class="tb tb-header-start offset-6 col-2">
        PREVISÃO
    </div>
    <div   class="tb tb-header col-2">
        MÊS
    </div>
    <div   class="tb tb-header-end col-2">
        ANO
    </div>
</div>
<div class='row'>
    <div class="tb offset-6 col-2 justify-content-start">
        RECEITAS:
    </div>
    <div class="tb col-2 justify-content-end">
        + {{formatCurrencyReal($estimatedRevenueMonthly)}}
    </div>
    <div class="tb col-2 justify-content-end">
        + {{formatCurrencyReal($estimatedRevenueYearly)}}
    </div>
</div>
<div class='row'>
    <div class="tb offset-6 col-2 justify-content-start">
        DESPESAS:
    </div>
    <div class="tb col-2 justify-content-end">
        - {{formatCurrencyReal($estimatedExpenseMonthly)}}
    </div>
    <div class="tb col-2 justify-content-end">
        - {{formatCurrencyReal($estimatedExpenseYearly)}}
    </div>
</div>
<div class='row'>
    <div class="tb offset-6 col-2 justify-content-start">
        SALDO:
    </div>
    <div class="tb col-2 justify-content-end">
        {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
    </div>
    <div class="tb col-2 justify-content-end">
        {{formatCurrencyReal($estimatedRevenueYearly - $estimatedExpenseYearly)}}
    </div>
</div>
<br>
<br>
<form id="filter" action="{{route('invoice.filter')}}" method="post" style="text-align: right;display:none">
    @csrf
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
<div>
    <div class='row'>
        <div   class="tb tb-header-start col-1">
            ID
        </div>
        <div   class="tb tb-header col-3">
            OPORTUNIDADE
        </div>
        <div   class="tb tb-header col-2">
            CONTATO
        </div>
        <div   class="tb tb-header col-3">
            CONTRATANTE 
        </div>
        <div   class="tb tb-header col-1">
            VENCIMENTO
        </div>
        <div   class="tb tb-header col-1">
            VALOR
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
            @if($invoice->opportunity)
            {{$invoice->opportunity->name}}
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
        <div class="tb col-3">
        @if(isset($invoice->company))
            {{$invoice->company->name}}
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
        @if($invoice->type == 'receita')
        <div class="tb col-1">
            {{formatCurrencyReal($invoice->installment_value)}}
        </div>
        @else
        <div class="tb col-1" style="color: red">
            - {{formatCurrencyReal($invoice->installment_value)}}
        </div>
        @endif
        
        {{formatInvoiceStatus($invoice)}}
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