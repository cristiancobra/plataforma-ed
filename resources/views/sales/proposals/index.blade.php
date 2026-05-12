@extends('layouts/index')

@section('title', $config['title'])

@section('image-top')
    <i class="{{ $config['icon'] }}"></i>
@endsection


@section('buttons')
    <x-buttons.filter />
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'proposal'" />

    <x-buttons.create model="proposal" parameter="type" :value="$type" />
@endsection

@section('table')
    <div class="row mb-4" id="filter" style="display:none;">
        <form action="{{ route('proposal.index') }}" method="get">
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="name"
                        placeholder="Nome da oportunidade" value="{{ request('name') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control form-control-sm" name="date_start"
                        value="{{ request('date_start') ?? old('date_start') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control form-control-sm" name="date_end"
                        value="{{ request('date_end') ?? old('date_end') }}">
                </div>
                <div class="col-md-4">
                    {{ createFilterSelectModels('company_id', '', $companies, 'Todas as empresas') }}
                </div>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    {{ createFilterSelectModels('contact_id', '', $contacts, 'Todos os contatos') }}
                </div>
                <div class="col-md-4">
                    {{ createFilterSelectModels('product_id', '', $products, 'Todos os produtos') }}
                </div>
                <div class="col-md-4">
                    {{ createFilterSelect('status', '', returnInvoiceStatusToFilter(), 'Todas as situações') }}
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-end">
                    <a class="text-button secondary" href='{{ route('proposal.index', ['type' => $type]) }}'>
                        LIMPAR
                    </a>
                    <input class="text-button primary" type="submit" value="FILTRAR">
                </div>
            </div>
        </form>
    </div>

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

    <p style="text-align: right">
        <br>
        {{ $proposals->links() }}
    </p>
    <br>
@endsection
