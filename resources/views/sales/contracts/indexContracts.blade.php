@extends('layouts/index')

@section('title', 'CONTRATOS')

@section('image-top')
    <i class="fas fa-file-signature"></i>
@endsection

@section('description')
@endsection

@section('buttons')
    <a class="circular-button secondary" href="{{ route('contractTemplate.index') }}">
        <i class="fa fa-copy" aria-hidden="true"></i>
    </a>
    <x-buttons.create model="contract" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'TÍTULO', 'class' => 'col-4'],
        ['label' => 'CONTRATANTE', 'class' => 'col-2'],
        ['label' => 'RESPONSÁVEL', 'class' => 'col-2'],
        ['label' => 'INÍCIO', 'class' => 'col-1'],
        ['label' => 'VENCIMENTO', 'class' => 'col-1'],
        ['label' => 'SITUAÇÃO', 'class' => 'col-2'],
    ]" />
    @php
        $statusColors = ['cancelado' => ['#FFEBEE', '#C62828'], 'rascunho' => ['#ECEFF1', '#546E7A'], 'enviado' => ['#FFF8E1', '#B26A00'], 'assinado' => ['#E8F5E9', '#2E7D32']];
    @endphp
    @foreach ($contracts as $contract)
        @php
            if ($contract->status == 'assinado' && $contract->date_due < date('Y-m-d')) {
                [$statusLabel, $statusColor] = ['vencido', ['#FFEBEE', '#C62828']];
            } elseif ($contract->status == 'assinado' && $contract->date_start <= date('Y-m-d')) {
                [$statusLabel, $statusColor] = ['vigente', ['#E3F2FD', '#1565C0']];
            } else {
                [$statusLabel, $statusColor] = [$contract->status, $statusColors[$contract->status] ?? null];
            }
        @endphp
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('contract.show', ['contract' => $contract]) }}">
            <div class="col-4 fw-bold small">
                <a href="{{ route('contract.edit', ['contract' => $contract]) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Editar" onclick="event.stopPropagation()"><i class="fa fa-edit"></i></a>
                {{ $contract->name }}
            </div>
            <div class="col-2 text-center small">{{ $contract->company->name }}</div>
            <div class="col-2 text-center small">{{ $contract->userContact->name }}</div>
            <div class="col-1 text-center small">{{ dateBr($contract->date_start) }}</div>
            <div class="col-1 text-center small">{{ dateBr($contract->date_due) }}</div>
            <div class="col-2 text-center">
                <x-table.badge :label="$statusLabel" :colors="$statusColor" />
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', $contracts->links())
