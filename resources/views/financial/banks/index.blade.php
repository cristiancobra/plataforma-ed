@extends('layouts/index')

@section('title', 'BANCOS')

@section('image-top')
    <i class="fas fa-university"></i>
@endsection

@section('description')
    Total: <span class="labels"></span>
@endsection

@section('buttons')
    <x-buttons.create model="bank" :principalColor="$principalColor ?? null" />
@endsection

@section('table')
    <x-table.header :background-color="$principalColor" :columns="[
        ['label' => 'ID', 'class' => 'col-1'],
        ['label' => 'NOME', 'class' => 'col-9'],
        ['label' => 'CÓDIGO', 'class' => 'col-2'],
    ]" />
    @foreach ($banks as $bank)
        <div class="row row-link border-bottom py-2 align-items-center" data-href="{{ route('bank.show', ['bank' => $bank->id]) }}">
            <div class="col-1 small">{{ $bank->id }}</div>
            <div class="col-9 fw-bold small">{{ $bank->name }}</div>
            <div class="col-2 text-center small">{{ $bank->bank_code }}</div>
        </div>
    @endforeach
@endsection

@section('paginate', method_exists($banks, 'links') ? $banks->links() : '')
