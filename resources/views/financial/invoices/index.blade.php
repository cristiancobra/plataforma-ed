@extends('layouts/index')

@section('title', 'FATURAS')

@section('image-top')
    <i class="fas fa-file-invoice-dollar"></i>
@endsection

@section('filter')
    <x-table.filter :action="route('invoice.index')" :reset-url="route('invoice.index')" :total-filtered="$invoices->total()">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome da proposta" />
        <x-filter.input name="date_start" type="date" title="Data inicial" />
        <x-filter.input name="date_end" type="date" title="Data final" />
        <x-filter.select name="company_id" :options="$companies->pluck('name', 'id')->all()" placeholder="Todas as organizações" />
        <x-filter.select name="contact_id" :options="$contacts->pluck('name', 'id')->all()" placeholder="Todos os contatos" />
        <x-filter.select name="status" :options="returnInvoiceStatusToFilter()" placeholder="Todas as situações" />
        <x-filter.select name="type" :options="['receita', 'despesa']" placeholder="Todos os tipos" />
    </x-table.filter>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="request('trash')" :parameter="'invoice'" />
    <x-buttons.icon icon="fas fa-minus" title="Nova despesa" :href="route('proposal.create', ['type' => 'despesa'])" :principalColor="$principalColor" />
    <x-buttons.icon icon="fas fa-plus" title="Nova receita" :href="route('proposal.create', ['type' => 'receita'])" :principalColor="$principalColor" />
@endsection

@section('shortcuts')
    <div class='col-2 offset-4 d-inline-block tasks-my mt-3 mb-5 me-5'>
        <a style='text-decoration:none'
            href='{{ route('invoice.index', [
                'date_start' => $monthStart,
                'date_end' => $monthEnd,
            ]) }}'>
            <p class='panel-text' style="font-size: 20px">
                MÊS
                <br>
                ATUAL
            </p>
        </a>
    </div>
    <div class='col-6'>
        <div class='row  table-header mb-2' style="background-color: {{ $principalColor }}">
            <div class='col-1'>
                PREVISÃO
            </div>
            <div class="cel col">
                MÊS
            </div>
            <div class="cel col">
                ANO
            </div>
        </div>
        <div class='row'>
            <div class="cel col justify-content-start">
                RECEITAS:
            </div>
            <div class="cel col justify-content-end">
                + {{ formatCurrencyReal($estimatedRevenueMonthly) }}
            </div>
            <div class="cel col justify-content-end">
                + {{ formatCurrencyReal($estimatedRevenueYearly) }}
            </div>
        </div>
        <div class='row'>
            <div class="cel col justify-content-start">
                DESPESAS:
            </div>
            <div class="cel col justify-content-end">
                - {{ formatCurrencyReal($estimatedExpenseMonthly) }}
            </div>
            <div class="cel col justify-content-end">
                - {{ formatCurrencyReal($estimatedExpenseYearly) }}
            </div>
        </div>
        <div class='row'>
            <div class="cel col justify-content-start">
                SALDO:
            </div>
            <div class="cel col justify-content-end">
                {{ formatCurrencyReal($estimatedRevenueMonthly - $estimatedExpenseMonthly) }}
            </div>
            <div class="cel col justify-content-end">
                {{ formatCurrencyReal($estimatedRevenueYearly - $estimatedExpenseYearly) }}
            </div>
        </div>
    </div>
@endsection


@section('table')
    <div class='row  table-header mt-5 mb-2' style="background-color: {{ $principalColor }}">
        <div class='col-1'>
            ID
        </div>
        <div class="col-3">
            PROPOSTA
        </div>
        <div class="col-2">
            CONTATO
        </div>
        <div class="col-2">
            ORGANIZAÇÃO
        </div>
        <div class="col-1">
            VENCIMENTO
        </div>
        <div class="col-1">
            TOTAL
        </div>
        <div class="col-1">
            SALDO
        </div>
        <div class="col-1">
            SITUAÇÃO
        </div>
    </div>

    @foreach ($invoices as $invoice)
        <div class="row table2 position-relative"
            style="
     color: {{ $principalColor }};
     border-left-color: {{ $complementaryColor }}
     ">
            <a class="stretched-link "href=" {{ route('invoice.show', ['invoice' => $invoice]) }}">
            </a>
            <div class='cel col-1'>
                {{ $invoice->identifier }}
            </div>
            <div class="cel col-3">
                @if (isset($invoice->proposal->name))
                    {{ $invoice->proposal->name }}
                @else
                    não possui
                @endif
            </div>
            <div class="cel col-2">
                @if ($invoice->contact)
                    {{ $invoice->contact->name }}
                @else
                    não possui
                @endif
            </div>
            <div class="cel col-2">
                @if (isset($invoice->proposal->company))
                    {{ $invoice->proposal->company->name }}
                @else
                    não possui
                @endif
            </div>
            @if ($invoice->status == 'aprovada' and $invoice->pay_day < date('Y-m-d'))
                <div class="cel col-1" style="color: red">
                    {{ date('d/m/Y', strtotime($invoice->pay_day)) }}
                </div>
            @else
                <div class="cel col-1">
                    {{ date('d/m/Y', strtotime($invoice->pay_day)) }}
                </div>
            @endif

            @if ($invoice->totalPrice >= 0)
                <div class="cel col-1 justify-content-end" style="text-align: right">
                    {{ formatCurrencyReal($invoice->totalPrice) }}
                </div>
            @else
                <div class="cel col-1 justify-content-end" style="color: red;text-align: right">
                    {{ formatCurrencyReal($invoice->totalPrice) }}
                </div>
            @endif

            @if ($invoice->totalPrice >= 0)
                <div class="cel col-1 justify-content-end" style="text-align: right">
                    {{ formatCurrencyReal($invoice->balance) }}
                </div>
            @else
                <div class="cel col-1 justify-content-end" style="color: red;text-align: right">
                    {{ formatCurrencyReal($invoice->balance) }}
                </div>
            @endif

            <div class="cel col-1" style="color: red;text-align: right">
                <a href=' {{ route('invoice.show', ['invoice' => $invoice]) }}'>
                    {{ faiconInvoiceStatus($invoice->status) }}
                </a>
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    <div class="mt-3">{{ $invoices->appends(request()->query())->links() }}</div>
@endsection
