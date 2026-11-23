@extends('layouts/index')

@section('title', 'MOVIMENTAÇÕES')

@section('image-top')
    <i class="fas fa-exchange-alt"></i>
@endsection

@section('description')
    Total: <span class='labels'></span>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'transaction'" />
    <x-buttons.icon icon="fa fa-table" title="Exportar" :href="route('transaction.export')" :principalColor="$principalColor" />
    <x-buttons.icon icon="fas fa-sync" title="Nova transferência" :href="route('transaction.createTransfer', ['typeTransactions' => 'transferência'])" :principalColor="$principalColor" />
    <x-buttons.icon icon="fas fa-minus" title="Nova despesa" :href="route('transaction.create', ['typeTransactions' => 'despesa'])" :principalColor="$principalColor" />
    <x-buttons.icon icon="fas fa-plus" title="Nova receita" :href="route('transaction.create', ['typeTransactions' => 'receita'])" :principalColor="$principalColor" />
@endsection

@section('shortcuts')
    <div class='col1' style='display: inline-block;text-align:right;vertical-align:top;width: 10%'>
        <img src='{{ asset('images/financial-planning.png') }}' style='display:block;margin:auto;width:80%'>
    </div>
    <div class='col1' style='display: inline-block;vertical-align:top;width: 20%'>
        <p class='labels' style='text-align:center'>
            FATURAS DE {{ strtoupper(returnMonth(date('m'))) }}:
        </p>
        <p style='text-align:right;font-size:14px'>
            RECEITAS: + {{ formatCurrencyReal($estimatedRevenueMonthly) }}
            <br>
            DESPESAS: - {{ formatCurrencyReal($estimatedExpenseMonthly) }}
            <br>
            SALDO: {{ formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly) }}
            <br>
    </div>
    <div class='col1' style='display: inline-block;text-align:right;vertical-align:top;width: 10%'>
        <img src='{{ asset('images/invoice.png') }}' style='display:block;margin:auto;width:80%'>
    </div>
    <div class='col1' style='display: inline-block;vertical-align:top;width: 20%'>
        <p class='labels' style='text-align:center'>
            REALIZADO EM {{ strtoupper(returnMonth(date('m'))) }}:
        </p>
        <p style='text-align:right;font-size:14px'>
            RECEITAS: + {{ formatCurrencyReal($revenueMonthly) }}
            <br>
            DESPESAS: {{ formatCurrencyReal($expenseMonthly) }}
            <br>
            SALDO: {{ formatCurrencyReal($revenueMonthly + $expenseMonthly) }}
            <br>
        </p>
    </div>
    <div class='col1' style='display: inline-block;text-align:right;vertical-align:top;width: 10%'>
        <img src='{{ asset('images/financeiro.png') }}' style='display:block;margin:auto;width:80%'>
    </div>
    <div class='col1' style='display: inline-block;vertical-align:top;width: 20%'>
        <p class='labels' style='text-align:center'>
            DISPONÍVEL EM CAIXA:
        </p>
        <p style='text-align:right;font-size:14px'>
            @foreach ($bankAccounts as $bankAccount)
                {{ $bankAccount->name }}: {{ formatCurrencyReal($bankAccount->balance) }}
                <br>
            @endforeach
        </p>
    </div>
@endsection

@section('filter')
    <x-table.filter :action="route('transaction.index')" :reset-url="route('transaction.index')" :total-filtered="$transactions->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome" />
        <x-filter.input name="date_start" type="date" title="Data inicial" />
        <x-filter.input name="date_end" type="date" title="Data final" />
        <x-filter.select name="company_id" :options="$companies->pluck('name', 'id')->all()" placeholder="Todas as organizações" />
        <x-filter.select name="contact_id" :options="$contacts->pluck('name', 'id')->all()" placeholder="Todos os contatos" />
        <x-filter.select name="bank_account_id" :options="$bankAccounts->pluck('name', 'id')->all()" placeholder="Todas as contas" />
        <x-filter.select name="type" :options="$types" placeholder="Todos os tipos" />
    </x-table.filter>
@endsection

@section('table')
    <div class='row  table-header mt-5 mb-2' style="background-color: {{ $complementaryColor }}">
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
        <div class="row table2 position-relative"
            style="
     color: {{ $principalColor }};
     border-left-color: {{ $complementaryColor }}
     ">
            <a class='stretched-link' href=' {{ route('transaction.show', ['transaction' => $transaction->id]) }}'>
            </a>
            <div class='cel col-2'>
                {{ dateBr($transaction->pay_day) }}
            </div>
            <div class='cel col-4'>
                @if (isset($transaction->invoice->opportunity))
                    <a href=' {{ route('opportunity.show', ['opportunity' => $transaction->invoice->opportunity_id]) }}'>
                        {{ $transaction->invoice->opportunity->name }}
                    </a>
                @else
                    não possui
                @endif
            </div>
            <div class='cel col-1'>
                @if ($transaction->invoice_id != null)
                    <a class='white' href=' {{ route('invoice.show', ['invoice' => $transaction->invoice_id]) }}'>
                        {{ $transaction->invoice_id }}
                    </a>
                @else
                    não possui
                @endif
            </div>
            <div class='cel col-2'>
                @if ($transaction->bankAccount)
                    <a class='white'
                        href=' {{ route('bankAccount.show', ['bankAccount' => $transaction->bankAccount->id]) }}'>
                        {{ $transaction->bankAccount->name }}
                    </a>
                @else
                    conta excluída
                @endif
            </div>
            <div class='cel col-2'>
                @if (app('request')->input('contact_id'))
                    <a class='white'
                        href=' {{ route('contact.show', ['contact' => app('request')->input('contact_id')]) }}'>
                        {{ $transaction->invoice->contact->name }}
                    </a>
                @elseif(isset($transaction->invoice->company->name))
                    <a class='white'
                        href=' {{ route('company.show', ['company' => $transaction->invoice->company->id]) }}'>
                        {{ $transaction->invoice->company->name }}
                    </a>
                @elseif(isset($transaction->invoice->contact->name))
                    <a class='white'
                        href=' {{ route('contact.show', ['contact' => $transaction->invoice->contact->id]) }}'>
                        {{ $transaction->invoice->contact->name }}
                    </a>
                @elseif($transaction->type == 'transferência')
                    {{ $transaction->account->name }}
                @else
                    Não possui
                @endif
            </div>
            @if ($transaction->value < 1)
                <div class='cel col-1 justify-content-end' style='color:red'>
                    {{ formatCurrencyReal($transaction->value) }}
                </div>
            @else
                <div class='cel col-1 justify-content-end'>
                    {{ formatCurrencyReal($transaction->value) }}
                </div>
            @endif
        </div>
    @endforeach

    <div class='row  table-header mt-5 mb-2' style="background-color: {{ $complementaryColor }}">
        <div class='offset-9 col-1'>
            TOTAL
        </div>
        <div class='col-2 justify-content-end pe-0'>
            {{ formatCurrencyReal($transactionsTotal) }}
        </div>
    </div>

@endsection

@section('pagination')
    <div class="mt-3">{{ $transactions->appends(request()->query())->links() }}</div>
@endsection
