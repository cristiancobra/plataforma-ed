@extends('layouts/index')

@section('title', 'CONTAS BANCÁRIAS')

@section('image-top')
    <i class="fas fa-university"></i>
@endsection

@section('description')
    Total: <span class="labels"></span>
@endsection

@section('buttons')
    <x-buttons.create model="bankAccount" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'NOME', 'class' => 'col-3'],
        ['label' => 'AGÊNCIA', 'class' => 'col-2'],
        ['label' => 'CONTA', 'class' => 'col-2'],
        ['label' => 'CHAVE PIX', 'class' => 'col-2'],
        ['label' => 'DONO', 'class' => 'col-2'],
        ['label' => 'SITUAÇÃO', 'class' => 'col'],
    ]" />
    @php
        $statusColors = ['desativada' => ['#FFEBEE', '#C62828'], 'ativa' => ['#E8F5E9', '#2E7D32'], 'recebendo' => ['#E3F2FD', '#1565C0']];
    @endphp
    @foreach ($bankAccounts as $bankAccount)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('bankAccount.show', ['bankAccount' => $bankAccount->id]) }}">
            <div class="col-3 fw-bold small">
                <a href="{{ route('bankAccount.edit', ['bankAccount' => $bankAccount->id]) }}" class="btn btn-sm btn-outline-secondary rounded-circle me-1" title="Editar" onclick="event.stopPropagation()"><i class="fa fa-edit"></i></a>
                {{ $bankAccount->name }}
            </div>
            <div class="col-2 text-center small">{{ $bankAccount->agency }}</div>
            <div class="col-2 text-center small">{{ $bankAccount->account_number }}</div>
            <div class="col-2 text-center small">{{ $bankAccount->pix }}</div>
            <div class="col-2 text-center small">{{ $bankAccount->account->name }}</div>
            <div class="col text-center">
                <x-table.badge :label="$bankAccount->status" :colors="$statusColors[$bankAccount->status] ?? null" />
            </div>
        </div>
    @endforeach
@endsection

@section('paginate', method_exists($bankAccounts, 'links') ? $bankAccounts->links() : '')
