@extends('layouts/index')

@section('title','MOVIMENTAÇÕES')

@section('image-top')
{{ asset('images/transaction.png') }} 
@endsection

@section('description')
Total: <span class='labels'></span>
@endsection

@section('buttons')
{{createButtonTrashIndex($trashStatus, 'transaction')}}
<a id='filter_button' class='circular-button secondary'>
    <i class='fa fa-filter' aria-hidden='true'></i>
</a>
<a id='export' class='circular-button secondary' href='{{route('transaction.export')}}' onclick='exportTasks(event.target);'>
    <i class='fa fa-table' aria-hidden='true'></i>
</a>
<a class='circular-button secondary' href='{{route('transaction.createTransfer', ['typeTransactions' => 'transferência'])}}'>
    <i class='fas fa-sync'></i>
</a>
<a class='circular-button secondary' href='{{route('transaction.create', ['typeTransactions' => 'despesa'])}}'>
    <i class='fas fa-minus'></i>
</a>
<a class='circular-button primary'  href='{{route('transaction.create', ['typeTransactions' => 'receita'])}}'>
    <i class='fas fa-plus'></i>
</a>
@endsection

@section('shortcuts')
<div class='col1' style='display: inline-block;text-align:right;vertical-align:top;width: 10%'>
    <img src='{{asset('images/financial-planning.png')}}' style='display:block;margin:auto;width:80%'>
</div>
<div class='col1' style='display: inline-block;vertical-align:top;width: 20%'>
    <p class='labels' style='text-align:center'>
        FATURAS DE {{strtoupper(returnMonth(date('m')))}}:
    </p>
    <p style='text-align:right;font-size:14px'>
        RECEITAS:	+ {{formatCurrencyReal($estimatedRevenueMonthly)}}
        <br>
        DESPESAS: - {{formatCurrencyReal($estimatedExpenseMonthly)}}
        <br>
        SALDO: {{formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly)}}
        <br>
</div>
<div class='col1' style='display: inline-block;text-align:right;vertical-align:top;width: 10%'>
    <img src='{{asset('images/invoice.png')}}' style='display:block;margin:auto;width:80%'>
</div>
<div class='col1' style='display: inline-block;vertical-align:top;width: 20%'>
    <p class='labels' style='text-align:center'>
        REALIZADO EM {{strtoupper(returnMonth(date('m')))}}:
    </p>
    <p style='text-align:right;font-size:14px'>
        RECEITAS:	+ {{formatCurrencyReal($revenueMonthly)}}
        <br>
        DESPESAS: {{formatCurrencyReal($expenseMonthly)}}
        <br>
        SALDO: {{formatCurrencyReal($revenueMonthly + $expenseMonthly)}}
        <br>
    </p>
</div>
<div class='col1' style='display: inline-block;text-align:right;vertical-align:top;width: 10%'>
    <img src='{{asset('images/financeiro.png')}}' style='display:block;margin:auto;width:80%'>
</div>
<div class='col1' style='display: inline-block;vertical-align:top;width: 20%'>
    <p class='labels' style='text-align:center'>
        DISPONÍVEL EM CAIXA:
    </p>
    <p style='text-align:right;font-size:14px'>
        @foreach($bankAccounts as $bankAccount)
        {{$bankAccount->name}}: {{formatCurrencyReal($bankAccount->balance)}}
        <br>
        @endforeach
    </p>
</div>
@endsection

@section('table')
<form id='filter' action='{{route('transaction.index')}}' method='get'display:none'>
    @csrf
    <div class="row">
        <div class="col">
            <label class='labels' for='name'>
                NOME
            </label>
            <input type='text' name='name' placeholder='nome da oportunidade'style="width:100%" value=''>
        </div>
        </div>
        <div class="row mt-4">
        <div class="col-2">
            <label class='labels' for='date_start'>
                INÍCIO
            </label>
            <br>
            <input type='date' name='date_start' size='20' value='{{old('date_start')}}'><span class='fields'></span>
        </div>
        <div class="col-2">
            <label class='labels' for='date_end'>
                FIM
            </label>
            <br>
            <input type='date' name='date_end' size='20' value='{{old('date_end')}}'><span class='fields'></span>
        </div>
        <div class="col-2">
            <label class='labels' for='company_id'>
                EMPRESAS
            </label>
            <br>
            {{createFilterSelectModels('company_id', 'select', $companies, 'todas')}}
        </div>
        <div class="col-2">
            <label class='labels' for='contact_id'>
                CONTATO
            </label>
            <br>
            {{createFilterSelectModels('contact_id', 'select', $contacts, 'todas')}}
        </div>
        <div class="col-2">
            <label class='labels' for='bank_account_id'>
                CONTA BANCÁRIA
            </label>
            <br>
            {{createFilterSelectModels('bank_account_id', 'select', $bankAccounts, 'todas')}}
        </div>
        <div class="col-2">
            <label class='labels' for='type'>
                TIPO
            </label>
            <br>
            {{createFilterSelect('type', 'select', $types, 'todos')}}
        </div>
    </div>
        <div class="row mt-4">
        <div class="col d-flex justify-content-end">
            <a class='text-button secondary' href='{{route('transaction.index')}}'>
                LIMPAR
            </a>
            <input class='text-button primary' type='submit' value='FILTRAR'>
        </div>
    </div>
</form>
<div class='row  table-header mt-5 mb-2' style="background-color: {{$complementaryColor}}">
    <div class='col-2'>
        DATA
    </div>
    <div class='col-4'>
        OPORTUNIDADE
    </div>
    <div class='col-1'>
        FATURA
    </div>
    <div class='col-2'>
        CONTA BANCÁRIA
    </div>
    <div class='col-2'>
        ORIGEM / DESTINO
    </div>
    <div class='col-1'>
        VALOR
    </div>
</div>

@foreach ($transactions as $transaction)
<div class="row table2 position-relative"  style="
     color: {{$principalColor}};
     border-left-color: {{$complementaryColor}}
     ">
    <a class='stretched-link' href=' {{route('transaction.show', ['transaction' => $transaction->id])}}'>
    </a>
    <div class='cel col-2'>
        {{dateBr($transaction->pay_day)}}
    </div>
    <div class='cel col-4'>
        @if(isset($transaction->invoice->opportunity))
        <a href=' {{route('opportunity.show', ['opportunity' => $transaction->invoice->opportunity_id])}}'>
            {{$transaction->invoice->opportunity->name}}
        </a>
        @else
        não possui
        @endif
    </div>
    <div class='cel col-1'>
        @if($transaction->invoice_id != null)
        <a class='white' href=' {{route('invoice.show', ['invoice' => $transaction->invoice_id])}}'>
            {{$transaction->invoice_id}}
        </a>
        @else
        não possui
        @endif
    </div>
    <div class='cel col-2'>
        @if($transaction->bankAccount)
        <a class='white' href=' {{route('bankAccount.show', ['bankAccount' => $transaction->bankAccount->id])}}'>
            {{$transaction->bankAccount->name}}
        </a>
        @else
        conta excluída
        @endif
    </div>
    <div class='cel col-2'>
        @if(app('request')->input('contact_id'))
        <a class='white' href=' {{route('contact.show', ['contact' => app('request')->input('contact_id')])}}'>
            {{$transaction->invoice->contact->name}}
        </a>
        @elseif(isset($transaction->invoice->company->name))
        <a class='white' href=' {{route('company.show', ['company' => $transaction->invoice->company->id])}}'>
            {{$transaction->invoice->company->name}}
        </a>
        @elseif(isset($transaction->invoice->contact->name))
        <a class='white' href=' {{route('contact.show', ['contact' => $transaction->invoice->contact->id])}}'>
            {{$transaction->invoice->contact->name}}
        </a>
        @elseif($transaction->type == 'transferência')
        {{$transaction->account->name}}
        @else
        Não possui
        @endif
    </div>
    @if($transaction->value < 1)
    <div class='cel col-1 justify-content-end' style='color:red'>
        {{formatCurrencyReal($transaction->value)}}
    </div>
    @else
    <div class='cel col-1 justify-content-end'>
        {{formatCurrencyReal($transaction->value)}}
    </div>
    @endif
</div>
@endforeach

<div class='row  table-header mt-5 mb-2' style="background-color: {{$complementaryColor}}">
    <div class='offset-9 col-1'>
        TOTAL
    </div>
    <div class='col-2 justify-content-end pe-0'>
        {{formatCurrencyReal($transactionsTotal)}}
    </div>
</div>

@endsection

@section('paginate', $transactions->links())

@section('js-scripts')
<script>
    $(document).ready(function () {
        //botao de exibir filtro
        $('#filter_button').click(function () {
            $('#filter').slideToggle(600);
        });

    });

// exportar em CSV
    function exportTasks(_this) {
        let _url = $(_this).data('href');
        window.location.href = _url;
    }
</script>
@endsection