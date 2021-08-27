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
<form id='filter' action='{{route('transaction.index')}}' method='get' style='text-align: right;display:none'>
    @csrf
    <input type='text' name='name' placeholder='nome da oportunidade' value=''>
    <input type='date' name='date_start' size='20' value='{{old('date_start')}}'><span class='fields'></span>
    <input type='date' name='date_end' size='20' value='{{old('date_end')}}'><span class='fields'></span>
    {{createFilterSelectModels('company_id', 'select', $companies, 'Todas as empresas')}}
    {{createFilterSelectModels('bank_account_id', 'select', $bankAccounts, 'Todas as contas')}}
    {{returnType('type', 'select', 'transaction')}}
    <br>
    <a class='text-button secondary' href='{{route('transaction.index')}}'>
        LIMPAR
    </a>
    <input class='text-button primary' type='submit' value='FILTRAR'>
</form>
<div class='row mt-3'>
    <div class='tb tb-header-start col-2'>
        DATA
    </div>
    <div class='tb tb-header col-4'>
        OPORTUNIDADE
    </div>
    <div class='tb tb-header col-1'>
        FATURA
    </div>
    <div class='tb tb-header col-2'>
        CONTA BANCÁRIA
    </div>
    <div class='tb tb-header col-2'>
        ORIGEM / DESTINO
    </div>
    <div class='tb tb-header-end col-1'>
        VALOR
    </div>
</div>

@foreach ($transactions as $transaction)
<div class='row'>
    <div class='tb col-2'>
        <a class='white' href=' {{route('transaction.show', ['transaction' => $transaction->id])}}'>
            <button class='button-round'>
                <i class='fa fa-eye'></i>
            </button>
            {{dateBr($transaction->pay_day)}}
        </a>
    </div>
    <div class='tb col-4'>
        @if(isset($transaction->invoice->opportunity))
        <a href=' {{route('opportunity.show', ['opportunity' => $transaction->invoice->opportunity_id])}}'>
            {{$transaction->invoice->opportunity->name}}
        </a>
        @else
        não possui
        @endif
    </div>
    <div class='tb col-1'>
        @if($transaction->invoice_id != null)
        <a class='white' href=' {{route('invoice.show', ['invoice' => $transaction->invoice_id])}}'>
            {{$transaction->invoice_id}}
        </a>
        @else
        não possui
        @endif
    </div>
    <div class='tb col-2'>
        @if($transaction->bankAccount)
        <a class='white' href=' {{route('bankAccount.show', ['bankAccount' => $transaction->bankAccount->id])}}'>
            {{$transaction->bankAccount->name}}
        </a>
        @else
        conta excluída
        @endif
    </div>
    <div class='tb col-2'>
        @if(isset($transaction->invoice->company->name))
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
    <div class='tb col-1 justify-content-end' style='color:red'>
        {{formatCurrencyReal($transaction->value)}}
    </div>
    @else
    <div class='tb col-1 justify-content-end'>
        {{formatCurrencyReal($transaction->value)}}
    </div>
    @endif
</div>
@endforeach
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