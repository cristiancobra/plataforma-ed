@extends('layouts/index')

@section('title', 'EMPRÉSTIMOS')

@section('image-top')
    <i class="fa fa-exchange-alt"></i>
@endsection

@section('buttons')
    <x-buttons.trash-index :trash-status="$trashStatus" :parameter="'loan'" />
    <x-buttons.create model="loan" />
@endsection


@section('filter')

    <x-table.filter :action="route('loan.index')" :reset-url="route('loan.index')" :filters-active="$filtersActive" :total-filtered="$totalFiltered" :total-total="$totalTotal">
        <x-filter.select name="status" :options="$statusSelectOptions" placeholder="Todas as situações" />
        <x-filter.select name="lender_id" :options="$lenderSelectOptions" placeholder="Todos os credores" />
        <x-filter.input name="borrower_name" placeholder="nome do devedor" />
        <x-filter.input name="due_date_from" type="date" placeholder="Vencimento de" />
        <x-filter.input name="due_date_to" type="date" placeholder="Vencimento até" />
        <x-filter.checkbox name="overdue" label="Apenas atrasados" value="1" />
    </x-table.filter>
@endsection


@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'ID', 'class' => 'col-1'],
        ['label' => 'CREDOR', 'class' => 'col-2'],
        ['label' => 'DEVEDOR', 'class' => 'col-2'],
        ['label' => 'ITENS', 'class' => 'col-2'],
        ['label' => 'EMPRÉSTIMO', 'class' => 'col-1'],
        ['label' => 'VENCIMENTO', 'class' => 'col-1'],
        ['label' => 'DEVOLUÇÃO', 'class' => 'col-1'],
        ['label' => 'STATUS', 'class' => 'col-1'],
        ['label' => 'VER', 'class' => 'col-1'],
    ]" />
    @foreach ($loans as $loan)
        <div class="row border-bottom align-items-center {{ $loan->isOverdue() ? 'bg-danger bg-opacity-10' : '' }}">
            <div class="col-1 text-center">
                #{{ $loan->id }}
            </div>
            <div class="col-2">
                @if ($loan->lender && $loan->lender->contact)
                    {{ $loan->lender->contact->name }}
                @else
                    {{ $loan->lender->name ?? '-' }}
                @endif
            </div>
            <div class="col-2">
                {{ $loan->getBorrowerName() }}
                <small class="text-muted">({{ $loan->getBorrowerType() === 'user' ? 'Usuário' : 'Contato' }})</small>
            </div>
            <div class="col-2">
                <strong>{{ $loan->collections->count() }}</strong>
                @if ($loan->collections->count() === 1)
                    item:
                @else
                    itens:
                @endif
                <br>
                <small>
                    @foreach ($loan->collections->take(2) as $collection)
                        {{ $collection->name }}@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                    @if ($loan->collections->count() > 2)
                        <span class="text-muted">... (+{{ $loan->collections->count() - 2 }})</span>
                    @endif
                </small>
            </div>
            <div class="col-1 text-center">
                {{ $loan->start_date->format('d/m/Y') }}
            </div>
            <div class="col-1 text-center">
                {{ $loan->due_date->format('d/m/Y') }}
            </div>
            <div class="col-1 text-center">
                {{ $loan->returned_date ? $loan->returned_date->format('d/m/Y') : '-' }}
            </div>
            <div class="col-1 text-center">
                @if ($loan->isOverdue())
                    <span class="badge bg-danger">Atrasado</span>
                @else
                    @switch($loan->status)
                        @case('pending')
                            <span class="badge bg-secondary">Pendente</span>
                        @break

                        @case('active')
                            <span class="badge bg-primary">Ativo</span>
                        @break

                        @case('returned')
                            <span class="badge bg-success">Devolvido</span>
                        @break

                        @case('cancelled')
                            <span class="badge bg-dark">Cancelado</span>
                        @break

                        @default
                            {{ $loan->status }}
                    @endswitch
                @endif
            </div>
            <div class="col-1 text-center">
                <x-buttons.details :href="route('loan.show', ['loan' => $loan->id])" title="Visualizar empréstimo" :color="$principalColor" :size="32" />
            </div>
        </div>
    @endforeach
@endsection

@section('pagination')
    {{ $loans->appends(request()->query())->links() }}
@endsection
