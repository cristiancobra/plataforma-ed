@extends('layouts/index')

@section('title', $config['title'])

@section('image-top')
    <i class="{{ $config['icon'] }}"></i>
@endsection


@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'proposal'" />

    <x-buttons.create model="proposal" parameter="type" :value="$type" />
@endsection

@section('filter')
    <x-table.filter :action="route('proposal.index')" :reset-url="route('proposal.index', ['type' => $type])" :total-filtered="$proposals->total()"
        :filters-active="collect(request()->except(['page', 'trash', 'type']))->filter(fn ($v) => !is_null($v) && trim($v) !== '')->isNotEmpty()">
        <input type="hidden" name="type" value="{{ $type }}">
        @if (request('trash'))
            <input type="hidden" name="trash" value="1">
        @endif
        <x-filter.input name="name" placeholder="nome da proposta" />
        <x-filter.input name="date_start" type="date" title="Data inicial" />
        <x-filter.input name="date_end" type="date" title="Data final" />
        <x-filter.select name="company_id" :options="$companies->pluck('name', 'id')->all()" placeholder="Todas as organizações" />
        <x-filter.select name="contact_id" :options="$contacts->pluck('name', 'id')->all()" placeholder="Todos os contatos" />
        <x-filter.select name="product_id" :options="$products->pluck('name', 'id')->all()" placeholder="Todos os produtos" />
        <x-filter.select name="status" :options="returnInvoiceStatusToFilter()" placeholder="Todas as situações" />
    </x-table.filter>
@endsection

@section('table')
    <div class='row  table-header mt-5 mb-2' style="background-color: {{ $principalColor }}">
        <div class="col-4">
            NOME
        </div>
        <div class="col-2">
            CONTATO
        </div>
        <div class="col-2">
            {{ $config['companyLabel'] }}
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
            PAGAMENTO
        </div>
    </div>

    @foreach ($proposals as $proposal)
        <div class="row table2 position-relative"
            style="
     color: {{ $principalColor }};
     border-left-color: {{ $complementaryColor }}
     ">
            <a class="stretched-link "href=" {{ route('proposal.show', ['proposal' => $proposal, 'type' => $type]) }}">
            </a>
            <div class="cel col-4 justify-content-start">
                @if ($proposal->name)
                    {{ $proposal->name }}
                @else
                    Sem nome
                @endif
            </div>
            <div class="cel col-2">
                @if ($proposal->contact)
                    {{ $proposal->contact->name }}
                @else
                    não possui
                @endif
            </div>
            <div class="cel col-2">
                @if (isset($proposal->company))
                    {{ $proposal->company->name }}
                @else
                    não possui
                @endif
            </div>
            @if ($proposal->status == 'aprovada' and $proposal->pay_day < date('Y-m-d'))
                <div class="cel col-1" style="color: red">
                    {{ date('d/m/Y', strtotime($proposal->pay_day)) }}
                </div>
            @else
                <div class="cel col-1">
                    {{ date('d/m/Y', strtotime($proposal->pay_day)) }}
                </div>
            @endif

            @if ($proposal->totalPrice > 0)
                <div class="cel col-1 justify-content-end">
                    {{ formatCurrencyReal($proposal->totalPrice) }}
                </div>
            @else
                <div class="cel col-1 justify-content-end" style="color: red">
                    {{ formatCurrencyReal($proposal->totalPrice) }}
                </div>
            @endif

            @if ($proposal->paid > 0)
                <div class="cel col-1 justify-content-end">
                    {{ formatCurrencyReal($proposal->balance) }}
                </div>
            @else
                <div class="cel col-1 justify-content-end" style="color: red">
                    {{ formatCurrencyReal($proposal->balance) }}
                </div>
            @endif

            <div class="cel col-1">
                {{ faiconInvoiceStatus($proposal->status) }}
            </div>

        </div>
    @endforeach

@endsection

@section('pagination')
    <div class="mt-3">{{ $proposals->appends(request()->query())->links() }}</div>
@endsection
